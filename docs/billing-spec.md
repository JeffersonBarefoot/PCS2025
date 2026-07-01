# PCS2025 — Billing Spec
**Approach:** Stripe Metered Billing via Laravel Cashier  
**Model:** Charge per max active positions in the prior calendar month  
**Rate:** Configurable per team ($3.00 default, negotiated rate stored in DB)

---

## 1. How It Works (end-to-end)

1. **Daily (midnight):** A scheduled job snapshots each team's active position count into `billing_snapshots`.
2. **Monthly (1st of month, ~2am):** A scheduled job reads the prior month's snapshots, finds the max per team, and reports that number to Stripe as metered usage.
3. **Stripe** calculates `max_positions × rate`, generates an invoice, and charges the stored card.
4. **Cashier** webhooks keep the local `teams` subscription status in sync (payment failed, cancelled, etc.).

---

## 2. Database Changes

### New table: `billing_snapshots`
```sql
CREATE TABLE billing_snapshots (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    team_id         BIGINT UNSIGNED NOT NULL,
    snapshot_date   DATE NOT NULL,
    active_positions INT UNSIGNED NOT NULL DEFAULT 0,
    created_at      TIMESTAMP NULL,
    updated_at      TIMESTAMP NULL,
    UNIQUE KEY uq_team_date (team_id, snapshot_date),
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE
);
```

Migration: `php artisan make:migration create_billing_snapshots_table`

### Add to `teams` table
```sql
ALTER TABLE teams
    ADD COLUMN billing_rate       DECIMAL(8,4) NOT NULL DEFAULT 3.0000,
    ADD COLUMN stripe_id          VARCHAR(255) NULL,
    ADD COLUMN pm_type            VARCHAR(255) NULL,
    ADD COLUMN pm_last_four       VARCHAR(4)   NULL,
    ADD COLUMN trial_ends_at      TIMESTAMP    NULL,
    ADD COLUMN billing_active     TINYINT(1)   NOT NULL DEFAULT 1;
```

> Note: `stripe_id`, `pm_type`, `pm_last_four`, `trial_ends_at` are the columns Cashier
> expects on a "billable" model. Check `config/cashier.php` for the exact column list.

Migration: `php artisan make:migration add_billing_fields_to_teams_table`

---

## 3. Laravel Cashier Setup

```bash
composer require laravel/cashier
php artisan vendor:publish --tag="cashier-migrations"
php artisan migrate
```

Make `Team` model billable:
```php
// app/Models/Team.php
use Laravel\Cashier\Billable;

class Team extends Model {
    use Billable;
    // Cashier uses 'stripe_id' column on this model — confirm column name matches
}
```

`config/cashier.php` — set the billable model:
```php
'model' => App\Models\Team::class,
```

`.env` additions:
```
STRIPE_KEY=pk_live_...
STRIPE_SECRET=sk_live_...
STRIPE_WEBHOOK_SECRET=whsec_...
```

---

## 4. Stripe Setup (Dashboard)

1. **Create a Product:** "PCS Position Management"
2. **Create a Price** on that product:
   - Billing: Recurring, Monthly
   - Pricing model: **Graduated / Volume** or **Per unit**
   - Usage type: **Metered**
   - Aggregation: **Maximum** (Stripe can aggregate max for you — or we report the max ourselves)
   - Unit amount: $3.00 (or set volume tiers — see §6)
3. Note the **Price ID** (e.g. `price_xxxxxxxxxxxxx`) — goes in `.env` as `STRIPE_METERED_PRICE_ID`

> For volume tiers in Stripe: set tier 1 as 1–50 units @ $3.00, tier 2 as 51+ @ $2.00.
> For per-customer negotiated rates: create a separate Price per rate and store the Price ID
> on the team, OR just report usage to a single metered price and apply a Stripe Coupon
> for discount customers. The coupon approach is simpler.

---

## 5. Daily Snapshot Job

```bash
php artisan make:command BillingDailySnapshot
```

```php
// app/Console/Commands/BillingDailySnapshot.php
class BillingDailySnapshot extends Command
{
    protected $signature = 'billing:snapshot';
    protected $description = 'Record active position count per team for billing';

    public function handle()
    {
        $today = now()->toDateString();

        Team::all()->each(function ($team) use ($today) {
            $count = DB::table('positions')
                ->where('teamid', $team->id)
                ->where('active', 'Y')
                ->count();

            DB::table('billing_snapshots')->updateOrInsert(
                ['team_id' => $team->id, 'snapshot_date' => $today],
                ['active_positions' => $count, 'updated_at' => now(), 'created_at' => now()]
            );
        });

        $this->info('Snapshot complete.');
    }
}
```

Schedule in `routes/console.php` (Laravel 11):
```php
Schedule::command('billing:snapshot')->dailyAt('00:05');
```

---

## 6. Monthly Usage Report Job

```bash
php artisan make:command BillingMonthlyReport
```

```php
// app/Console/Commands/BillingMonthlyReport.php
class BillingMonthlyReport extends Command
{
    protected $signature = 'billing:report {--month= : Y-m of month to report (default: last month)}';
    protected $description = 'Report max active positions to Stripe for the prior month';

    public function handle()
    {
        $month = $this->option('month')
            ? Carbon::parse($this->option('month').'-01')
            : now()->subMonthNoOverflow()->startOfMonth();

        $start = $month->copy()->startOfMonth()->toDateString();
        $end   = $month->copy()->endOfMonth()->toDateString();

        Team::whereNotNull('stripe_id')->each(function ($team) use ($start, $end, $month) {
            $max = DB::table('billing_snapshots')
                ->where('team_id', $team->id)
                ->whereBetween('snapshot_date', [$start, $end])
                ->max('active_positions') ?? 0;

            if ($max === 0) return; // nothing to bill

            // reportUsage($qty, $timestamp) — timestamp anchors it to the billing period
            $team->subscription('default')
                 ->reportUsage($max, $month->copy()->endOfMonth()->timestamp);

            $this->line("Team {$team->id}: reported {$max} positions for {$month->format('Y-m')}");
        });
    }
}
```

Schedule in `routes/console.php`:
```php
Schedule::command('billing:report')->monthlyOn(1, '02:00');
```

Manual re-run for a specific month:
```bash
php artisan billing:report --month=2026-05
```

---

## 7. Per-Customer Rate

Two approaches:

**A — Stripe Coupon (simpler):** All teams subscribe to the same $3.00 price. High-volume
customers get a Stripe coupon (e.g. 33% off → effective $2.00). Apply via:
```php
$team->newSubscription('default', env('STRIPE_METERED_PRICE_ID'))
     ->withCoupon('VOLUME_DISCOUNT')
     ->create($paymentMethodId);
```

**B — Rate column (more explicit):** Store `billing_rate` on `teams`. In the monthly report
job, after getting `$max`, calculate `$charge = $max * $team->billing_rate` and use Stripe's
"invoice items" API to create a one-off charge instead of metered reporting. More code, full
flexibility, shows the rate explicitly on the invoice.

Recommendation: **Start with Coupon**, move to rate column if you need line-item customization.

---

## 8. Subscription Lifecycle

**New customer signs up:**
```php
$team->newSubscription('default', env('STRIPE_METERED_PRICE_ID'))
     ->trialDays(30)
     ->create($paymentMethodId); // $paymentMethodId from Stripe.js on frontend
```

**Check if team has access:**
```php
// Middleware or service provider
if (! $team->subscribed('default') && ! $team->onTrial()) {
    return redirect('/billing')->with('error', 'Subscription required.');
}
```

**Stripe → app webhooks** (auto-handled by Cashier):
- `invoice.payment_succeeded` — marks subscription active
- `invoice.payment_failed` — Cashier fires `Cashier::$paymentFailedNotification`
- `customer.subscription.deleted` — marks subscription cancelled

Register webhook route in `routes/web.php`:
```php
Route::post('/stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');
```

Exclude from CSRF in `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->validateCsrfTokens(except: ['stripe/*']);
})
```

---

## 9. Customer Billing Page (MVP)

Minimal `/billing` page needs:
- Current plan info: `$team->subscription('default')`
- Last month's usage: query `billing_snapshots`
- "Update payment method" → redirect to Stripe Customer Portal:
  ```php
  return $team->redirectToBillingPortal(route('billing.show'));
  ```
- Trial end date if applicable: `$team->trial_ends_at`

---

## 10. Open Questions / Decisions Needed

- [ ] **Grace period after payment failure?** (e.g., 3-day grace before locking out)
- [ ] **Free tier?** First N positions free? Or pure pay-per-use from day 1?
- [ ] **Minimum monthly charge?** e.g., $15 minimum regardless of position count?
- [ ] **Invoice display name?** What should the line item say on the Stripe invoice?
- [ ] **Who manages coupon/rate negotiation?** Admin UI needed or manual Stripe dashboard?
- [ ] **Billing contact:** Bill the team owner? Or a separate billing contact email?

---

## Implementation Order

1. Install Cashier, create migrations, run `php artisan migrate`
2. Set up Stripe product + metered price in dashboard, copy Price ID to `.env`
3. Wire `Billable` trait onto `Team` model
4. Write and test `billing:snapshot` command locally
5. Write and test `billing:report` command against Stripe test mode
6. Register webhook, test with Stripe CLI (`stripe listen --forward-to localhost/stripe/webhook`)
7. Build minimal `/billing` page
8. Add subscription gate middleware
9. Deploy, switch to live Stripe keys
