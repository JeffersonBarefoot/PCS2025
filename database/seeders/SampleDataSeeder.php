<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleDataSeeder extends Seeder
{
    private int    $teamId;
    private string $co = 'ACME';

    public function run(): void
    {
        // MySQL's default collation is case-insensitive, so this matches any casing of the address
        $user = User::where('email', 'Jefferson.L.Barefoot@gmail.com')->first();
        if (!$user) {
            $user = User::factory()->withPersonalTeam()->create([
                'name'  => 'Jeff Barefoot',
                'email' => 'Jefferson.L.Barefoot@gmail.com',
            ]);
        }

        // Ensure the personal team is named correctly
        $team = $user->currentTeam ?? $user->ownedTeams()->first();
        $team->update(['name' => 'Acme Corporation']);
        $user->update(['current_team_id' => $team->id]);
        $user->refresh();

        $this->teamId = $user->currentTeam->id;

        $pos  = $this->seedPositions();
        $inc  = $this->seedIncumbents($pos);
        $this->seedPositionHistory($pos);
        $this->seedIncumbentHistory($inc, $pos);
    }

    // ---------------------------------------------------------------
    // POSITIONS
    // ---------------------------------------------------------------
    private function seedPositions(): array
    {
        $p = [];
        $ins = fn(array $f) => DB::table('positions')->insertGetId($this->pos($f));

        // EXECUTIVE — New York
        $p['ceo']    = $ins(['posno'=>'10100','descr'=>'Chief Executive Officer',    'level1'=>'NY','level2'=>'EXEC',   'budgsal'=>260000,'payrate'=>10000,'salgrade'=>'EXEC1','salupper'=>300000,'sallower'=>200000,'reptoposno'=>'','reptodesc'=>'Board of Directors',  'curstatus'=>'FILLED',   'startdate'=>'2015-01-01','historystart'=>'2022-01-01','historyreason'=>'Annual budget increase FY2022']);
        $p['cfo']    = $ins(['posno'=>'10200','descr'=>'Chief Financial Officer',    'level1'=>'NY','level2'=>'EXEC',   'budgsal'=>200000,'payrate'=>7692, 'salgrade'=>'EXEC1','salupper'=>240000,'sallower'=>160000,'reptoposno'=>'10100','reptodesc'=>'Chief Executive Officer','curstatus'=>'FILLED', 'startdate'=>'2015-01-01','historystart'=>'2021-01-01','historyreason'=>'Annual budget increase FY2021']);
        $p['vptech'] = $ins(['posno'=>'10500','descr'=>'VP Technology',              'level1'=>'NY','level2'=>'EXEC',   'budgsal'=>180000,'payrate'=>6923, 'salgrade'=>'EXEC2','salupper'=>210000,'sallower'=>150000,'reptoposno'=>'10100','reptodesc'=>'Chief Executive Officer','curstatus'=>'VACANT',  'startdate'=>'2023-03-01','historystart'=>'2023-03-01','historyreason'=>'New position created - digital transformation initiative']);
        $p['vpops']  = $ins(['posno'=>'10300','descr'=>'VP Operations',              'level1'=>'NY','level2'=>'EXEC',   'budgsal'=>160000,'payrate'=>6154, 'salgrade'=>'EXEC2','salupper'=>190000,'sallower'=>130000,'reptoposno'=>'10100','reptodesc'=>'Chief Executive Officer','curstatus'=>'FILLED',  'startdate'=>'2015-01-01','historystart'=>'2022-01-01','historyreason'=>'Annual budget increase FY2022']);
        $p['vpsales']= $ins(['posno'=>'10400','descr'=>'VP Sales',                   'level1'=>'CHI','level2'=>'EXEC',  'budgsal'=>165000,'payrate'=>6346, 'salgrade'=>'EXEC2','salupper'=>195000,'sallower'=>135000,'reptoposno'=>'10100','reptodesc'=>'Chief Executive Officer','curstatus'=>'FILLED',  'startdate'=>'2015-01-01','historystart'=>'2021-07-01','historyreason'=>'Title upgrade from Director of Sales']);

        // FINANCE — Chicago
        $p['ctrl']   = $ins(['posno'=>'20100','descr'=>'Controller',                 'level1'=>'CHI','level2'=>'FINANCE','budgsal'=>110000,'payrate'=>4231, 'salgrade'=>'MGR2', 'salupper'=>130000,'sallower'=>90000, 'reptoposno'=>'10200','reptodesc'=>'Chief Financial Officer','curstatus'=>'FILLED',  'startdate'=>'2015-01-01','historystart'=>'2022-07-01','historyreason'=>'Reclassification - expanded scope']);
        $p['sracct'] = $ins(['posno'=>'20200','descr'=>'Senior Accountant',          'level1'=>'CHI','level2'=>'FINANCE','budgsal'=>75000, 'payrate'=>2885, 'salgrade'=>'PROF2','salupper'=>90000, 'sallower'=>60000, 'reptoposno'=>'20100','reptodesc'=>'Controller',             'curstatus'=>'FILLED',  'startdate'=>'2016-04-01','historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023']);
        $p['apc']    = $ins(['posno'=>'20300','descr'=>'AP Clerk',                   'level1'=>'CHI','level2'=>'FINANCE','budgsal'=>48000, 'payrate'=>1846, 'salgrade'=>'STAFF1','salupper'=>58000,'sallower'=>40000, 'reptoposno'=>'20100','reptodesc'=>'Controller',             'curstatus'=>'FILLED',  'startdate'=>'2016-04-01','historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023','exempt'=>'N']);
        $p['arc']    = $ins(['posno'=>'20400','descr'=>'AR Clerk',                   'level1'=>'CHI','level2'=>'FINANCE','budgsal'=>48000, 'payrate'=>1846, 'salgrade'=>'STAFF1','salupper'=>58000,'sallower'=>40000, 'reptoposno'=>'20100','reptodesc'=>'Controller',             'curstatus'=>'VACANT',  'startdate'=>'2016-04-01','historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023','exempt'=>'N']);
        $p['pyrl']   = $ins(['posno'=>'20500','descr'=>'Payroll Specialist',         'level1'=>'CHI','level2'=>'FINANCE','budgsal'=>62000, 'payrate'=>2385, 'salgrade'=>'PROF1','salupper'=>74000, 'sallower'=>52000, 'reptoposno'=>'20100','reptodesc'=>'Controller',             'curstatus'=>'FILLED',  'startdate'=>'2018-01-01','historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023']);

        // IT — New York
        $p['itmgr']  = $ins(['posno'=>'30100','descr'=>'IT Manager',                 'level1'=>'NY','level2'=>'IT',     'budgsal'=>120000,'payrate'=>4615, 'salgrade'=>'MGR2', 'salupper'=>145000,'sallower'=>95000, 'reptoposno'=>'10500','reptodesc'=>'VP Technology',          'curstatus'=>'FILLED',  'startdate'=>'2015-01-01','historystart'=>'2023-07-01','historyreason'=>'Budget increase - retained key talent']);
        $p['srdev']  = $ins(['posno'=>'30200','descr'=>'Senior Developer',           'level1'=>'NY','level2'=>'IT',     'budgsal'=>105000,'payrate'=>4038, 'salgrade'=>'PROF3','salupper'=>125000,'sallower'=>85000, 'reptoposno'=>'30100','reptodesc'=>'IT Manager',             'curstatus'=>'PARTIALLY FILLED','startdate'=>'2018-06-01','historystart'=>'2023-01-01','historyreason'=>'Incumbent moved to 0.50 FTE - phased retirement','fulltimeequiv'=>1.0]);
        $p['dev']    = $ins(['posno'=>'30300','descr'=>'Developer',                  'level1'=>'NY','level2'=>'IT',     'budgsal'=>85000, 'payrate'=>3269, 'salgrade'=>'PROF2','salupper'=>100000,'sallower'=>68000, 'reptoposno'=>'30100','reptodesc'=>'IT Manager',             'curstatus'=>'FILLED',  'startdate'=>'2018-06-01','historystart'=>'2023-01-15','historyreason'=>'Position refilled - salary adjusted to market']);
        $p['hdesk']  = $ins(['posno'=>'30400','descr'=>'Help Desk Analyst',          'level1'=>'NY','level2'=>'IT',     'budgsal'=>55000, 'payrate'=>2115, 'salgrade'=>'STAFF2','salupper'=>65000,'sallower'=>44000, 'reptoposno'=>'30100','reptodesc'=>'IT Manager',             'curstatus'=>'VACANT',  'startdate'=>'2019-01-01','historystart'=>'2024-06-01','historyreason'=>'Backfill - incumbent resigned','exempt'=>'N']);
        $p['netadm'] = $ins(['posno'=>'30500','descr'=>'Network Administrator',      'level1'=>'NY','level2'=>'IT',     'budgsal'=>78000, 'payrate'=>3000, 'salgrade'=>'PROF2','salupper'=>92000, 'sallower'=>64000, 'reptoposno'=>'30100','reptodesc'=>'IT Manager',             'curstatus'=>'FILLED',  'startdate'=>'2017-03-01','historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023']);

        // HR — New York
        $p['hrmgr']  = $ins(['posno'=>'40100','descr'=>'HR Manager',                 'level1'=>'NY','level2'=>'HR',     'budgsal'=>90000, 'payrate'=>3462, 'salgrade'=>'MGR2', 'salupper'=>108000,'sallower'=>72000, 'reptoposno'=>'10100','reptodesc'=>'Chief Executive Officer','curstatus'=>'FILLED',  'startdate'=>'2015-01-01','historystart'=>'2022-01-01','historyreason'=>'Annual budget increase FY2022']);
        $p['hrgen']  = $ins(['posno'=>'40200','descr'=>'HR Generalist',              'level1'=>'NY','level2'=>'HR',     'budgsal'=>65000, 'payrate'=>2500, 'salgrade'=>'PROF1','salupper'=>78000, 'sallower'=>52000, 'reptoposno'=>'40100','reptodesc'=>'HR Manager',             'curstatus'=>'FILLED',  'startdate'=>'2019-06-01','historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023']);
        $p['benfts'] = $ins(['posno'=>'40300','descr'=>'Benefits Coordinator',       'level1'=>'NY','level2'=>'HR',     'budgsal'=>60000, 'payrate'=>2308, 'salgrade'=>'PROF1','salupper'=>72000, 'sallower'=>48000, 'reptoposno'=>'40100','reptodesc'=>'HR Manager',             'curstatus'=>'VACANT',  'startdate'=>'2019-06-01','historystart'=>'2025-01-01','historyreason'=>'Backfill - incumbent transferred to Benefits Manager role','exempt'=>'N']);
        $p['recr']   = $ins(['posno'=>'40400','descr'=>'Recruiter',                  'level1'=>'NY','level2'=>'HR',     'budgsal'=>68000, 'payrate'=>2615, 'salgrade'=>'PROF1','salupper'=>80000, 'sallower'=>55000, 'reptoposno'=>'40100','reptodesc'=>'HR Manager',             'curstatus'=>'FILLED',  'startdate'=>'2020-03-01','historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023']);
        $p['rcpt']   = $ins(['posno'=>'40500','descr'=>'Receptionist',               'level1'=>'NY','level2'=>'HR',     'budgsal'=>40000, 'payrate'=>1538, 'salgrade'=>'STAFF1','salupper'=>48000,'sallower'=>33000, 'reptoposno'=>'40100','reptodesc'=>'HR Manager',             'curstatus'=>'FILLED',  'startdate'=>'2015-01-01','historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023','exempt'=>'N']);

        // OPERATIONS — Chicago
        $p['opsmgr'] = $ins(['posno'=>'50100','descr'=>'Operations Manager',         'level1'=>'CHI','level2'=>'OPS',   'budgsal'=>95000, 'payrate'=>3654, 'salgrade'=>'MGR2', 'salupper'=>114000,'sallower'=>76000, 'reptoposno'=>'10300','reptodesc'=>'VP Operations',         'curstatus'=>'FILLED',  'startdate'=>'2015-01-01','historystart'=>'2022-01-01','historyreason'=>'Annual budget increase FY2022']);
        $p['whsup']  = $ins(['posno'=>'50200','descr'=>'Warehouse Supervisor',       'level1'=>'CHI','level2'=>'OPS',   'budgsal'=>68000, 'payrate'=>2615, 'salgrade'=>'SUP1', 'salupper'=>80000, 'sallower'=>55000, 'reptoposno'=>'50100','reptodesc'=>'Operations Manager',    'curstatus'=>'FILLED',  'startdate'=>'2016-07-01','historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023','exempt'=>'N']);
        $p['invan']  = $ins(['posno'=>'50300','descr'=>'Inventory Analyst',          'level1'=>'CHI','level2'=>'OPS',   'budgsal'=>58000, 'payrate'=>2231, 'salgrade'=>'PROF1','salupper'=>70000, 'sallower'=>46000, 'reptoposno'=>'50100','reptodesc'=>'Operations Manager',    'curstatus'=>'FILLED',  'startdate'=>'2017-09-01','historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023']);
        $p['cslead'] = $ins(['posno'=>'50400','descr'=>'Customer Service Lead',      'level1'=>'CHI','level2'=>'OPS',   'budgsal'=>52000, 'payrate'=>2000, 'salgrade'=>'STAFF2','salupper'=>62000,'sallower'=>42000, 'reptoposno'=>'50100','reptodesc'=>'Operations Manager',    'curstatus'=>'OVERFILLED','startdate'=>'2018-02-01','historystart'=>'2025-03-01','historyreason'=>'Overfilled - approved temporary dual coverage','exempt'=>'N']);

        // SALES — Chicago
        $p['slsmgr'] = $ins(['posno'=>'60100','descr'=>'Sales Manager',              'level1'=>'CHI','level2'=>'SALES', 'budgsal'=>95000, 'payrate'=>3654, 'salgrade'=>'MGR2', 'salupper'=>114000,'sallower'=>76000, 'reptoposno'=>'10400','reptodesc'=>'VP Sales',              'curstatus'=>'FILLED',  'startdate'=>'2015-01-01','historystart'=>'2023-07-01','historyreason'=>'Promotion fill - internal candidate']);
        $p['insa']   = $ins(['posno'=>'60200','descr'=>'Inside Sales Representative','level1'=>'CHI','level2'=>'SALES', 'budgsal'=>55000, 'payrate'=>2115, 'salgrade'=>'STAFF2','salupper'=>65000,'sallower'=>44000, 'reptoposno'=>'60100','reptodesc'=>'Sales Manager',         'curstatus'=>'FILLED',  'startdate'=>'2018-05-01','historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023','exempt'=>'N']);
        $p['insb']   = $ins(['posno'=>'60300','descr'=>'Inside Sales Representative','level1'=>'CHI','level2'=>'SALES', 'budgsal'=>55000, 'payrate'=>2115, 'salgrade'=>'STAFF2','salupper'=>65000,'sallower'=>44000, 'reptoposno'=>'60100','reptodesc'=>'Sales Manager',         'curstatus'=>'FILLED',  'startdate'=>'2018-05-01','historystart'=>'2024-01-01','historyreason'=>'Backfill after promotion of prior incumbent','exempt'=>'N']);
        $p['outsa']  = $ins(['posno'=>'60400','descr'=>'Outside Sales Representative','level1'=>'CHI','level2'=>'SALES','budgsal'=>70000, 'payrate'=>2692, 'salgrade'=>'PROF1','salupper'=>85000, 'sallower'=>56000, 'reptoposno'=>'60100','reptodesc'=>'Sales Manager',         'curstatus'=>'VACANT',  'startdate'=>'2021-01-01','historystart'=>'2025-04-01','historyreason'=>'Backfill - incumbent resigned']);

        return $p;
    }

    // ---------------------------------------------------------------
    // INCUMBENTS
    // ---------------------------------------------------------------
    private function seedIncumbents(array $p): array
    {
        $i   = [];
        $ins = fn(array $f) => DB::table('incumbents')->insertGetId($this->inc($f));

        // EXEC
        $i['ceo']    = $ins(['posid'=>$p['ceo'],   'posno'=>'10100','empno'=>'E001','fname'=>'Margaret','lname'=>'Thornton', 'level1'=>'NY', 'level2'=>'EXEC',   'ann_cost'=>258000,'unitrate'=>9923, 'lasthire'=>'2018-03-01','posstart'=>'2018-03-01','reason'=>'HIRE',    'jobtitle'=>'CEO',             'sex'=>'F','education'=>'MBA',   'historystart'=>'2022-01-01','historyreason'=>'Annual increase FY2022']);
        $i['cfo']    = $ins(['posid'=>$p['cfo'],   'posno'=>'10200','empno'=>'E002','fname'=>'Franklin', 'lname'=>'Webb',     'level1'=>'NY', 'level2'=>'EXEC',   'ann_cost'=>198000,'unitrate'=>7615, 'lasthire'=>'2016-09-12','posstart'=>'2016-09-12','reason'=>'HIRE',    'jobtitle'=>'CFO',             'sex'=>'M','education'=>'CPA',   'historystart'=>'2021-01-01','historyreason'=>'Annual increase FY2021']);
        $i['vpops']  = $ins(['posid'=>$p['vpops'], 'posno'=>'10300','empno'=>'E003','fname'=>'David',   'lname'=>'Castillo', 'level1'=>'NY', 'level2'=>'EXEC',   'ann_cost'=>157000,'unitrate'=>6038, 'lasthire'=>'2019-07-15','posstart'=>'2019-07-15','reason'=>'HIRE',    'jobtitle'=>'VP Operations',   'sex'=>'M','education'=>'MBA',   'historystart'=>'2022-01-01','historyreason'=>'Annual increase FY2022']);
        $i['vpsales']= $ins(['posid'=>$p['vpsales'],'posno'=>'10400','empno'=>'E004','fname'=>'Susan',  'lname'=>'Park',     'level1'=>'CHI','level2'=>'EXEC',   'ann_cost'=>163000,'unitrate'=>6269, 'lasthire'=>'2020-01-06','posstart'=>'2021-07-01','reason'=>'PROMO',   'jobtitle'=>'VP Sales',        'sex'=>'F','education'=>'MBA',   'historystart'=>'2021-07-01','historyreason'=>'Promoted to VP Sales']);

        // FINANCE
        $i['ctrl']   = $ins(['posid'=>$p['ctrl'],  'posno'=>'20100','empno'=>'E005','fname'=>'Robert',  'lname'=>'Okafor',   'level1'=>'CHI','level2'=>'FINANCE','ann_cost'=>108000,'unitrate'=>4154, 'lasthire'=>'2021-04-12','posstart'=>'2021-04-12','reason'=>'HIRE',    'jobtitle'=>'Controller',      'sex'=>'M','education'=>'CPA',   'historystart'=>'2022-07-01','historyreason'=>'Reclassification salary adjustment']);
        $i['sracct'] = $ins(['posid'=>$p['sracct'],'posno'=>'20200','empno'=>'E006','fname'=>'Linda',   'lname'=>'Chen',     'level1'=>'CHI','level2'=>'FINANCE','ann_cost'=>74000, 'unitrate'=>2846, 'lasthire'=>'2018-08-20','posstart'=>'2018-08-20','reason'=>'HIRE',    'jobtitle'=>'Sr Accountant',   'sex'=>'F','education'=>'BS-ACCT','historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023']);
        $i['apc']    = $ins(['posid'=>$p['apc'],   'posno'=>'20300','empno'=>'E007','fname'=>'Marcus',  'lname'=>'Rowe',     'level1'=>'CHI','level2'=>'FINANCE','ann_cost'=>47000, 'unitrate'=>1808, 'lasthire'=>'2022-03-14','posstart'=>'2022-03-14','reason'=>'HIRE',    'jobtitle'=>'AP Clerk',        'sex'=>'M','education'=>'HS',    'historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023','fulltimeequiv'=>1.0]);
        $i['pyrl']   = $ins(['posid'=>$p['pyrl'],  'posno'=>'20500','empno'=>'E008','fname'=>'Patricia','lname'=>'Kim',      'level1'=>'CHI','level2'=>'FINANCE','ann_cost'=>61000, 'unitrate'=>2346, 'lasthire'=>'2020-10-05','posstart'=>'2020-10-05','reason'=>'HIRE',    'jobtitle'=>'Payroll Specialist','sex'=>'F','education'=>'BS-ACCT','historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023']);

        // IT
        $i['itmgr']  = $ins(['posid'=>$p['itmgr'], 'posno'=>'30100','empno'=>'E009','fname'=>'Lisa',    'lname'=>'Nguyen',   'level1'=>'NY', 'level2'=>'IT',     'ann_cost'=>118000,'unitrate'=>4538, 'lasthire'=>'2017-09-01','posstart'=>'2017-09-01','reason'=>'HIRE',    'jobtitle'=>'IT Manager',      'sex'=>'F','education'=>'BS-CS', 'historystart'=>'2023-07-01','historyreason'=>'Retention increase']);
        $i['srdev']  = $ins(['posid'=>$p['srdev'],  'posno'=>'30200','empno'=>'E010','fname'=>'James',   'lname'=>'Whitfield','level1'=>'NY', 'level2'=>'IT',     'ann_cost'=>47500, 'unitrate'=>3654, 'lasthire'=>'2020-06-01','posstart'=>'2023-01-01','reason'=>'TRANSFER','jobtitle'=>'Sr Developer',     'sex'=>'M','education'=>'BS-CS', 'historystart'=>'2023-01-01','historyreason'=>'Transferred to Sr Dev - phased retirement 0.50 FTE','fulltimeequiv'=>0.50]);
        $i['dev']    = $ins(['posid'=>$p['dev'],    'posno'=>'30300','empno'=>'E011','fname'=>'Tyler',   'lname'=>'Banks',    'level1'=>'NY', 'level2'=>'IT',     'ann_cost'=>84000, 'unitrate'=>3231, 'lasthire'=>'2023-01-15','posstart'=>'2023-01-15','reason'=>'HIRE',    'jobtitle'=>'Developer',       'sex'=>'M','education'=>'BS-CS', 'historystart'=>'2023-01-15','historyreason'=>'New hire - backfill']);
        $i['netadm'] = $ins(['posid'=>$p['netadm'], 'posno'=>'30500','empno'=>'E012','fname'=>'Alex',    'lname'=>'Kim',      'level1'=>'NY', 'level2'=>'IT',     'ann_cost'=>77000, 'unitrate'=>2962, 'lasthire'=>'2019-05-20','posstart'=>'2019-05-20','reason'=>'HIRE',    'jobtitle'=>'Network Admin',   'sex'=>'M','education'=>'BS-CS', 'historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023']);

        // HR
        $i['hrmgr']  = $ins(['posid'=>$p['hrmgr'], 'posno'=>'40100','empno'=>'E013','fname'=>'Angela',  'lname'=>'Martinez', 'level1'=>'NY', 'level2'=>'HR',     'ann_cost'=>88000, 'unitrate'=>3385, 'lasthire'=>'2020-11-01','posstart'=>'2020-11-01','reason'=>'HIRE',    'jobtitle'=>'HR Manager',      'sex'=>'F','education'=>'MBA',   'historystart'=>'2022-01-01','historyreason'=>'Annual increase FY2022']);
        $i['hrgen']  = $ins(['posid'=>$p['hrgen'],  'posno'=>'40200','empno'=>'E014','fname'=>'Deja',    'lname'=>'Washington','level1'=>'NY','level2'=>'HR',     'ann_cost'=>64000, 'unitrate'=>2462, 'lasthire'=>'2021-08-09','posstart'=>'2021-08-09','reason'=>'HIRE',    'jobtitle'=>'HR Generalist',   'sex'=>'F','education'=>'BS-HR', 'historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023']);
        $i['recr']   = $ins(['posid'=>$p['recr'],   'posno'=>'40400','empno'=>'E015','fname'=>'Kevin',   'lname'=>"O'Brien",  'level1'=>'NY', 'level2'=>'HR',     'ann_cost'=>67000, 'unitrate'=>2577, 'lasthire'=>'2022-01-10','posstart'=>'2022-01-10','reason'=>'HIRE',    'jobtitle'=>'Recruiter',       'sex'=>'M','education'=>'BS-HR', 'historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023']);
        $i['rcpt']   = $ins(['posid'=>$p['rcpt'],   'posno'=>'40500','empno'=>'E016','fname'=>'Karen',   'lname'=>'Deluca',   'level1'=>'NY', 'level2'=>'HR',     'ann_cost'=>39500, 'unitrate'=>1519, 'lasthire'=>'2023-02-14','posstart'=>'2023-02-14','reason'=>'HIRE',    'jobtitle'=>'Receptionist',    'sex'=>'F','education'=>'HS',    'historystart'=>'2023-02-14','historyreason'=>'New hire - backfill','fulltimeequiv'=>1.0]);

        // OPERATIONS
        $i['opsmgr'] = $ins(['posid'=>$p['opsmgr'],'posno'=>'50100','empno'=>'E017','fname'=>'Samuel',  'lname'=>'Torres',   'level1'=>'CHI','level2'=>'OPS',    'ann_cost'=>93500, 'unitrate'=>3596, 'lasthire'=>'2016-02-22','posstart'=>'2016-02-22','reason'=>'HIRE',    'jobtitle'=>'Operations Mgr',  'sex'=>'M','education'=>'BS-OPS','historystart'=>'2022-01-01','historyreason'=>'Annual increase FY2022']);
        $i['whsup']  = $ins(['posid'=>$p['whsup'], 'posno'=>'50200','empno'=>'E018','fname'=>'Michelle', 'lname'=>'Brown',    'level1'=>'CHI','level2'=>'OPS',    'ann_cost'=>67000, 'unitrate'=>2577, 'lasthire'=>'2019-10-07','posstart'=>'2019-10-07','reason'=>'HIRE',    'jobtitle'=>'Warehouse Sup',   'sex'=>'F','education'=>'HS',    'historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023','fulltimeequiv'=>1.0]);
        $i['invan']  = $ins(['posid'=>$p['invan'], 'posno'=>'50300','empno'=>'E019','fname'=>'Omar',     'lname'=>'Hassan',   'level1'=>'CHI','level2'=>'OPS',    'ann_cost'=>57000, 'unitrate'=>2192, 'lasthire'=>'2020-04-13','posstart'=>'2020-04-13','reason'=>'HIRE',    'jobtitle'=>'Inventory Analyst','sex'=>'M','education'=>'BS-SCM','historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023']);
        $i['csla']   = $ins(['posid'=>$p['cslead'],'posno'=>'50400','empno'=>'E020','fname'=>'Cynthia',  'lname'=>'Ross',     'level1'=>'CHI','level2'=>'OPS',    'ann_cost'=>51000, 'unitrate'=>1962, 'lasthire'=>'2021-06-28','posstart'=>'2021-06-28','reason'=>'HIRE',    'jobtitle'=>'CS Lead',         'sex'=>'F','education'=>'BS-BUS','historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023','fulltimeequiv'=>1.0]);
        $i['cslb']   = $ins(['posid'=>$p['cslead'],'posno'=>'50400','empno'=>'E021','fname'=>'Brandon',  'lname'=>'Lee',      'level1'=>'CHI','level2'=>'OPS',    'ann_cost'=>50500, 'unitrate'=>1942, 'lasthire'=>'2025-03-10','posstart'=>'2025-03-10','reason'=>'HIRE',    'jobtitle'=>'CS Lead',         'sex'=>'M','education'=>'BS-BUS','historystart'=>'2025-03-10','historyreason'=>'Approved dual coverage - overfilled','fulltimeequiv'=>1.0]);

        // SALES
        $i['slsmgr'] = $ins(['posid'=>$p['slsmgr'],'posno'=>'60100','empno'=>'E022','fname'=>'Rachel',   'lname'=>'Green',    'level1'=>'CHI','level2'=>'SALES',  'ann_cost'=>93500, 'unitrate'=>3596, 'lasthire'=>'2020-03-02','posstart'=>'2023-07-01','reason'=>'PROMO',   'jobtitle'=>'Sales Manager',   'sex'=>'F','education'=>'BS-BUS','historystart'=>'2023-07-01','historyreason'=>'Promoted from Inside Sales Representative']);
        $i['insa']   = $ins(['posid'=>$p['insa'],  'posno'=>'60200','empno'=>'E023','fname'=>'Michael',  'lname'=>'Chen',     'level1'=>'CHI','level2'=>'SALES',  'ann_cost'=>54000, 'unitrate'=>2077, 'lasthire'=>'2021-08-23','posstart'=>'2021-08-23','reason'=>'HIRE',    'jobtitle'=>'Inside Sales Rep', 'sex'=>'M','education'=>'BS-BUS','historystart'=>'2023-01-01','historyreason'=>'Annual market adjustment FY2023','fulltimeequiv'=>1.0]);
        $i['insb']   = $ins(['posid'=>$p['insb'],  'posno'=>'60300','empno'=>'E024','fname'=>'Priya',    'lname'=>'Sharma',   'level1'=>'CHI','level2'=>'SALES',  'ann_cost'=>53500, 'unitrate'=>2058, 'lasthire'=>'2024-01-08','posstart'=>'2024-01-08','reason'=>'HIRE',    'jobtitle'=>'Inside Sales Rep', 'sex'=>'F','education'=>'BS-BUS','historystart'=>'2024-01-08','historyreason'=>'Backfill after promotion of Rachel Green','fulltimeequiv'=>1.0]);

        // INACTIVE — James Whitfield old Developer assignment (before transfer to Sr Dev)
        $i['dev_jw_old'] = $ins(['posid'=>$p['dev'],'posno'=>'30300','empno'=>'E010','fname'=>'James','lname'=>'Whitfield','level1'=>'NY','level2'=>'IT',
            'ann_cost'=>95000,'unitrate'=>3654,'lasthire'=>'2020-06-01','posstart'=>'2020-06-01',
            'reason'=>'TRANSFER','jobtitle'=>'Developer','sex'=>'M','education'=>'BS-CS',
            'active'=>'I','active_pos'=>'I','posstop'=>'2022-12-31','fulltimeequiv'=>1.0,
            'historystart'=>'2020-06-01','historyend'=>'2022-12-31',
            'historyreason'=>'Transferred to Senior Developer role at 0.50 FTE - phased retirement']);

        // INACTIVE — Rachel Green old Inside Sales B assignment (before promotion)
        $i['insb_rg_old'] = $ins(['posid'=>$p['insb'],'posno'=>'60300','empno'=>'E022','fname'=>'Rachel','lname'=>'Green','level1'=>'CHI','level2'=>'SALES',
            'ann_cost'=>52000,'unitrate'=>2000,'lasthire'=>'2020-03-02','posstart'=>'2020-03-02',
            'reason'=>'PROMO','jobtitle'=>'Inside Sales Rep','sex'=>'F','education'=>'BS-BUS',
            'active'=>'I','active_pos'=>'I','posstop'=>'2023-06-30','fulltimeequiv'=>1.0,
            'historystart'=>'2020-03-02','historyend'=>'2023-06-30',
            'historyreason'=>'Promoted to Sales Manager - effective 2023-07-01']);

        return $i;
    }

    // ---------------------------------------------------------------
    // POSITION HISTORY  (snapshot of state BEFORE each change)
    // ---------------------------------------------------------------
    private function seedPositionHistory(array $p): void
    {
        $tid = $this->teamId;
        $co  = $this->co;

        DB::table('hpositions')->insert([
            // CEO — Version 1: $220k budget (2015–2018)
            ['teamid'=>$tid,'posid'=>$p['ceo'], 'posno'=>'10100','descr'=>'Chief Executive Officer','company'=>$co,'level1'=>'NY','level2'=>'EXEC','budgsal'=>220000,'payrate'=>8462,'exempt'=>'Y','active'=>'A','fulltimeequiv'=>1,'ftefreq'=>'B','ftehours'=>80,'annftehour'=>2080,'curstatus'=>'FILLED','reptoposno'=>'','reptodesc'=>'Board of Directors','salgrade'=>'EXEC1','salupper'=>260000,'sallower'=>180000,'historystart'=>'2015-01-01','historyend'=>'2018-05-31','historyreason'=>'Original budget at position creation'],
            // CEO — Version 2: $240k budget (2018–2022)
            ['teamid'=>$tid,'posid'=>$p['ceo'], 'posno'=>'10100','descr'=>'Chief Executive Officer','company'=>$co,'level1'=>'NY','level2'=>'EXEC','budgsal'=>240000,'payrate'=>9231,'exempt'=>'Y','active'=>'A','fulltimeequiv'=>1,'ftefreq'=>'B','ftehours'=>80,'annftehour'=>2080,'curstatus'=>'FILLED','reptoposno'=>'','reptodesc'=>'Board of Directors','salgrade'=>'EXEC1','salupper'=>280000,'sallower'=>190000,'historystart'=>'2018-06-01','historyend'=>'2021-12-31','historyreason'=>'Annual budget increase FY2018'],
            // VP Sales — Version 1: was "Director of Sales" through 2021
            ['teamid'=>$tid,'posid'=>$p['vpsales'],'posno'=>'10400','descr'=>'Director of Sales','company'=>$co,'level1'=>'CHI','level2'=>'EXEC','budgsal'=>130000,'payrate'=>5000,'exempt'=>'Y','active'=>'A','fulltimeequiv'=>1,'ftefreq'=>'B','ftehours'=>80,'annftehour'=>2080,'curstatus'=>'FILLED','reptoposno'=>'10100','reptodesc'=>'Chief Executive Officer','salgrade'=>'MGR3','salupper'=>155000,'sallower'=>105000,'historystart'=>'2015-01-01','historyend'=>'2021-06-30','historyreason'=>'Title and grade at position creation'],
            // IT Manager — Version 1: $100k budget before 2023 increase
            ['teamid'=>$tid,'posid'=>$p['itmgr'],'posno'=>'30100','descr'=>'IT Manager','company'=>$co,'level1'=>'NY','level2'=>'IT','budgsal'=>100000,'payrate'=>3846,'exempt'=>'Y','active'=>'A','fulltimeequiv'=>1,'ftefreq'=>'B','ftehours'=>80,'annftehour'=>2080,'curstatus'=>'FILLED','reptoposno'=>'10500','reptodesc'=>'VP Technology','salgrade'=>'MGR2','salupper'=>120000,'sallower'=>80000,'historystart'=>'2015-01-01','historyend'=>'2023-06-30','historyreason'=>'Budget prior to retention increase'],
            // Developer — Version 1: $75k before backfill at market rate
            ['teamid'=>$tid,'posid'=>$p['dev'],'posno'=>'30300','descr'=>'Developer','company'=>$co,'level1'=>'NY','level2'=>'IT','budgsal'=>75000,'payrate'=>2885,'exempt'=>'Y','active'=>'A','fulltimeequiv'=>1,'ftefreq'=>'B','ftehours'=>80,'annftehour'=>2080,'curstatus'=>'FILLED','reptoposno'=>'30100','reptodesc'=>'IT Manager','salgrade'=>'PROF2','salupper'=>90000,'sallower'=>60000,'historystart'=>'2018-06-01','historyend'=>'2023-01-14','historyreason'=>'Budget prior to market rate adjustment on backfill'],
            // Senior Developer — Version 1: was FILLED 1.0 FTE before James went part-time
            ['teamid'=>$tid,'posid'=>$p['srdev'],'posno'=>'30200','descr'=>'Senior Developer','company'=>$co,'level1'=>'NY','level2'=>'IT','budgsal'=>105000,'payrate'=>4038,'exempt'=>'Y','active'=>'A','fulltimeequiv'=>1,'ftefreq'=>'B','ftehours'=>80,'annftehour'=>2080,'curstatus'=>'FILLED','reptoposno'=>'30100','reptodesc'=>'IT Manager','salgrade'=>'PROF3','salupper'=>125000,'sallower'=>85000,'historystart'=>'2018-06-01','historyend'=>'2022-12-31','historyreason'=>'Status prior to incumbent phased retirement arrangement'],
            // HR Manager — Version 1: $80k before FY2022 increase
            ['teamid'=>$tid,'posid'=>$p['hrmgr'],'posno'=>'40100','descr'=>'HR Manager','company'=>$co,'level1'=>'NY','level2'=>'HR','budgsal'=>80000,'payrate'=>3077,'exempt'=>'Y','active'=>'A','fulltimeequiv'=>1,'ftefreq'=>'B','ftehours'=>80,'annftehour'=>2080,'curstatus'=>'FILLED','reptoposno'=>'10100','reptodesc'=>'Chief Executive Officer','salgrade'=>'MGR2','salupper'=>96000,'sallower'=>64000,'historystart'=>'2015-01-01','historyend'=>'2021-12-31','historyreason'=>'Budget prior to FY2022 increase'],
            // Operations Manager — Version 1: reported to CFO before 2022 reorg
            ['teamid'=>$tid,'posid'=>$p['opsmgr'],'posno'=>'50100','descr'=>'Operations Manager','company'=>$co,'level1'=>'CHI','level2'=>'OPS','budgsal'=>85000,'payrate'=>3269,'exempt'=>'Y','active'=>'A','fulltimeequiv'=>1,'ftefreq'=>'B','ftehours'=>80,'annftehour'=>2080,'curstatus'=>'FILLED','reptoposno'=>'10200','reptodesc'=>'Chief Financial Officer','salgrade'=>'MGR2','salupper'=>102000,'sallower'=>68000,'historystart'=>'2015-01-01','historyend'=>'2021-12-31','historyreason'=>'Reported to CFO prior to operations reorg - now reports to VP Ops'],
            // Customer Service Lead — FILLED before dual coverage approved
            ['teamid'=>$tid,'posid'=>$p['cslead'],'posno'=>'50400','descr'=>'Customer Service Lead','company'=>$co,'level1'=>'CHI','level2'=>'OPS','budgsal'=>52000,'payrate'=>2000,'exempt'=>'N','active'=>'A','fulltimeequiv'=>1,'ftefreq'=>'B','ftehours'=>40,'annftehour'=>2080,'curstatus'=>'FILLED','reptoposno'=>'50100','reptodesc'=>'Operations Manager','salgrade'=>'STAFF2','salupper'=>62000,'sallower'=>42000,'historystart'=>'2018-02-01','historyend'=>'2025-03-09','historyreason'=>'Status prior to approved dual coverage arrangement'],
        ]);
    }

    // ---------------------------------------------------------------
    // INCUMBENT HISTORY  (snapshot of state BEFORE each change)
    // ---------------------------------------------------------------
    private function seedIncumbentHistory(array $i, array $p): void
    {
        $tid = $this->teamId;
        $co  = $this->co;
        $h   = fn(array $f) => array_merge($this->hinc($co, $tid), $f);

        DB::table('hincumbents')->insert([
            // Margaret Thornton (CEO) — hired at $238k, raised to $250k in 2020
            $h(['incid'=>$i['ceo'],'posid'=>$p['ceo'],'posno'=>'10100','empno'=>'E001','fname'=>'Margaret','lname'=>'Thornton','level1'=>'NY','level2'=>'EXEC','ann_cost'=>238000,'unitrate'=>9154,'fulltimeequiv'=>1,'lasthire'=>'2018-03-01','posstart'=>'2018-03-01','posstop'=>'2999-12-31','active'=>'A','active_pos'=>'A','jobtitle'=>'CEO','sex'=>'F','historystart'=>'2018-03-01','historyend'=>'2019-12-31','historyreason'=>'Salary at hire - prior to FY2020 increase']),
            $h(['incid'=>$i['ceo'],'posid'=>$p['ceo'],'posno'=>'10100','empno'=>'E001','fname'=>'Margaret','lname'=>'Thornton','level1'=>'NY','level2'=>'EXEC','ann_cost'=>250000,'unitrate'=>9615,'fulltimeequiv'=>1,'lasthire'=>'2018-03-01','posstart'=>'2018-03-01','posstop'=>'2999-12-31','active'=>'A','active_pos'=>'A','jobtitle'=>'CEO','sex'=>'F','historystart'=>'2020-01-01','historyend'=>'2021-12-31','historyreason'=>'Salary prior to FY2022 increase']),
            // Franklin Webb (CFO) — one raise
            $h(['incid'=>$i['cfo'],'posid'=>$p['cfo'],'posno'=>'10200','empno'=>'E002','fname'=>'Franklin','lname'=>'Webb','level1'=>'NY','level2'=>'EXEC','ann_cost'=>185000,'unitrate'=>7115,'fulltimeequiv'=>1,'lasthire'=>'2016-09-12','posstart'=>'2016-09-12','posstop'=>'2999-12-31','active'=>'A','active_pos'=>'A','jobtitle'=>'CFO','sex'=>'M','historystart'=>'2016-09-12','historyend'=>'2020-12-31','historyreason'=>'Salary at hire - prior to FY2021 increase']),
            // Robert Okafor (Controller) — one raise
            $h(['incid'=>$i['ctrl'],'posid'=>$p['ctrl'],'posno'=>'20100','empno'=>'E005','fname'=>'Robert','lname'=>'Okafor','level1'=>'CHI','level2'=>'FINANCE','ann_cost'=>95000,'unitrate'=>3654,'fulltimeequiv'=>1,'lasthire'=>'2021-04-12','posstart'=>'2021-04-12','posstop'=>'2999-12-31','active'=>'A','active_pos'=>'A','jobtitle'=>'Controller','sex'=>'M','historystart'=>'2021-04-12','historyend'=>'2022-06-30','historyreason'=>'Salary at hire - prior to reclassification adjustment']),
            // Lisa Nguyen (IT Manager) — one raise
            $h(['incid'=>$i['itmgr'],'posid'=>$p['itmgr'],'posno'=>'30100','empno'=>'E009','fname'=>'Lisa','lname'=>'Nguyen','level1'=>'NY','level2'=>'IT','ann_cost'=>105000,'unitrate'=>4038,'fulltimeequiv'=>1,'lasthire'=>'2017-09-01','posstart'=>'2017-09-01','posstop'=>'2999-12-31','active'=>'A','active_pos'=>'A','jobtitle'=>'IT Manager','sex'=>'F','historystart'=>'2017-09-01','historyend'=>'2023-06-30','historyreason'=>'Salary prior to retention increase']),
            // James Whitfield — snapshot of old Developer assignment before transfer
            // incid → current active Sr Dev record so history appears when viewing that record
            $h(['incid'=>$i['srdev'],'posid'=>$p['dev'],'posno'=>'30300','empno'=>'E010','fname'=>'James','lname'=>'Whitfield','level1'=>'NY','level2'=>'IT','ann_cost'=>95000,'unitrate'=>3654,'fulltimeequiv'=>1,'lasthire'=>'2020-06-01','posstart'=>'2020-06-01','posstop'=>'2022-12-31','active'=>'A','active_pos'=>'A','jobtitle'=>'Developer','sex'=>'M','historystart'=>'2020-06-01','historyend'=>'2022-12-31','historyreason'=>'Status prior to transfer to Senior Developer at 0.50 FTE']),
            // Angela Martinez (HR Manager) — one raise
            $h(['incid'=>$i['hrmgr'],'posid'=>$p['hrmgr'],'posno'=>'40100','empno'=>'E013','fname'=>'Angela','lname'=>'Martinez','level1'=>'NY','level2'=>'HR','ann_cost'=>78000,'unitrate'=>3000,'fulltimeequiv'=>1,'lasthire'=>'2020-11-01','posstart'=>'2020-11-01','posstop'=>'2999-12-31','active'=>'A','active_pos'=>'A','jobtitle'=>'HR Manager','sex'=>'F','historystart'=>'2020-11-01','historyend'=>'2021-12-31','historyreason'=>'Salary at hire - prior to FY2022 increase']),
            // Rachel Green — snapshot of old Inside Sales B assignment before promotion
            // incid → current active Sales Manager record so history appears when viewing that record
            $h(['incid'=>$i['slsmgr'],'posid'=>$p['insb'],'posno'=>'60300','empno'=>'E022','fname'=>'Rachel','lname'=>'Green','level1'=>'CHI','level2'=>'SALES','ann_cost'=>52000,'unitrate'=>2000,'fulltimeequiv'=>1,'lasthire'=>'2020-03-02','posstart'=>'2020-03-02','posstop'=>'2023-06-30','active'=>'I','active_pos'=>'I','jobtitle'=>'Inside Sales Rep','sex'=>'F','historystart'=>'2020-03-02','historyend'=>'2023-06-30','historyreason'=>'Assignment prior to promotion to Sales Manager']),
        ]);
    }

    // ---------------------------------------------------------------
    // HELPERS
    // ---------------------------------------------------------------
    private function pos(array $fields): array
    {
        return array_merge([
            'teamid'        => $this->teamId,
            'company'       => $this->co,
            'active'        => 'A',
            'ftefreq'       => 'B',
            'ftehours'      => 80,
            'annftehour'    => 2080,
            'fulltimeequiv' => 1.0,
            'exempt'        => 'Y',
            'payfreq'       => 'B',
            'paytype'       => 'SAL',
            'funded'        => 'Y',
            'multincumb'    => 0,
            'curstatus'     => 'FILLED',
            'startdate'     => '2015-01-01',
            'historystart'  => '2020-01-01',
            'historyend'    => '2999-12-31',
            'historyreason' => '',
            'group1'=>'','group2'=>'','group3'=>'','jobcode'=>'','jobdesc'=>'',
            'eeoclass'=>'','salfreq'=>'A','reason'=>'',
            'reptocomp'=>$this->co,'reptocom2'=>'','reptopos2'=>'','reptodesc2'=>'',
            'supcompany'=>'','supempno'=>'','supname'=>'',
            'userdef1'=>'','userdef2'=>'','userdef3'=>'','userdef4'=>'','userdef5'=>'','userdef6'=>'',
        ], $fields);
    }

    private function inc(array $fields): array
    {
        return array_merge([
            'teamid'        => $this->teamId,
            'company'       => $this->co,
            'poscompany'    => $this->co,
            'active'        => 'A',
            'active_pos'    => 'A',
            'fulltimeequiv' => 1.0,
            'payfreq'       => 'B',
            'mi'            => '',
            'posstop'       => '2999-12-31',
            'nextpay'       => '2026-07-11',
            'nextincr'      => 0,
            'trans_date'    => '2999-12-31',
            'reason'        => 'HIRE',
            'annual'        => 0, 'salary'=>0, 'normunit'=>0, 'lsalary'=>0,
            'userdef1'=>'','userdef2'=>'','userdef3'=>'','userdef4'=>'','userdef5'=>'','userdef6'=>'',
            'level3'=>'','level4'=>'','level5'=>'',
            'lastact'       => '2999-12-31',
            'hrmsreas'      => '',
            'hrmsdate'      => '2999-12-31',
            'jobcode'       => '',
            'race'          => '',
            'education'     => '',
            'historyend'    => '2999-12-31',
            'historyreason' => '',
        ], $fields);
    }

    private function hinc(string $co, int $tid): array
    {
        return [
            'teamid'=>$tid,'posid'=>0,'incid'=>0,
            'poscompany'=>$co,'posno'=>'','company'=>$co,'empno'=>'',
            'fname'=>'','mi'=>'','lname'=>'',
            'annual'=>0,'salary'=>0,'unitrate'=>0,'normunit'=>0,'lsalary'=>0,
            'payfreq'=>'B','posstart'=>'2000-01-01','posstop'=>'2999-12-31',
            'fulltimeequiv'=>1,'active'=>'A','nextpay'=>'2026-07-11','nextincr'=>0,
            'jobtitle'=>'','lasthire'=>'2000-01-01','active_pos'=>'A',
            'trans_date'=>'2999-12-31','reason'=>'',
            'userdef1'=>'','userdef2'=>'','userdef3'=>'','userdef4'=>'','userdef5'=>'','userdef6'=>'',
            'ann_cost'=>0,
            'level1'=>'','level2'=>'','level3'=>'','level4'=>'','level5'=>'',
            'lastact'=>'2999-12-31','hrmsreas'=>'','hrmsdate'=>'2999-12-31',
            'jobcode'=>'','race'=>'','sex'=>'','education'=>'',
            'historyreason'=>'','historystart'=>'2000-01-01','historyend'=>'2999-12-31',
        ];
    }
}
