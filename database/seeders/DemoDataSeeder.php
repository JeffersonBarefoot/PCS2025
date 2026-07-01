<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoDataSeeder extends Seeder
{
    private string $co  = 'BRM';
    private int    $tid = 1;
    private string $now;
    private string $never = '2999-12-31';

    public function run(): void
    {
        $this->now = now()->toDateString();

        DB::transaction(function () {
            DB::table('hincumbents')->where('teamid', $this->tid)->delete();
            DB::table('hpositions')->where('teamid', $this->tid)->delete();
            DB::table('incumbents')->where('teamid', $this->tid)->delete();
            DB::table('positions')->where('teamid', $this->tid)->delete();

            foreach ($this->getData() as $entry) {
                $posRec = $this->buildPos($entry['position']);
                $posId  = DB::table('positions')->insertGetId($posRec);
                $this->seedPosHistory($posId, $posRec);

                if (!empty($entry['incumbent'])) {
                    $incRec = $this->buildInc($entry['incumbent'], $posId, $entry['position']['posno']);
                    $incId  = DB::table('incumbents')->insertGetId($incRec);
                    $this->seedIncHistory($incId, $posId, $incRec);
                }
            }
        });
    }

    // ── Builders ──────────────────────────────────────────────────────────────

    private function buildPos(array $d): array
    {
        $vacant = ($d['curstatus'] === 'VACANT');
        return [
            'teamid'        => $this->tid,
            'company'       => $this->co,
            'posno'         => $d['posno'],
            'descr'         => $d['descr'],
            'active'        => 'A',
            'curstatus'     => $d['curstatus'],
            'budgsal'       => $d['budgsal'],
            'payrate'       => $d['budgsal'],
            'paytype'       => 'S',
            'payfreq'       => 'A',
            'eeoclass'      => $d['eeoclass'],
            'exempt'        => $d['exempt'],
            'funded'        => 'Y',
            'group1'        => $d['group1'],
            'group2'        => $d['group2'],
            'group3'        => '',
            'jobcode'       => $d['jobcode'],
            'jobdesc'       => $d['descr'],
            'salgrade'      => $d['salgrade'],
            'sallower'      => $d['sallower'],
            'salupper'      => $d['salupper'],
            'salfreq'       => 'A',
            'reptocomp'     => $d['reptocomp']  ?? '',
            'reptoposno'    => $d['reptoposno'] ?? '',
            'reptodesc'     => $d['reptodesc']  ?? '',
            'reptocom2'     => '',
            'reptopos2'     => '',
            'reptodesc2'    => '',
            'startdate'     => $d['startdate'],
            'enddate'       => $this->never,
            'avail_date'    => $vacant ? $this->now : $this->never,
            'lastactdate'   => $this->now,
            'last_fil'      => $d['last_fil'] ?? $this->never,
            'last_vac'      => $vacant ? $this->now : $this->never,
            'last_ove'      => $this->never,
            'last_par'      => $this->never,
            'annftehour'    => 2080,
            'ftefreq'       => 'W',
            'ftehours'      => 40,
            'fulltimeequiv' => 1.0,
            'multincumb'    => 0,
            'linktoabra'    => 0,
            'trans_date'    => $this->now,
            'level1'        => $d['group2'],
            'level2'        => $d['group1'],
            'level3'        => '',
            'level4'        => '',
            'level5'        => '',
            'supcompany'    => '',
            'supempno'      => '',
            'supname'       => '',
            'reason'        => $vacant ? 'NEW' : '',
            'userdef1'      => '',
            'userdef2'      => '',
            'userdef3'      => '',
            'userdef4'      => '',
            'userdef5'      => '',
            'userdef6'      => '',
            'vac_times'     => 0,
            'vac_months'    => 0,
            'historyreason' => '',
            'historystart'  => '2000-01-01',
            'historyend'    => $this->never,
            'created_at'    => $this->now,
            'updated_at'    => $this->now,
        ];
    }

    private function buildInc(array $d, int $posId, string $posno): array
    {
        $annual = $d['annual'];
        return [
            'teamid'        => $this->tid,
            'posid'         => $posId,
            'poscompany'    => $this->co,
            'posno'         => $posno,
            'company'       => $this->co,
            'empno'         => $d['empno'],
            'fname'         => $d['fname'],
            'mi'            => $d['mi'],
            'lname'         => $d['lname'],
            'annual'        => $annual,
            'salary'        => $annual,
            'unitrate'      => $annual,
            'normunit'      => 1,
            'payfreq'       => 'A',
            'posstart'      => $d['posstart'],
            'posstop'       => $this->never,
            'fulltimeequiv' => 1.0,
            'active'        => 'A',
            'lsalary'       => (int) round($annual * 0.91),
            'nextpay'       => '2026-07-15',
            'nextincr'      => 0,
            'lasthire'      => $d['lasthire'],
            'active_pos'    => 'A',
            'trans_date'    => $this->now,
            'reason'        => '',
            'userdef1'      => '',
            'userdef2'      => '',
            'userdef3'      => '',
            'userdef4'      => '',
            'userdef5'      => '',
            'userdef6'      => '',
            'ann_cost'      => $annual,
            'level1'        => '',
            'level2'        => '',
            'level3'        => '',
            'level4'        => '',
            'level5'        => '',
            'lastact'       => $this->now,
            'hrmsreas'      => '',
            'hrmsdate'      => $this->now,
            'jobcode'       => $d['jobcode'],
            'jobtitle'      => $d['jobtitle'],
            'race'          => $d['race'],
            'sex'           => $d['sex'],
            'education'     => $d['education'],
            'historyreason' => '',
            'historystart'  => '2000-01-01',
            'historyend'    => $this->never,
            'created_at'    => $this->now,
            'updated_at'    => $this->now,
        ];
    }

    // ── History inserters ─────────────────────────────────────────────────────

    private function seedPosHistory(int $posId, array $pos): void
    {
        $start  = $pos['startdate'];
        $budget = $pos['budgsal'];

        $base = array_merge($pos, ['posid' => $posId]);
        unset($base['historystart'], $base['historyend'], $base['historyreason']);

        if ($start <= '2020-12-31') {
            DB::table('hpositions')->insert(array_merge($base, [
                'budgsal'       => (int) round($budget * 0.82),
                'payrate'       => (int) round($budget * 0.82),
                'historyreason' => 'Budget increase - annual review',
                'historystart'  => $start,
                'historyend'    => '2020-12-31',
            ]));
            DB::table('hpositions')->insert(array_merge($base, [
                'budgsal'       => (int) round($budget * 0.92),
                'payrate'       => (int) round($budget * 0.92),
                'historyreason' => 'Compensation adjustment - market analysis',
                'historystart'  => '2021-01-01',
                'historyend'    => '2023-12-31',
            ]));
        } elseif ($start <= '2023-12-31') {
            DB::table('hpositions')->insert(array_merge($base, [
                'budgsal'       => (int) round($budget * 0.92),
                'payrate'       => (int) round($budget * 0.92),
                'historyreason' => 'Initial position budget',
                'historystart'  => $start,
                'historyend'    => '2024-12-31',
            ]));
        } else {
            DB::table('hpositions')->insert(array_merge($base, [
                'budgsal'       => (int) round($budget * 0.96),
                'payrate'       => (int) round($budget * 0.96),
                'historyreason' => 'Position created',
                'historystart'  => $start,
                'historyend'    => '2025-12-31',
            ]));
        }
    }

    private function seedIncHistory(int $incId, int $posId, array $inc): void
    {
        $posstart   = $inc['posstart'];
        $prior      = (int) round($inc['annual'] * 0.88);
        $histEnd    = date('Y-m-d', strtotime($posstart . ' +1 year'));
        if ($histEnd > '2025-06-29') $histEnd = '2025-06-29';

        DB::table('hincumbents')->insert([
            'teamid'        => $this->tid,
            'posid'         => $posId,
            'incid'         => $incId,
            'poscompany'    => $inc['poscompany'],
            'posno'         => $inc['posno'],
            'company'       => $inc['company'],
            'empno'         => $inc['empno'],
            'fname'         => $inc['fname'],
            'mi'            => $inc['mi'],
            'lname'         => $inc['lname'],
            'annual'        => $prior,
            'salary'        => $prior,
            'unitrate'      => $prior,
            'normunit'      => 1,
            'payfreq'       => 'A',
            'posstart'      => $posstart,
            'posstop'       => $this->never,
            'fulltimeequiv' => 1.0,
            'active'        => 'A',
            'lsalary'       => (int) round($prior * 0.91),
            'nextpay'       => '2026-07-15',
            'nextincr'      => 0,
            'jobtitle'      => $inc['jobtitle'],
            'lasthire'      => $inc['lasthire'],
            'active_pos'    => 'A',
            'trans_date'    => $posstart,
            'reason'        => 'New hire',
            'userdef1'      => '',
            'userdef2'      => '',
            'userdef3'      => '',
            'userdef4'      => '',
            'userdef5'      => '',
            'userdef6'      => '',
            'ann_cost'      => $prior,
            'level1'        => '',
            'level2'        => '',
            'level3'        => '',
            'level4'        => '',
            'level5'        => '',
            'lastact'       => $posstart,
            'hrmsreas'      => '',
            'hrmsdate'      => $posstart,
            'jobcode'       => $inc['jobcode'],
            'race'          => $inc['race'],
            'sex'           => $inc['sex'],
            'education'     => $inc['education'],
            'historyreason' => 'Initial placement',
            'historystart'  => $posstart,
            'historyend'    => $histEnd,
            'created_at'    => $this->now,
            'updated_at'    => $this->now,
        ]);
    }

    // ── Sample data ───────────────────────────────────────────────────────────

    private function getData(): array
    {
        return [

            // ── EXECUTIVE ──────────────────────────────────────────────────────
            [
                'position' => [
                    'posno'=>'EXEC-001','descr'=>'Chief Executive Officer',
                    'group1'=>'Executive','group2'=>'Corporate',
                    'curstatus'=>'FILLED','budgsal'=>285000,
                    'eeoclass'=>'Official','exempt'=>'E','salgrade'=>'G1',
                    'sallower'=>220000,'salupper'=>320000,
                    'reptocomp'=>'','reptoposno'=>'','reptodesc'=>'Board of Directors',
                    'jobcode'=>'EXE100','startdate'=>'2010-06-01','last_fil'=>'2017-03-01',
                ],
                'incumbent' => [
                    'empno'=>'BRM001','fname'=>'Robert','mi'=>'J','lname'=>'Harrison',
                    'annual'=>285000,'posstart'=>'2017-03-01','lasthire'=>'2017-03-01',
                    'sex'=>'M','race'=>'White','education'=>'Masters',
                    'jobcode'=>'EXE100','jobtitle'=>'Chief Executive Officer',
                ],
            ],
            [
                'position' => [
                    'posno'=>'EXEC-002','descr'=>'Chief Financial Officer',
                    'group1'=>'Executive','group2'=>'Corporate',
                    'curstatus'=>'FILLED','budgsal'=>225000,
                    'eeoclass'=>'Official','exempt'=>'E','salgrade'=>'G1',
                    'sallower'=>175000,'salupper'=>260000,
                    'reptocomp'=>'BRM','reptoposno'=>'EXEC-001','reptodesc'=>'Chief Executive Officer',
                    'jobcode'=>'EXE200','startdate'=>'2010-06-01','last_fil'=>'2018-07-15',
                ],
                'incumbent' => [
                    'empno'=>'BRM002','fname'=>'Sandra','mi'=>'L','lname'=>'Mitchell',
                    'annual'=>225000,'posstart'=>'2018-07-15','lasthire'=>'2018-07-15',
                    'sex'=>'F','race'=>'White','education'=>'Masters',
                    'jobcode'=>'EXE200','jobtitle'=>'Chief Financial Officer',
                ],
            ],
            [
                'position' => [
                    'posno'=>'EXEC-003','descr'=>'Chief Operating Officer',
                    'group1'=>'Executive','group2'=>'Corporate',
                    'curstatus'=>'FILLED','budgsal'=>210000,
                    'eeoclass'=>'Official','exempt'=>'E','salgrade'=>'G1',
                    'sallower'=>160000,'salupper'=>250000,
                    'reptocomp'=>'BRM','reptoposno'=>'EXEC-001','reptodesc'=>'Chief Executive Officer',
                    'jobcode'=>'EXE300','startdate'=>'2010-06-01','last_fil'=>'2019-01-20',
                ],
                'incumbent' => [
                    'empno'=>'BRM003','fname'=>'David','mi'=>'K','lname'=>'Chen',
                    'annual'=>210000,'posstart'=>'2019-01-20','lasthire'=>'2019-01-20',
                    'sex'=>'M','race'=>'Asian','education'=>'Masters',
                    'jobcode'=>'EXE300','jobtitle'=>'Chief Operating Officer',
                ],
            ],
            [
                'position' => [
                    'posno'=>'EXEC-004','descr'=>'VP of Sales',
                    'group1'=>'Executive','group2'=>'Corporate',
                    'curstatus'=>'FILLED','budgsal'=>185000,
                    'eeoclass'=>'Official','exempt'=>'E','salgrade'=>'G2',
                    'sallower'=>145000,'salupper'=>215000,
                    'reptocomp'=>'BRM','reptoposno'=>'EXEC-001','reptodesc'=>'Chief Executive Officer',
                    'jobcode'=>'EXE400','startdate'=>'2010-06-01','last_fil'=>'2020-04-01',
                ],
                'incumbent' => [
                    'empno'=>'BRM004','fname'=>'Patricia','mi'=>'A','lname'=>'Walsh',
                    'annual'=>185000,'posstart'=>'2020-04-01','lasthire'=>'2020-04-01',
                    'sex'=>'F','race'=>'White','education'=>'Masters',
                    'jobcode'=>'EXE400','jobtitle'=>'VP of Sales',
                ],
            ],
            [
                'position' => [
                    'posno'=>'EXEC-005','descr'=>'VP of Human Resources',
                    'group1'=>'Executive','group2'=>'Corporate',
                    'curstatus'=>'FILLED','budgsal'=>165000,
                    'eeoclass'=>'Official','exempt'=>'E','salgrade'=>'G2',
                    'sallower'=>130000,'salupper'=>195000,
                    'reptocomp'=>'BRM','reptoposno'=>'EXEC-001','reptodesc'=>'Chief Executive Officer',
                    'jobcode'=>'EXE500','startdate'=>'2010-06-01','last_fil'=>'2019-09-15',
                ],
                'incumbent' => [
                    'empno'=>'BRM005','fname'=>'Michael','mi'=>'R','lname'=>'Torres',
                    'annual'=>165000,'posstart'=>'2019-09-15','lasthire'=>'2019-09-15',
                    'sex'=>'M','race'=>'Hispanic','education'=>'Masters',
                    'jobcode'=>'EXE500','jobtitle'=>'VP of Human Resources',
                ],
            ],

            // ── ENGINEERING ────────────────────────────────────────────────────
            [
                'position' => [
                    'posno'=>'ENG-001','descr'=>'Engineering Manager',
                    'group1'=>'Engineering','group2'=>'Operations',
                    'curstatus'=>'FILLED','budgsal'=>125000,
                    'eeoclass'=>'Professional','exempt'=>'E','salgrade'=>'G2',
                    'sallower'=>100000,'salupper'=>150000,
                    'reptocomp'=>'BRM','reptoposno'=>'EXEC-003','reptodesc'=>'Chief Operating Officer',
                    'jobcode'=>'ENG100','startdate'=>'2012-03-01','last_fil'=>'2021-02-01',
                ],
                'incumbent' => [
                    'empno'=>'BRM006','fname'=>'Jennifer','mi'=>'S','lname'=>'Park',
                    'annual'=>125000,'posstart'=>'2021-02-01','lasthire'=>'2018-05-14',
                    'sex'=>'F','race'=>'Asian','education'=>'Bachelors',
                    'jobcode'=>'ENG100','jobtitle'=>'Engineering Manager',
                ],
            ],
            [
                'position' => [
                    'posno'=>'ENG-002','descr'=>'Sr Mechanical Engineer',
                    'group1'=>'Engineering','group2'=>'Operations',
                    'curstatus'=>'FILLED','budgsal'=>98000,
                    'eeoclass'=>'Professional','exempt'=>'E','salgrade'=>'G3',
                    'sallower'=>78000,'salupper'=>118000,
                    'reptocomp'=>'BRM','reptoposno'=>'ENG-001','reptodesc'=>'Engineering Manager',
                    'jobcode'=>'ENG200','startdate'=>'2012-03-01','last_fil'=>'2020-08-10',
                ],
                'incumbent' => [
                    'empno'=>'BRM007','fname'=>'Thomas','mi'=>'W','lname'=>'Reeves',
                    'annual'=>98000,'posstart'=>'2020-08-10','lasthire'=>'2020-08-10',
                    'sex'=>'M','race'=>'White','education'=>'Bachelors',
                    'jobcode'=>'ENG200','jobtitle'=>'Sr Mechanical Engineer',
                ],
            ],
            [
                'position' => [
                    'posno'=>'ENG-003','descr'=>'Sr Electrical Engineer',
                    'group1'=>'Engineering','group2'=>'Operations',
                    'curstatus'=>'FILLED','budgsal'=>102000,
                    'eeoclass'=>'Professional','exempt'=>'E','salgrade'=>'G3',
                    'sallower'=>82000,'salupper'=>122000,
                    'reptocomp'=>'BRM','reptoposno'=>'ENG-001','reptodesc'=>'Engineering Manager',
                    'jobcode'=>'ENG300','startdate'=>'2012-03-01','last_fil'=>'2022-03-14',
                ],
                'incumbent' => [
                    'empno'=>'BRM008','fname'=>'Lisa','mi'=>'T','lname'=>'Nguyen',
                    'annual'=>102000,'posstart'=>'2022-03-14','lasthire'=>'2022-03-14',
                    'sex'=>'F','race'=>'Asian','education'=>'Bachelors',
                    'jobcode'=>'ENG300','jobtitle'=>'Sr Electrical Engineer',
                ],
            ],
            [
                'position' => [
                    'posno'=>'ENG-004','descr'=>'Manufacturing Engineer',
                    'group1'=>'Engineering','group2'=>'Operations',
                    'curstatus'=>'FILLED','budgsal'=>82000,
                    'eeoclass'=>'Professional','exempt'=>'E','salgrade'=>'G4',
                    'sallower'=>65000,'salupper'=>98000,
                    'reptocomp'=>'BRM','reptoposno'=>'ENG-001','reptodesc'=>'Engineering Manager',
                    'jobcode'=>'ENG400','startdate'=>'2012-03-01','last_fil'=>'2023-01-09',
                ],
                'incumbent' => [
                    'empno'=>'BRM009','fname'=>'Brian','mi'=>'C','lname'=>'Cooper',
                    'annual'=>82000,'posstart'=>'2023-01-09','lasthire'=>'2023-01-09',
                    'sex'=>'M','race'=>'Black','education'=>'Bachelors',
                    'jobcode'=>'ENG400','jobtitle'=>'Manufacturing Engineer',
                ],
            ],
            [
                'position' => [
                    'posno'=>'ENG-005','descr'=>'Quality Engineer',
                    'group1'=>'Engineering','group2'=>'Operations',
                    'curstatus'=>'FILLED','budgsal'=>78000,
                    'eeoclass'=>'Professional','exempt'=>'E','salgrade'=>'G4',
                    'sallower'=>60000,'salupper'=>94000,
                    'reptocomp'=>'BRM','reptoposno'=>'ENG-001','reptodesc'=>'Engineering Manager',
                    'jobcode'=>'ENG500','startdate'=>'2012-03-01','last_fil'=>'2022-07-25',
                ],
                'incumbent' => [
                    'empno'=>'BRM010','fname'=>'Angela','mi'=>'M','lname'=>'Foster',
                    'annual'=>78000,'posstart'=>'2022-07-25','lasthire'=>'2022-07-25',
                    'sex'=>'F','race'=>'White','education'=>'Bachelors',
                    'jobcode'=>'ENG500','jobtitle'=>'Quality Engineer',
                ],
            ],

            // ── OPERATIONS ─────────────────────────────────────────────────────
            [
                'position' => [
                    'posno'=>'OPS-001','descr'=>'Plant Manager',
                    'group1'=>'Operations','group2'=>'Manufacturing',
                    'curstatus'=>'FILLED','budgsal'=>108000,
                    'eeoclass'=>'Official','exempt'=>'E','salgrade'=>'G2',
                    'sallower'=>88000,'salupper'=>130000,
                    'reptocomp'=>'BRM','reptoposno'=>'EXEC-003','reptodesc'=>'Chief Operating Officer',
                    'jobcode'=>'OPS100','startdate'=>'2010-06-01','last_fil'=>'2021-05-03',
                ],
                'incumbent' => [
                    'empno'=>'BRM011','fname'=>'Christopher','mi'=>'B','lname'=>'Walsh',
                    'annual'=>108000,'posstart'=>'2021-05-03','lasthire'=>'2016-09-12',
                    'sex'=>'M','race'=>'White','education'=>'Bachelors',
                    'jobcode'=>'OPS100','jobtitle'=>'Plant Manager',
                ],
            ],
            [
                'position' => [
                    'posno'=>'OPS-002','descr'=>'Production Supervisor',
                    'group1'=>'Operations','group2'=>'Manufacturing',
                    'curstatus'=>'FILLED','budgsal'=>72000,
                    'eeoclass'=>'Official','exempt'=>'E','salgrade'=>'G3',
                    'sallower'=>58000,'salupper'=>86000,
                    'reptocomp'=>'BRM','reptoposno'=>'OPS-001','reptodesc'=>'Plant Manager',
                    'jobcode'=>'OPS200','startdate'=>'2010-06-01','last_fil'=>'2022-09-19',
                ],
                'incumbent' => [
                    'empno'=>'BRM012','fname'=>'Maria','mi'=>'E','lname'=>'Rodriguez',
                    'annual'=>72000,'posstart'=>'2022-09-19','lasthire'=>'2022-09-19',
                    'sex'=>'F','race'=>'Hispanic','education'=>'Some College',
                    'jobcode'=>'OPS200','jobtitle'=>'Production Supervisor',
                ],
            ],
            [
                'position' => [
                    'posno'=>'OPS-003','descr'=>'Maintenance Manager',
                    'group1'=>'Operations','group2'=>'Manufacturing',
                    'curstatus'=>'FILLED','budgsal'=>85000,
                    'eeoclass'=>'Official','exempt'=>'E','salgrade'=>'G3',
                    'sallower'=>68000,'salupper'=>102000,
                    'reptocomp'=>'BRM','reptoposno'=>'OPS-001','reptodesc'=>'Plant Manager',
                    'jobcode'=>'OPS300','startdate'=>'2010-06-01','last_fil'=>'2021-11-08',
                ],
                'incumbent' => [
                    'empno'=>'BRM013','fname'=>'Kevin','mi'=>'D','lname'=>'Brown',
                    'annual'=>85000,'posstart'=>'2021-11-08','lasthire'=>'2015-04-22',
                    'sex'=>'M','race'=>'Black','education'=>'Bachelors',
                    'jobcode'=>'OPS300','jobtitle'=>'Maintenance Manager',
                ],
            ],
            [
                'position' => [
                    'posno'=>'OPS-004','descr'=>'Warehouse Manager',
                    'group1'=>'Operations','group2'=>'Manufacturing',
                    'curstatus'=>'FILLED','budgsal'=>68000,
                    'eeoclass'=>'Official','exempt'=>'E','salgrade'=>'G3',
                    'sallower'=>54000,'salupper'=>82000,
                    'reptocomp'=>'BRM','reptoposno'=>'OPS-001','reptodesc'=>'Plant Manager',
                    'jobcode'=>'OPS400','startdate'=>'2010-06-01','last_fil'=>'2023-03-27',
                ],
                'incumbent' => [
                    'empno'=>'BRM014','fname'=>'Rachel','mi'=>'H','lname'=>'Kim',
                    'annual'=>68000,'posstart'=>'2023-03-27','lasthire'=>'2023-03-27',
                    'sex'=>'F','race'=>'Asian','education'=>'Bachelors',
                    'jobcode'=>'OPS400','jobtitle'=>'Warehouse Manager',
                ],
            ],
            [
                'position' => [
                    'posno'=>'OPS-005','descr'=>'Safety Manager',
                    'group1'=>'Operations','group2'=>'Manufacturing',
                    'curstatus'=>'FILLED','budgsal'=>75000,
                    'eeoclass'=>'Professional','exempt'=>'E','salgrade'=>'G3',
                    'sallower'=>60000,'salupper'=>90000,
                    'reptocomp'=>'BRM','reptoposno'=>'OPS-001','reptodesc'=>'Plant Manager',
                    'jobcode'=>'OPS500','startdate'=>'2010-06-01','last_fil'=>'2022-01-17',
                ],
                'incumbent' => [
                    'empno'=>'BRM015','fname'=>'Daniel','mi'=>'A','lname'=>'Martinez',
                    'annual'=>75000,'posstart'=>'2022-01-17','lasthire'=>'2019-06-03',
                    'sex'=>'M','race'=>'Hispanic','education'=>'Bachelors',
                    'jobcode'=>'OPS500','jobtitle'=>'Safety Manager',
                ],
            ],
            [
                'position' => [
                    'posno'=>'OPS-006','descr'=>'Production Supervisor II',
                    'group1'=>'Operations','group2'=>'Manufacturing',
                    'curstatus'=>'VACANT','budgsal'=>68000,
                    'eeoclass'=>'Official','exempt'=>'E','salgrade'=>'G3',
                    'sallower'=>54000,'salupper'=>82000,
                    'reptocomp'=>'BRM','reptoposno'=>'OPS-001','reptodesc'=>'Plant Manager',
                    'jobcode'=>'OPS200','startdate'=>'2024-01-15',
                ],
            ],
            [
                'position' => [
                    'posno'=>'OPS-007','descr'=>'Maintenance Technician',
                    'group1'=>'Operations','group2'=>'Manufacturing',
                    'curstatus'=>'VACANT','budgsal'=>52000,
                    'eeoclass'=>'Craft','exempt'=>'N','salgrade'=>'G5',
                    'sallower'=>42000,'salupper'=>62000,
                    'reptocomp'=>'BRM','reptoposno'=>'OPS-003','reptodesc'=>'Maintenance Manager',
                    'jobcode'=>'OPS700','startdate'=>'2024-03-01',
                ],
            ],

            // ── SALES ──────────────────────────────────────────────────────────
            [
                'position' => [
                    'posno'=>'SAL-001','descr'=>'Sales Manager',
                    'group1'=>'Sales','group2'=>'Sales & Marketing',
                    'curstatus'=>'FILLED','budgsal'=>115000,
                    'eeoclass'=>'Official','exempt'=>'E','salgrade'=>'G2',
                    'sallower'=>90000,'salupper'=>140000,
                    'reptocomp'=>'BRM','reptoposno'=>'EXEC-004','reptodesc'=>'VP of Sales',
                    'jobcode'=>'SAL100','startdate'=>'2010-06-01','last_fil'=>'2020-10-05',
                ],
                'incumbent' => [
                    'empno'=>'BRM016','fname'=>'Susan','mi'=>'K','lname'=>'Thompson',
                    'annual'=>115000,'posstart'=>'2020-10-05','lasthire'=>'2020-10-05',
                    'sex'=>'F','race'=>'White','education'=>'Bachelors',
                    'jobcode'=>'SAL100','jobtitle'=>'Sales Manager',
                ],
            ],
            [
                'position' => [
                    'posno'=>'SAL-002','descr'=>'Sr Account Executive',
                    'group1'=>'Sales','group2'=>'Sales & Marketing',
                    'curstatus'=>'FILLED','budgsal'=>88000,
                    'eeoclass'=>'Sales','exempt'=>'E','salgrade'=>'G3',
                    'sallower'=>68000,'salupper'=>108000,
                    'reptocomp'=>'BRM','reptoposno'=>'SAL-001','reptodesc'=>'Sales Manager',
                    'jobcode'=>'SAL200','startdate'=>'2015-01-01','last_fil'=>'2021-06-21',
                ],
                'incumbent' => [
                    'empno'=>'BRM017','fname'=>'James','mi'=>'O','lname'=>'Anderson',
                    'annual'=>88000,'posstart'=>'2021-06-21','lasthire'=>'2021-06-21',
                    'sex'=>'M','race'=>'Black','education'=>'Bachelors',
                    'jobcode'=>'SAL200','jobtitle'=>'Sr Account Executive',
                ],
            ],
            [
                'position' => [
                    'posno'=>'SAL-003','descr'=>'Account Executive',
                    'group1'=>'Sales','group2'=>'Sales & Marketing',
                    'curstatus'=>'FILLED','budgsal'=>70000,
                    'eeoclass'=>'Sales','exempt'=>'E','salgrade'=>'G4',
                    'sallower'=>55000,'salupper'=>85000,
                    'reptocomp'=>'BRM','reptoposno'=>'SAL-001','reptodesc'=>'Sales Manager',
                    'jobcode'=>'SAL300','startdate'=>'2015-01-01','last_fil'=>'2023-08-14',
                ],
                'incumbent' => [
                    'empno'=>'BRM018','fname'=>'Nicole','mi'=>'P','lname'=>'Garcia',
                    'annual'=>70000,'posstart'=>'2023-08-14','lasthire'=>'2023-08-14',
                    'sex'=>'F','race'=>'Hispanic','education'=>'Bachelors',
                    'jobcode'=>'SAL300','jobtitle'=>'Account Executive',
                ],
            ],
            [
                'position' => [
                    'posno'=>'SAL-004','descr'=>'Account Executive II',
                    'group1'=>'Sales','group2'=>'Sales & Marketing',
                    'curstatus'=>'VACANT','budgsal'=>65000,
                    'eeoclass'=>'Sales','exempt'=>'E','salgrade'=>'G4',
                    'sallower'=>52000,'salupper'=>78000,
                    'reptocomp'=>'BRM','reptoposno'=>'SAL-001','reptodesc'=>'Sales Manager',
                    'jobcode'=>'SAL300','startdate'=>'2025-09-01',
                ],
            ],

            // ── FINANCE ────────────────────────────────────────────────────────
            [
                'position' => [
                    'posno'=>'FIN-001','descr'=>'Controller',
                    'group1'=>'Finance','group2'=>'Corporate',
                    'curstatus'=>'FILLED','budgsal'=>92000,
                    'eeoclass'=>'Professional','exempt'=>'E','salgrade'=>'G3',
                    'sallower'=>72000,'salupper'=>112000,
                    'reptocomp'=>'BRM','reptoposno'=>'EXEC-002','reptodesc'=>'Chief Financial Officer',
                    'jobcode'=>'FIN100','startdate'=>'2010-06-01','last_fil'=>'2020-06-01',
                ],
                'incumbent' => [
                    'empno'=>'BRM019','fname'=>'William','mi'=>'G','lname'=>'Chen',
                    'annual'=>92000,'posstart'=>'2020-06-01','lasthire'=>'2020-06-01',
                    'sex'=>'M','race'=>'Asian','education'=>'Masters',
                    'jobcode'=>'FIN100','jobtitle'=>'Controller',
                ],
            ],
            [
                'position' => [
                    'posno'=>'FIN-002','descr'=>'Senior Accountant',
                    'group1'=>'Finance','group2'=>'Corporate',
                    'curstatus'=>'FILLED','budgsal'=>68000,
                    'eeoclass'=>'Professional','exempt'=>'E','salgrade'=>'G4',
                    'sallower'=>54000,'salupper'=>82000,
                    'reptocomp'=>'BRM','reptoposno'=>'FIN-001','reptodesc'=>'Controller',
                    'jobcode'=>'FIN200','startdate'=>'2010-06-01','last_fil'=>'2022-11-28',
                ],
                'incumbent' => [
                    'empno'=>'BRM020','fname'=>'Emily','mi'=>'R','lname'=>'Davis',
                    'annual'=>68000,'posstart'=>'2022-11-28','lasthire'=>'2022-11-28',
                    'sex'=>'F','race'=>'White','education'=>'Bachelors',
                    'jobcode'=>'FIN200','jobtitle'=>'Senior Accountant',
                ],
            ],
            [
                'position' => [
                    'posno'=>'FIN-003','descr'=>'Staff Accountant',
                    'group1'=>'Finance','group2'=>'Corporate',
                    'curstatus'=>'VACANT','budgsal'=>52000,
                    'eeoclass'=>'Professional','exempt'=>'E','salgrade'=>'G5',
                    'sallower'=>42000,'salupper'=>62000,
                    'reptocomp'=>'BRM','reptoposno'=>'FIN-001','reptodesc'=>'Controller',
                    'jobcode'=>'FIN300','startdate'=>'2025-06-01',
                ],
            ],

            // ── HUMAN RESOURCES ────────────────────────────────────────────────
            [
                'position' => [
                    'posno'=>'HR-001','descr'=>'HR Manager',
                    'group1'=>'Human Resources','group2'=>'Corporate',
                    'curstatus'=>'FILLED','budgsal'=>80000,
                    'eeoclass'=>'Professional','exempt'=>'E','salgrade'=>'G3',
                    'sallower'=>64000,'salupper'=>96000,
                    'reptocomp'=>'BRM','reptoposno'=>'EXEC-005','reptodesc'=>'VP of Human Resources',
                    'jobcode'=>'HR100','startdate'=>'2010-06-01','last_fil'=>'2021-08-09',
                ],
                'incumbent' => [
                    'empno'=>'BRM021','fname'=>'Margaret','mi'=>'L','lname'=>'Wilson',
                    'annual'=>80000,'posstart'=>'2021-08-09','lasthire'=>'2021-08-09',
                    'sex'=>'F','race'=>'White','education'=>'Bachelors',
                    'jobcode'=>'HR100','jobtitle'=>'HR Manager',
                ],
            ],
            [
                'position' => [
                    'posno'=>'HR-002','descr'=>'HR Generalist',
                    'group1'=>'Human Resources','group2'=>'Corporate',
                    'curstatus'=>'FILLED','budgsal'=>58000,
                    'eeoclass'=>'Professional','exempt'=>'E','salgrade'=>'G4',
                    'sallower'=>46000,'salupper'=>70000,
                    'reptocomp'=>'BRM','reptoposno'=>'HR-001','reptodesc'=>'HR Manager',
                    'jobcode'=>'HR200','startdate'=>'2010-06-01','last_fil'=>'2024-01-15',
                ],
                'incumbent' => [
                    'empno'=>'BRM022','fname'=>'Anthony','mi'=>'J','lname'=>'Lee',
                    'annual'=>58000,'posstart'=>'2024-01-15','lasthire'=>'2024-01-15',
                    'sex'=>'M','race'=>'Asian','education'=>'Bachelors',
                    'jobcode'=>'HR200','jobtitle'=>'HR Generalist',
                ],
            ],
            [
                'position' => [
                    'posno'=>'HR-003','descr'=>'Recruiter',
                    'group1'=>'Human Resources','group2'=>'Corporate',
                    'curstatus'=>'VACANT','budgsal'=>52000,
                    'eeoclass'=>'Professional','exempt'=>'E','salgrade'=>'G4',
                    'sallower'=>42000,'salupper'=>62000,
                    'reptocomp'=>'BRM','reptoposno'=>'HR-001','reptodesc'=>'HR Manager',
                    'jobcode'=>'HR300','startdate'=>'2025-11-01',
                ],
            ],

        ];
    }
}
