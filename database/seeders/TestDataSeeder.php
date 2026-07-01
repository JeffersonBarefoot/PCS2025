<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Creates three additional teams with positions, incumbents, and test users.
 * Designed to validate: multi-tenancy isolation, private report visibility,
 * admin vs. regular user access, and empty-state handling.
 *
 * Teams seeded here:
 *   Team 2 — Riverside Medical Center   (admin + regular user, full data)
 *   Team 3 — Metro Transit Authority    (admin user, partial data)
 *   Team 4 — Empty State Co             (admin user, NO positions — tests empty state)
 */
class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        [$riverside, $riversideTeam] = $this->makeTeam(
            'Riverside Admin',
            'admin@riverside.test',
            'Riverside Medical Center'
        );

        // Regular non-admin member on Riverside team
        $riversideRegular = User::where('email', 'user@riverside.test')->first()
            ?? User::factory()->create([
                'name'     => 'Riverside User',
                'email'    => 'user@riverside.test',
                'password' => Hash::make('password'),
            ]);
        $riversideTeam->users()->syncWithoutDetaching([
            $riversideRegular->id => ['role' => 'editor'],
        ]);
        // Give the regular user a current_team so they land correctly after login
        $riversideRegular->update(['current_team_id' => $riversideTeam->id]);

        [$metro, $metroTeam] = $this->makeTeam(
            'Metro Admin',
            'admin@metro.test',
            'Metro Transit Authority'
        );

        $this->makeTeam(
            'Empty Admin',
            'admin@empty.test',
            'Empty State Co'
        );

        $this->seedRiverside($riverside, $riversideTeam, $riversideRegular);
        $this->seedMetro($metro, $metroTeam);
        // Empty State Co intentionally has no positions
    }

    // ---------------------------------------------------------------
    // RIVERSIDE MEDICAL CENTER  (12 positions, 10 incumbents)
    // ---------------------------------------------------------------
    private function seedRiverside(User $admin, $team, User $regular): void
    {
        $tid = $team->id;
        $co  = 'RMC';
        $ins = fn(array $f) => DB::table('positions')->insertGetId(array_merge($this->posDefaults($co, $tid), $f));

        $p['cmo']    = $ins(['posno'=>'RMC-100','descr'=>'Chief Medical Officer',   'level1'=>'MAIN','level2'=>'EXEC',   'budgsal'=>280000,'payrate'=>10769,'exempt'=>'Y','curstatus'=>'FILLED']);
        $p['cno']    = $ins(['posno'=>'RMC-110','descr'=>'Chief Nursing Officer',   'level1'=>'MAIN','level2'=>'EXEC',   'budgsal'=>200000,'payrate'=>7692, 'exempt'=>'Y','curstatus'=>'FILLED']);
        $p['offmgr'] = $ins(['posno'=>'RMC-200','descr'=>'Office Manager',          'level1'=>'MAIN','level2'=>'ADMIN',  'budgsal'=>75000, 'payrate'=>2885, 'exempt'=>'Y','curstatus'=>'FILLED']);
        $p['billing']= $ins(['posno'=>'RMC-210','descr'=>'Billing Specialist',      'level1'=>'MAIN','level2'=>'ADMIN',  'budgsal'=>55000, 'payrate'=>2115, 'exempt'=>'N','curstatus'=>'FILLED']);
        $p['recept'] = $ins(['posno'=>'RMC-220','descr'=>'Receptionist',            'level1'=>'MAIN','level2'=>'ADMIN',  'budgsal'=>42000, 'payrate'=>1615, 'exempt'=>'N','curstatus'=>'FILLED']);
        $p['rn1']    = $ins(['posno'=>'RMC-300','descr'=>'Registered Nurse',        'level1'=>'MAIN','level2'=>'NURSING','budgsal'=>80000, 'payrate'=>3077, 'exempt'=>'Y','curstatus'=>'FILLED']);
        $p['rn2']    = $ins(['posno'=>'RMC-301','descr'=>'Registered Nurse',        'level1'=>'MAIN','level2'=>'NURSING','budgsal'=>80000, 'payrate'=>3077, 'exempt'=>'Y','curstatus'=>'FILLED']);
        $p['rn3']    = $ins(['posno'=>'RMC-302','descr'=>'Registered Nurse',        'level1'=>'MAIN','level2'=>'NURSING','budgsal'=>80000, 'payrate'=>3077, 'exempt'=>'Y','curstatus'=>'VACANT']);
        $p['ma1']    = $ins(['posno'=>'RMC-400','descr'=>'Medical Assistant',       'level1'=>'MAIN','level2'=>'CLINICAL','budgsal'=>48000,'payrate'=>1846, 'exempt'=>'N','curstatus'=>'FILLED']);
        $p['ma2']    = $ins(['posno'=>'RMC-401','descr'=>'Medical Assistant',       'level1'=>'MAIN','level2'=>'CLINICAL','budgsal'=>48000,'payrate'=>1846, 'exempt'=>'N','curstatus'=>'FILLED']);
        $p['lab']    = $ins(['posno'=>'RMC-500','descr'=>'Lab Technician',          'level1'=>'MAIN','level2'=>'CLINICAL','budgsal'=>62000,'payrate'=>2385, 'exempt'=>'Y','curstatus'=>'FILLED']);
        $p['it']     = $ins(['posno'=>'RMC-600','descr'=>'IT Support Specialist',   'level1'=>'MAIN','level2'=>'IT',    'budgsal'=>60000, 'payrate'=>2308, 'exempt'=>'Y','curstatus'=>'VACANT']);

        $inc = fn(array $f) => array_merge($this->incDefaults($co, $tid), $f);

        DB::table('incumbents')->insert([
            $inc(['posid'=>$p['cmo'],   'posno'=>'RMC-100','empno'=>'R001','fname'=>'Elizabeth','lname'=>'Monroe',   'ann_cost'=>278000,'unitrate'=>10692,'lasthire'=>'2019-06-01','posstart'=>'2019-06-01','jobtitle'=>'CMO',                'sex'=>'F','education'=>'MD'   ,'level1'=>'MAIN','level2'=>'EXEC'   ]),
            $inc(['posid'=>$p['cno'],   'posno'=>'RMC-110','empno'=>'R002','fname'=>'Thomas',   'lname'=>'Reyes',    'ann_cost'=>198000,'unitrate'=>7615, 'lasthire'=>'2020-03-15','posstart'=>'2020-03-15','jobtitle'=>'CNO',                'sex'=>'M','education'=>'MSN'  ,'level1'=>'MAIN','level2'=>'EXEC'   ]),
            $inc(['posid'=>$p['offmgr'],'posno'=>'RMC-200','empno'=>'R003','fname'=>'Sandra',   'lname'=>'Kowalski', 'ann_cost'=>74000, 'unitrate'=>2846, 'lasthire'=>'2021-02-08','posstart'=>'2021-02-08','jobtitle'=>'Office Manager',     'sex'=>'F','education'=>'BS'   ,'level1'=>'MAIN','level2'=>'ADMIN'  ]),
            $inc(['posid'=>$p['billing'],'posno'=>'RMC-210','empno'=>'R004','fname'=>'Jorge',   'lname'=>'Padilla',  'ann_cost'=>54500, 'unitrate'=>2096, 'lasthire'=>'2022-05-16','posstart'=>'2022-05-16','jobtitle'=>'Billing Specialist', 'sex'=>'M','education'=>'AA'   ,'level1'=>'MAIN','level2'=>'ADMIN',  'fulltimeequiv'=>1.0]),
            $inc(['posid'=>$p['recept'],'posno'=>'RMC-220','empno'=>'R005','fname'=>'Yolanda',  'lname'=>'Perkins',  'ann_cost'=>41500, 'unitrate'=>1596, 'lasthire'=>'2023-09-05','posstart'=>'2023-09-05','jobtitle'=>'Receptionist',       'sex'=>'F','education'=>'HS'   ,'level1'=>'MAIN','level2'=>'ADMIN',  'fulltimeequiv'=>1.0]),
            $inc(['posid'=>$p['rn1'],   'posno'=>'RMC-300','empno'=>'R006','fname'=>'Danielle', 'lname'=>'Holt',     'ann_cost'=>79000, 'unitrate'=>3038, 'lasthire'=>'2020-11-30','posstart'=>'2020-11-30','jobtitle'=>'Registered Nurse',   'sex'=>'F','education'=>'BSN'  ,'level1'=>'MAIN','level2'=>'NURSING']),
            $inc(['posid'=>$p['rn2'],   'posno'=>'RMC-301','empno'=>'R007','fname'=>'Marcus',   'lname'=>'Bell',     'ann_cost'=>79500, 'unitrate'=>3058, 'lasthire'=>'2021-07-12','posstart'=>'2021-07-12','jobtitle'=>'Registered Nurse',   'sex'=>'M','education'=>'BSN'  ,'level1'=>'MAIN','level2'=>'NURSING']),
            $inc(['posid'=>$p['ma1'],   'posno'=>'RMC-400','empno'=>'R008','fname'=>'Aisha',    'lname'=>'Grant',    'ann_cost'=>47500, 'unitrate'=>1827, 'lasthire'=>'2022-08-22','posstart'=>'2022-08-22','jobtitle'=>'Medical Assistant',  'sex'=>'F','education'=>'CMA'  ,'level1'=>'MAIN','level2'=>'CLINICAL','fulltimeequiv'=>1.0]),
            $inc(['posid'=>$p['ma2'],   'posno'=>'RMC-401','empno'=>'R009','fname'=>'Derek',    'lname'=>'Foster',   'ann_cost'=>47000, 'unitrate'=>1808, 'lasthire'=>'2023-03-27','posstart'=>'2023-03-27','jobtitle'=>'Medical Assistant',  'sex'=>'M','education'=>'CMA'  ,'level1'=>'MAIN','level2'=>'CLINICAL','fulltimeequiv'=>1.0]),
            $inc(['posid'=>$p['lab'],   'posno'=>'RMC-500','empno'=>'R010','fname'=>'Natalie',  'lname'=>'Simmons',  'ann_cost'=>61500, 'unitrate'=>2365, 'lasthire'=>'2021-10-04','posstart'=>'2021-10-04','jobtitle'=>'Lab Technician',     'sex'=>'F','education'=>'BS-MLS','level1'=>'MAIN','level2'=>'CLINICAL']),
        ]);

        // Seed a few test reports for security validation
        $this->seedTestReports($tid, $admin->id, $regular->id);
    }

    // ---------------------------------------------------------------
    // METRO TRANSIT AUTHORITY  (6 positions, 5 incumbents)
    // ---------------------------------------------------------------
    private function seedMetro(User $admin, $team): void
    {
        $tid = $team->id;
        $co  = 'MTA';
        $ins = fn(array $f) => DB::table('positions')->insertGetId(array_merge($this->posDefaults($co, $tid), $f));

        $p['dir']    = $ins(['posno'=>'MTA-100','descr'=>'Director of Operations',  'level1'=>'HQ',  'level2'=>'EXEC',    'budgsal'=>130000,'payrate'=>5000, 'exempt'=>'Y','curstatus'=>'FILLED']);
        $p['sched']  = $ins(['posno'=>'MTA-200','descr'=>'Scheduler',               'level1'=>'HQ',  'level2'=>'OPS',     'budgsal'=>58000, 'payrate'=>2231, 'exempt'=>'N','curstatus'=>'FILLED']);
        $p['driver1']= $ins(['posno'=>'MTA-300','descr'=>'Bus Driver',              'level1'=>'DEPOT','level2'=>'TRANSIT', 'budgsal'=>52000, 'payrate'=>2000, 'exempt'=>'N','curstatus'=>'FILLED']);
        $p['driver2']= $ins(['posno'=>'MTA-301','descr'=>'Bus Driver',              'level1'=>'DEPOT','level2'=>'TRANSIT', 'budgsal'=>52000, 'payrate'=>2000, 'exempt'=>'N','curstatus'=>'FILLED']);
        $p['mech']   = $ins(['posno'=>'MTA-400','descr'=>'Fleet Mechanic',          'level1'=>'DEPOT','level2'=>'MAINT',   'budgsal'=>65000, 'payrate'=>2500, 'exempt'=>'N','curstatus'=>'FILLED']);
        $p['hr']     = $ins(['posno'=>'MTA-500','descr'=>'HR Coordinator',          'level1'=>'HQ',  'level2'=>'HR',      'budgsal'=>55000, 'payrate'=>2115, 'exempt'=>'Y','curstatus'=>'VACANT']);

        $inc = fn(array $f) => array_merge($this->incDefaults($co, $tid), $f);

        DB::table('incumbents')->insert([
            $inc(['posid'=>$p['dir'],   'posno'=>'MTA-100','empno'=>'M001','fname'=>'Gerald',  'lname'=>'Nguyen',  'ann_cost'=>128000,'unitrate'=>4923,'lasthire'=>'2022-01-10','posstart'=>'2022-01-10','jobtitle'=>'Director of Operations','sex'=>'M','education'=>'MBA','level1'=>'HQ',   'level2'=>'EXEC'   ]),
            $inc(['posid'=>$p['sched'], 'posno'=>'MTA-200','empno'=>'M002','fname'=>'Patricia','lname'=>'Cole',    'ann_cost'=>57000, 'unitrate'=>2192,'lasthire'=>'2022-04-18','posstart'=>'2022-04-18','jobtitle'=>'Scheduler',              'sex'=>'F','education'=>'BS', 'level1'=>'HQ',   'level2'=>'OPS',    'fulltimeequiv'=>1.0]),
            $inc(['posid'=>$p['driver1'],'posno'=>'MTA-300','empno'=>'M003','fname'=>'Leon',   'lname'=>'Carter',  'ann_cost'=>51500, 'unitrate'=>1981,'lasthire'=>'2021-08-09','posstart'=>'2021-08-09','jobtitle'=>'Bus Driver',              'sex'=>'M','education'=>'HS', 'level1'=>'DEPOT','level2'=>'TRANSIT','fulltimeequiv'=>1.0]),
            $inc(['posid'=>$p['driver2'],'posno'=>'MTA-301','empno'=>'M004','fname'=>'Rosa',   'lname'=>'Vega',    'ann_cost'=>51000, 'unitrate'=>1962,'lasthire'=>'2023-02-27','posstart'=>'2023-02-27','jobtitle'=>'Bus Driver',              'sex'=>'F','education'=>'HS', 'level1'=>'DEPOT','level2'=>'TRANSIT','fulltimeequiv'=>1.0]),
            $inc(['posid'=>$p['mech'],  'posno'=>'MTA-400','empno'=>'M005','fname'=>'Tyrone',  'lname'=>'Jackson', 'ann_cost'=>64000, 'unitrate'=>2462,'lasthire'=>'2020-06-15','posstart'=>'2020-06-15','jobtitle'=>'Fleet Mechanic',          'sex'=>'M','education'=>'AS', 'level1'=>'DEPOT','level2'=>'MAINT',  'fulltimeequiv'=>1.0]),
        ]);
    }

    // ---------------------------------------------------------------
    // TEST REPORTS  (seeded on Riverside team to test security scoping)
    // ---------------------------------------------------------------
    private function seedTestReports(int $teamId, int $adminId, int $regularId): void
    {
        // A private report owned by regular user — visible to owner + admins (admin bypass)
        DB::table('reports')->insertOrIgnore([
            'reportid'  => 9001,
            'teamid'    => $teamId,
            'userid'    => $regularId,
            'active'    => 'A',
            'private'   => 'Y',
            'is_system' => false,
            'group1'    => 'POS',
            'group2'    => '',
            'sortorder' => '9001',
            'descr'     => '[TEST] Private - Regular User Report',
            'notes'     => 'Should be visible to owner (regular user) and admins. NOT visible to other regular users.',
        ]);

        // A team-scoped non-private report — all Riverside members see it, other teams do not
        DB::table('reports')->insertOrIgnore([
            'reportid'  => 9002,
            'teamid'    => $teamId,
            'userid'    => $adminId,
            'active'    => 'A',
            'private'   => 'N',
            'is_system' => false,
            'group1'    => 'INC',
            'group2'    => '',
            'sortorder' => '9002',
            'descr'     => '[TEST] Team Report - Riverside Only',
            'notes'     => 'Visible to all Riverside members. NOT visible to other teams.',
        ]);

        // An inactive report — should never appear regardless of team or role
        DB::table('reports')->insertOrIgnore([
            'reportid'  => 9003,
            'teamid'    => $teamId,
            'userid'    => $adminId,
            'active'    => 'I',
            'private'   => 'N',
            'is_system' => false,
            'group1'    => 'POS',
            'group2'    => '',
            'sortorder' => '9003',
            'descr'     => '[TEST] Inactive Report - Should Never Appear',
            'notes'     => 'active=I, should be filtered by accessibleBy scope.',
        ]);
    }

    // ---------------------------------------------------------------
    // HELPERS
    // ---------------------------------------------------------------
    private function makeTeam(string $name, string $email, string $teamName): array
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = User::factory()->withPersonalTeam()->create([
                'name'     => $name,
                'email'    => $email,
                'password' => Hash::make('password'),
            ]);
        }
        // Rename the personal team to the company name
        $team = $user->currentTeam;
        $team->update(['name' => $teamName]);

        return [$user, $team];
    }

    private function posDefaults(string $co, int $tid): array
    {
        return [
            'teamid'        => $tid,
            'company'       => $co,
            'active'        => 'A',
            'ftefreq'       => 'B',
            'ftehours'      => 80,
            'annftehour'    => 2080,
            'fulltimeequiv' => 1.0,
            'payfreq'       => 'B',
            'paytype'       => 'SAL',
            'funded'        => 'Y',
            'multincumb'    => 0,
            'curstatus'     => 'VACANT',
            'startdate'     => '2020-01-01',
            'historystart'  => '2020-01-01',
            'historyend'    => '2999-12-31',
            'historyreason' => '',
            'reptocomp'     => $co, 'reptocom2'=>'', 'reptopos2'=>'', 'reptodesc2'=>'',
            'reptoposno'    => '', 'reptodesc'=>'',
            'supcompany'    => '', 'supempno'=>'', 'supname'=>'',
            'group1'=>'','group2'=>'','group3'=>'','jobcode'=>'','jobdesc'=>'',
            'eeoclass'=>'','salfreq'=>'','reason'=>'',
            'userdef1'=>'','userdef2'=>'','userdef3'=>'','userdef4'=>'','userdef5'=>'','userdef6'=>'',
        ];
    }

    private function incDefaults(string $co, int $tid): array
    {
        return [
            'teamid'        => $tid,
            'company'       => $co,
            'poscompany'    => $co,
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
            'annual'=>0,'salary'=>0,'normunit'=>0,'lsalary'=>0,
            'userdef1'=>'','userdef2'=>'','userdef3'=>'','userdef4'=>'','userdef5'=>'','userdef6'=>'',
            'level3'=>'','level4'=>'','level5'=>'',
            'lastact'       => '2999-12-31',
            'hrmsreas'      => '',
            'hrmsdate'      => '2999-12-31',
            'jobcode'       => '',
            'race'          => '',
            'sex'           => '',
            'education'     => '',
            'historyend'    => '2999-12-31',
            'historyreason' => '',
        ];
    }
}
