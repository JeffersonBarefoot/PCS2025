# PCS2025 — Go-To-Market Plan

**Product:** Position control / workforce planning SaaS for mid-market companies  
**Target:** 200–5,000 employee companies managing headcount in-house  
**Buyer:** HR Director, VP HR, Compensation Analyst, or Budget/Finance Director  
**Pricing model:** Per active position, per month (~$3.00/position)

---

## Unfair Advantages

1. **30 years of domain expertise.** The edge cases, the reporting finance actually needs, the difference between how HR thinks about headcount vs. how Finance does — no competitor can fake that.

2. **An existing professional network.** Former clients, former colleagues, people worked alongside for decades are now VPs and Directors at other companies. That's the first call list — not cold outreach.

3. **The mid-market gap is still real.** Workday costs $500K+ to implement. BambooHR doesn't do real position control. The person managing headcount at a 600-person company is still doing it in Excel today.

---

## Phase 1 — Discovery (Week 1–2)

**Goal:** 20 names, 5 conversations. Not selling — listening.

- Make a list of 20 people from the last 30 years: former clients, colleagues, contacts in HR/comp/finance leadership
- Reach out personally: *"I'm rebuilding this. Would you spend 30 minutes telling me if the pain is still the same?"*
- Questions to ask:
  - What's your current process for tracking headcount and positions?
  - What breaks first / causes the most pain?
  - What does "good enough" look like — what would you pay to make that pain go away?
  - Who else in your org touches this problem?

**Output:** A short list of the 2–3 pain points that come up in every conversation. Those become the homepage headline.

---

## Phase 2 — Paid Pilots (Month 2)

**Goal:** 2 paying customers. Money changes hands.

- Convert 2 of the 5 conversations to paid pilots
- Pricing: $199–499/mo flat (manual invoice — no billing system needed yet)
- Give them full hands-on support. Be the "concierge."
- Watch what they actually use. Watch what confuses them.

**Output:** Real revenue, real usage data, real testimonials.

---

## Phase 3 — Productize What Pilots Actually Use (Month 3–4)

- Features they ignore → cut or deprioritize
- Workflows they ask about constantly → build next
- Rough edges they hit → fix immediately
- Wire up billing (Stripe metered — see `docs/billing-spec.md`)
- Deploy to production (Laravel Forge — see MVP list item #6)

---

## Phase 4 — Expand (Month 4+)

**Channels that work for niche B2B HR tools:**
- **Referrals from pilots** — ask directly: "Who else do you know with this problem?"
- **LinkedIn outreach** — HR Directors at 200–800 person companies. Message: *"Do you manage headcount in Excel?"*
- **HR software directories** — G2, Capterra, Software Advice (free listings)
- **HR communities** — SHRM forums, local SHRM chapter meetings, r/humanresources
- **HRIS/comp consultants** — they have clients who need this and no stake in the software

---

## Pricing Anchor

| Company size | Positions | Monthly | Annual |
|---|---|---|---|
| Small | 50 positions | $150/mo | $1,800/yr |
| Mid | 150 positions | $450/mo | $5,400/yr |
| Larger | 400 positions | $1,200/mo | $14,400/yr |

Volume discount (negotiated): rate drops to ~$2.00/position above a threshold.  
Trial: 30 days free, no card required.

---

## Key Risk

**The risk isn't building the wrong software** — this domain is well understood.  
**The risk is spending months finishing the product before talking to anyone.**

The product does not need to be complete to show someone. It needs to be coherent enough that a potential buyer can see their own problem reflected in it.

---

## Immediate Next Action

Make the list of 20 names. This week. Before writing another line of code.
