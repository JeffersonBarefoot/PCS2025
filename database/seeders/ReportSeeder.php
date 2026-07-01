<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeds the system report library: columns and queries for all Tier 1 reports.
 * This seeder is idempotent — safe to run after migrate:fresh or standalone.
 *
 * Report IDs:
 *   1000 Position Listing          (POS)
 *   1010 Position Reports To       (POS)
 *   1020 Position Direct Reports   (POS)
 *   1030 Positions by Filled Status(POS)
 *   1040 Vacant Positions          (VAC)
 *   1050 Positions by Org Level    (POS)
 *   2000 Position History Listing  (POSH)
 *   3000 Incumbent Listing         (INC)
 *   3010 Incumbent by Position     (INC)
 *   3020 Salary Listing            (INC)
 *   3030 FTE Summary               (INC)
 *   4000 Incumbent History Listing (INCH)
 *   5000 Budget vs Actual Summary  (BUDG)
 *   5010 Budget by Department      (BUDG)
 */
class ReportSeeder extends Seeder
{
    public function run(): void
    {
        // Clear migration-seeded data so we control all columns/queries from here
        DB::table('reportcolumns')->whereIn('reportid', $this->tier1Ids())->delete();
        DB::table('reportqueries')->whereIn('reportid', $this->tier1Ids())->delete();
        DB::table('reportgroups')->whereIn('reportid', $this->tier1Ids())->delete();

        // Ensure all Tier 1 system reports exist in the reports table
        $this->ensureReports();

        // Seed columns and queries for each report
        $this->seedColumns();
        $this->seedQueries();
    }

    // ---------------------------------------------------------------
    // ENSURE REPORTS EXIST
    // ---------------------------------------------------------------
    private function ensureReports(): void
    {
        $existing = DB::table('reports')
            ->whereIn('reportid', $this->tier1Ids())
            ->where('is_system', true)
            ->pluck('reportid')
            ->flip();

        $toInsert = array_filter([
            // POS reports
            !isset($existing[1000]) ? ['reportid'=>1000,'group1'=>'POS','group2'=>'1','sortorder'=>'1000','descr'=>'Position Listing',         'notes'=>'All positions with status and budget','active'=>'A','is_system'=>true] : null,
            !isset($existing[1010]) ? ['reportid'=>1010,'group1'=>'POS','group2'=>'1','sortorder'=>'1010','descr'=>'Position Reports To',       'notes'=>'Positions grouped by supervisor chain','active'=>'A','is_system'=>true] : null,
            !isset($existing[1020]) ? ['reportid'=>1020,'group1'=>'POS','group2'=>'1','sortorder'=>'1020','descr'=>'Position Direct Reports',   'notes'=>'Summary of incumbents per position','active'=>'A','is_system'=>true] : null,
            !isset($existing[1030]) ? ['reportid'=>1030,'group1'=>'POS','group2'=>'1','sortorder'=>'1030','descr'=>'Positions by Filled Status','notes'=>'Grouped by FILLED/VACANT/PARTIALLY FILLED/OVERFILLED','active'=>'A','is_system'=>true] : null,
            !isset($existing[1040]) ? ['reportid'=>1040,'group1'=>'VAC','group2'=>'1','sortorder'=>'1040','descr'=>'Vacant Positions',          'notes'=>'All currently vacant positions','active'=>'A','is_system'=>true] : null,
            !isset($existing[1050]) ? ['reportid'=>1050,'group1'=>'POS','group2'=>'1','sortorder'=>'1050','descr'=>'Positions by Org Level',    'notes'=>'Positions grouped by Level 1 and Level 2','active'=>'A','is_system'=>true] : null,
            // INC reports
            !isset($existing[3000]) ? ['reportid'=>3000,'group1'=>'INC','group2'=>'1','sortorder'=>'3000','descr'=>'Incumbent Listing',         'notes'=>'All active incumbents with position and cost','active'=>'A','is_system'=>true] : null,
            !isset($existing[3010]) ? ['reportid'=>3010,'group1'=>'INC','group2'=>'1','sortorder'=>'3010','descr'=>'Incumbent by Position',     'notes'=>'Incumbents grouped by position','active'=>'A','is_system'=>true] : null,
            !isset($existing[3020]) ? ['reportid'=>3020,'group1'=>'INC','group2'=>'1','sortorder'=>'3020','descr'=>'Salary Listing',            'notes'=>'Incumbent salaries and rates','active'=>'A','is_system'=>true] : null,
            !isset($existing[3030]) ? ['reportid'=>3030,'group1'=>'INC','group2'=>'1','sortorder'=>'3030','descr'=>'FTE Summary',               'notes'=>'Full-time equivalent totals by department','active'=>'A','is_system'=>true] : null,
            // POSH reports
            !isset($existing[2000]) ? ['reportid'=>2000,'group1'=>'POSH','group2'=>'1','sortorder'=>'2000','descr'=>'Position History Listing', 'notes'=>'Position change history with effective dates','active'=>'A','is_system'=>true] : null,
            // INCH reports
            !isset($existing[4000]) ? ['reportid'=>4000,'group1'=>'INCH','group2'=>'1','sortorder'=>'4000','descr'=>'Incumbent History Listing', 'notes'=>'Incumbent change history with effective dates','active'=>'A','is_system'=>true] : null,
            // BUDG reports
            !isset($existing[5000]) ? ['reportid'=>5000,'group1'=>'BUDG','group2'=>'1','sortorder'=>'5000','descr'=>'Budget vs Actual Summary', 'notes'=>'Budgeted vs actual cost and FTE by position','active'=>'A','is_system'=>true] : null,
            !isset($existing[5010]) ? ['reportid'=>5010,'group1'=>'BUDG','group2'=>'1','sortorder'=>'5010','descr'=>'Budget by Department',     'notes'=>'Budget totals rolled up by Level 1 department','active'=>'A','is_system'=>true] : null,
        ]);

        if (!empty($toInsert)) {
            DB::table('reports')->insert(array_values($toInsert));
        }
    }

    // ---------------------------------------------------------------
    // REPORT COLUMNS
    // ---------------------------------------------------------------
    private function seedColumns(): void
    {
        $col = fn(array $f) => array_merge([
            'reportid'    => 0,
            'columnorder' => 10,
            'table'       => '',
            'field'       => '',
            'header'      => '',
            'sortable'    => 'Y',
            'sortorder'   => 0,
            'grouporder'  => 0,
            'format'      => '',
            'subtotal'    => 'N',
            'total'       => 'N',
            'count'       => 'N',
            'hidden'      => 'N',
        ], $f);

        DB::table('reportcolumns')->insert([

            // 1000 — Position Listing
            $col(['reportid'=>1000,'columnorder'=>10, 'table'=>'positions','field'=>'posno',         'header'=>'Pos #',          'sortorder'=>1]),
            $col(['reportid'=>1000,'columnorder'=>20, 'table'=>'positions','field'=>'descr',         'header'=>'Position',       'sortorder'=>2]),
            $col(['reportid'=>1000,'columnorder'=>30, 'table'=>'positions','field'=>'level1',        'header'=>'Location',       'sortorder'=>3]),
            $col(['reportid'=>1000,'columnorder'=>40, 'table'=>'positions','field'=>'level2',        'header'=>'Department',     'sortorder'=>4]),
            $col(['reportid'=>1000,'columnorder'=>50, 'table'=>'positions','field'=>'curstatus',     'header'=>'Status',         'sortorder'=>5]),
            $col(['reportid'=>1000,'columnorder'=>60, 'table'=>'positions','field'=>'fulltimeequiv', 'header'=>'FTE',            'format'=>'R#,2']),
            $col(['reportid'=>1000,'columnorder'=>70, 'table'=>'positions','field'=>'budgsal',       'header'=>'Budg Salary',    'format'=>'R$,2']),
            $col(['reportid'=>1000,'columnorder'=>80, 'table'=>'positions','field'=>'exempt',        'header'=>'Exempt']),
            $col(['reportid'=>1000,'columnorder'=>90, 'table'=>'positions','field'=>'startdate',     'header'=>'Start Date',     'format'=>'DATE']),

            // 1010 — Position Reports To
            $col(['reportid'=>1010,'columnorder'=>10, 'table'=>'positions','field'=>'reptodesc',     'header'=>'Reports To',     'sortorder'=>1]),
            $col(['reportid'=>1010,'columnorder'=>20, 'table'=>'positions','field'=>'reptoposno',    'header'=>'Rpt-To Pos #',   'sortorder'=>2]),
            $col(['reportid'=>1010,'columnorder'=>30, 'table'=>'positions','field'=>'posno',         'header'=>'Pos #',          'sortorder'=>3]),
            $col(['reportid'=>1010,'columnorder'=>40, 'table'=>'positions','field'=>'descr',         'header'=>'Position',       'sortorder'=>4]),
            $col(['reportid'=>1010,'columnorder'=>50, 'table'=>'positions','field'=>'level1',        'header'=>'Location']),
            $col(['reportid'=>1010,'columnorder'=>60, 'table'=>'positions','field'=>'curstatus',     'header'=>'Status']),
            $col(['reportid'=>1010,'columnorder'=>70, 'table'=>'positions','field'=>'budgsal',       'header'=>'Budg Salary',    'format'=>'R$,2']),

            // 1020 — Position Direct Reports
            $col(['reportid'=>1020,'columnorder'=>10, 'table'=>'positions','field'=>'posno',         'header'=>'Pos #',          'sortorder'=>1]),
            $col(['reportid'=>1020,'columnorder'=>20, 'table'=>'positions','field'=>'descr',         'header'=>'Position',       'sortorder'=>2]),
            $col(['reportid'=>1020,'columnorder'=>30, 'table'=>'positions','field'=>'curstatus',     'header'=>'Status',         'sortorder'=>3]),
            $col(['reportid'=>1020,'columnorder'=>40, 'table'=>'positions','field'=>'reptodesc',     'header'=>'Reports To']),
            $col(['reportid'=>1020,'columnorder'=>50, 'table'=>'positions','field'=>'level1',        'header'=>'Location']),
            $col(['reportid'=>1020,'columnorder'=>60, 'table'=>'positions','field'=>'level2',        'header'=>'Department']),

            // 1030 — Positions by Filled Status
            $col(['reportid'=>1030,'columnorder'=>10, 'table'=>'positions','field'=>'curstatus',     'header'=>'Status',         'sortorder'=>1]),
            $col(['reportid'=>1030,'columnorder'=>20, 'table'=>'positions','field'=>'posno',         'header'=>'Pos #',          'sortorder'=>2]),
            $col(['reportid'=>1030,'columnorder'=>30, 'table'=>'positions','field'=>'descr',         'header'=>'Position',       'sortorder'=>3]),
            $col(['reportid'=>1030,'columnorder'=>40, 'table'=>'positions','field'=>'level1',        'header'=>'Location']),
            $col(['reportid'=>1030,'columnorder'=>50, 'table'=>'positions','field'=>'level2',        'header'=>'Department']),
            $col(['reportid'=>1030,'columnorder'=>60, 'table'=>'positions','field'=>'budgsal',       'header'=>'Budg Salary',    'format'=>'R$,2']),
            $col(['reportid'=>1030,'columnorder'=>70, 'table'=>'positions','field'=>'fulltimeequiv', 'header'=>'FTE',            'format'=>'R#,2']),

            // 1040 — Vacant Positions
            $col(['reportid'=>1040,'columnorder'=>10, 'table'=>'positions','field'=>'posno',         'header'=>'Pos #',          'sortorder'=>1]),
            $col(['reportid'=>1040,'columnorder'=>20, 'table'=>'positions','field'=>'descr',         'header'=>'Position',       'sortorder'=>2]),
            $col(['reportid'=>1040,'columnorder'=>30, 'table'=>'positions','field'=>'level1',        'header'=>'Location',       'sortorder'=>3]),
            $col(['reportid'=>1040,'columnorder'=>40, 'table'=>'positions','field'=>'level2',        'header'=>'Department']),
            $col(['reportid'=>1040,'columnorder'=>50, 'table'=>'positions','field'=>'budgsal',       'header'=>'Budg Salary',    'format'=>'R$,2']),
            $col(['reportid'=>1040,'columnorder'=>60, 'table'=>'positions','field'=>'avail_date',    'header'=>'Available Date', 'format'=>'DATE']),
            $col(['reportid'=>1040,'columnorder'=>70, 'table'=>'positions','field'=>'salgrade',      'header'=>'Grade']),

            // 1050 — Positions by Org Level
            $col(['reportid'=>1050,'columnorder'=>10, 'table'=>'positions','field'=>'level1',        'header'=>'Location',       'sortorder'=>1]),
            $col(['reportid'=>1050,'columnorder'=>20, 'table'=>'positions','field'=>'level2',        'header'=>'Department',     'sortorder'=>2]),
            $col(['reportid'=>1050,'columnorder'=>30, 'table'=>'positions','field'=>'posno',         'header'=>'Pos #',          'sortorder'=>3]),
            $col(['reportid'=>1050,'columnorder'=>40, 'table'=>'positions','field'=>'descr',         'header'=>'Position',       'sortorder'=>4]),
            $col(['reportid'=>1050,'columnorder'=>50, 'table'=>'positions','field'=>'curstatus',     'header'=>'Status']),
            $col(['reportid'=>1050,'columnorder'=>60, 'table'=>'positions','field'=>'budgsal',       'header'=>'Budg Salary',    'format'=>'R$,2']),
            $col(['reportid'=>1050,'columnorder'=>70, 'table'=>'positions','field'=>'fulltimeequiv', 'header'=>'FTE',            'format'=>'R#,2']),

            // 3000 — Incumbent Listing
            $col(['reportid'=>3000,'columnorder'=>10, 'table'=>'incumbents','field'=>'empno',        'header'=>'Emp #',          'sortorder'=>1]),
            $col(['reportid'=>3000,'columnorder'=>20, 'table'=>'incumbents','field'=>'lname',        'header'=>'Last Name',      'sortorder'=>2]),
            $col(['reportid'=>3000,'columnorder'=>30, 'table'=>'incumbents','field'=>'fname',        'header'=>'First Name',     'sortorder'=>3]),
            $col(['reportid'=>3000,'columnorder'=>40, 'table'=>'positions', 'field'=>'posno',        'header'=>'Pos #']),
            $col(['reportid'=>3000,'columnorder'=>50, 'table'=>'positions', 'field'=>'descr',        'header'=>'Position']),
            $col(['reportid'=>3000,'columnorder'=>60, 'table'=>'incumbents','field'=>'level1',       'header'=>'Location']),
            $col(['reportid'=>3000,'columnorder'=>70, 'table'=>'incumbents','field'=>'level2',       'header'=>'Department']),
            $col(['reportid'=>3000,'columnorder'=>80, 'table'=>'incumbents','field'=>'jobtitle',     'header'=>'Job Title']),
            $col(['reportid'=>3000,'columnorder'=>90, 'table'=>'incumbents','field'=>'ann_cost',     'header'=>'Ann Cost',       'format'=>'R$,2']),

            // 3010 — Incumbent by Position
            $col(['reportid'=>3010,'columnorder'=>10, 'table'=>'positions', 'field'=>'posno',        'header'=>'Pos #',          'sortorder'=>1]),
            $col(['reportid'=>3010,'columnorder'=>20, 'table'=>'positions', 'field'=>'descr',        'header'=>'Position',       'sortorder'=>2]),
            $col(['reportid'=>3010,'columnorder'=>30, 'table'=>'incumbents','field'=>'empno',        'header'=>'Emp #',          'sortorder'=>3]),
            $col(['reportid'=>3010,'columnorder'=>40, 'table'=>'incumbents','field'=>'lname',        'header'=>'Last Name',      'sortorder'=>4]),
            $col(['reportid'=>3010,'columnorder'=>50, 'table'=>'incumbents','field'=>'fname',        'header'=>'First Name']),
            $col(['reportid'=>3010,'columnorder'=>60, 'table'=>'incumbents','field'=>'jobtitle',     'header'=>'Job Title']),
            $col(['reportid'=>3010,'columnorder'=>70, 'table'=>'incumbents','field'=>'fulltimeequiv','header'=>'FTE',            'format'=>'R#,2']),
            $col(['reportid'=>3010,'columnorder'=>80, 'table'=>'incumbents','field'=>'ann_cost',     'header'=>'Ann Cost',       'format'=>'R$,2']),

            // 3020 — Salary Listing
            $col(['reportid'=>3020,'columnorder'=>10, 'table'=>'incumbents','field'=>'empno',        'header'=>'Emp #',          'sortorder'=>1]),
            $col(['reportid'=>3020,'columnorder'=>20, 'table'=>'incumbents','field'=>'lname',        'header'=>'Last Name',      'sortorder'=>2]),
            $col(['reportid'=>3020,'columnorder'=>30, 'table'=>'incumbents','field'=>'fname',        'header'=>'First Name',     'sortorder'=>3]),
            $col(['reportid'=>3020,'columnorder'=>40, 'table'=>'positions', 'field'=>'descr',        'header'=>'Position']),
            $col(['reportid'=>3020,'columnorder'=>50, 'table'=>'incumbents','field'=>'jobtitle',     'header'=>'Job Title']),
            $col(['reportid'=>3020,'columnorder'=>60, 'table'=>'incumbents','field'=>'unitrate',     'header'=>'Pay Rate',       'format'=>'R$,2']),
            $col(['reportid'=>3020,'columnorder'=>70, 'table'=>'incumbents','field'=>'payfreq',      'header'=>'Pay Freq']),
            $col(['reportid'=>3020,'columnorder'=>80, 'table'=>'incumbents','field'=>'ann_cost',     'header'=>'Ann Cost',       'format'=>'R$,2','total'=>'Y']),

            // 3030 — FTE Summary
            $col(['reportid'=>3030,'columnorder'=>10, 'table'=>'incumbents','field'=>'level1',       'header'=>'Location',       'sortorder'=>1]),
            $col(['reportid'=>3030,'columnorder'=>20, 'table'=>'incumbents','field'=>'level2',       'header'=>'Department',     'sortorder'=>2]),
            $col(['reportid'=>3030,'columnorder'=>30, 'table'=>'incumbents','field'=>'empno',        'header'=>'Emp #',          'sortorder'=>3]),
            $col(['reportid'=>3030,'columnorder'=>40, 'table'=>'incumbents','field'=>'lname',        'header'=>'Last Name',      'sortorder'=>4]),
            $col(['reportid'=>3030,'columnorder'=>50, 'table'=>'incumbents','field'=>'fname',        'header'=>'First Name']),
            $col(['reportid'=>3030,'columnorder'=>60, 'table'=>'incumbents','field'=>'fulltimeequiv','header'=>'FTE',            'format'=>'R#,2','total'=>'Y']),
            $col(['reportid'=>3030,'columnorder'=>70, 'table'=>'positions', 'field'=>'fulltimeequiv','header'=>'Budg FTE',       'format'=>'R#,2']),

            // 2000 — Position History Listing
            $col(['reportid'=>2000,'columnorder'=>10, 'table'=>'positions',  'field'=>'posno',        'header'=>'Pos #',         'sortorder'=>1]),
            $col(['reportid'=>2000,'columnorder'=>20, 'table'=>'hpositions', 'field'=>'historystart', 'header'=>'Hist Start',    'sortorder'=>2, 'format'=>'DATE']),
            $col(['reportid'=>2000,'columnorder'=>30, 'table'=>'hpositions', 'field'=>'historyend',   'header'=>'Hist End',      'sortorder'=>3, 'format'=>'DATE']),
            $col(['reportid'=>2000,'columnorder'=>40, 'table'=>'hpositions', 'field'=>'descr',        'header'=>'Position']),
            $col(['reportid'=>2000,'columnorder'=>50, 'table'=>'hpositions', 'field'=>'level1',       'header'=>'Level 1']),
            $col(['reportid'=>2000,'columnorder'=>60, 'table'=>'hpositions', 'field'=>'level2',       'header'=>'Level 2']),
            $col(['reportid'=>2000,'columnorder'=>70, 'table'=>'hpositions', 'field'=>'curstatus',    'header'=>'Status']),
            $col(['reportid'=>2000,'columnorder'=>80, 'table'=>'hpositions', 'field'=>'budgsal',      'header'=>'Budg Salary',   'format'=>'R$,2']),
            $col(['reportid'=>2000,'columnorder'=>90, 'table'=>'hpositions', 'field'=>'historyreason','header'=>'Hist Reason']),

            // 4000 — Incumbent History Listing
            $col(['reportid'=>4000,'columnorder'=>10, 'table'=>'incumbents',  'field'=>'empno',         'header'=>'Emp #',        'sortorder'=>1]),
            $col(['reportid'=>4000,'columnorder'=>20, 'table'=>'incumbents',  'field'=>'lname',         'header'=>'Last Name',    'sortorder'=>2]),
            $col(['reportid'=>4000,'columnorder'=>30, 'table'=>'incumbents',  'field'=>'fname',         'header'=>'First Name',   'sortorder'=>3]),
            $col(['reportid'=>4000,'columnorder'=>40, 'table'=>'hincumbents', 'field'=>'historystart',  'header'=>'Hist Start',   'sortorder'=>4, 'format'=>'DATE']),
            $col(['reportid'=>4000,'columnorder'=>50, 'table'=>'hincumbents', 'field'=>'historyend',    'header'=>'Hist End',     'format'=>'DATE']),
            $col(['reportid'=>4000,'columnorder'=>60, 'table'=>'hincumbents', 'field'=>'jobtitle',      'header'=>'Hist Job Title']),
            $col(['reportid'=>4000,'columnorder'=>70, 'table'=>'hincumbents', 'field'=>'annual',        'header'=>'Hist Annual',  'format'=>'R$,2']),
            $col(['reportid'=>4000,'columnorder'=>80, 'table'=>'hincumbents', 'field'=>'ann_cost',      'header'=>'Hist Ann Cost','format'=>'R$,2']),
            $col(['reportid'=>4000,'columnorder'=>90, 'table'=>'hincumbents', 'field'=>'level1',        'header'=>'Level 1']),
            $col(['reportid'=>4000,'columnorder'=>100,'table'=>'hincumbents', 'field'=>'historyreason', 'header'=>'Hist Reason']),
        ]);
    }

    // ---------------------------------------------------------------
    // REPORT QUERIES (filter parameters)
    // ---------------------------------------------------------------
    private function seedQueries(): void
    {
        $posFilters = [
            ['descr'=>'Position #',       'table'=>'positions','field'=>'posno',    'datatype'=>'STRING','options'=>''],
            ['descr'=>'Location',         'table'=>'positions','field'=>'level1',   'datatype'=>'STRING','options'=>''],
            ['descr'=>'Department',       'table'=>'positions','field'=>'level2',   'datatype'=>'STRING','options'=>''],
            ['descr'=>'Filled Status',    'table'=>'positions','field'=>'curstatus','datatype'=>'STRING','options'=>'FILLED; VACANT; PARTIALLY FILLED; OVERFILLED'],
            ['descr'=>'Exempt Status',    'table'=>'positions','field'=>'exempt',   'datatype'=>'STRING','options'=>'Y; N'],
            ['descr'=>'Start Date',       'table'=>'positions','field'=>'startdate','datatype'=>'DATE',  'options'=>''],
        ];

        $incFilters = [
            ['descr'=>'Employee #',       'table'=>'incumbents','field'=>'empno',   'datatype'=>'STRING','options'=>''],
            ['descr'=>'Last Name',        'table'=>'incumbents','field'=>'lname',   'datatype'=>'STRING','options'=>''],
            ['descr'=>'Location',         'table'=>'incumbents','field'=>'level1',  'datatype'=>'STRING','options'=>''],
            ['descr'=>'Department',       'table'=>'incumbents','field'=>'level2',  'datatype'=>'STRING','options'=>''],
            ['descr'=>'Hire Date',        'table'=>'incumbents','field'=>'lasthire','datatype'=>'DATE',  'options'=>''],
            ['descr'=>'Start Date',       'table'=>'incumbents','field'=>'posstart','datatype'=>'DATE',  'options'=>''],
        ];

        $rows = [];
        $sortBase = 10;

        foreach ([1000,1010,1020,1030,1050] as $rid) {
            $so = $sortBase;
            foreach ($posFilters as $f) {
                $rows[] = array_merge(['reportid'=>$rid,'active'=>'A','sortorder'=>$so], $f);
                $so += 10;
            }
        }

        foreach ([1040] as $rid) {
            $so = $sortBase;
            foreach ($posFilters as $f) {
                $rows[] = array_merge(['reportid'=>$rid,'active'=>'A','sortorder'=>$so], $f);
                $so += 10;
            }
        }

        foreach ([3000,3010,3020,3030] as $rid) {
            $so = $sortBase;
            foreach ($incFilters as $f) {
                $rows[] = array_merge(['reportid'=>$rid,'active'=>'A','sortorder'=>$so], $f);
                $so += 10;
            }
        }

        // 2000 — Position History
        $rows[] = ['reportid'=>2000,'active'=>'A','sortorder'=>10,'descr'=>'Level 1',        'table'=>'hpositions','field'=>'level1',       'datatype'=>'STRING','options'=>''];
        $rows[] = ['reportid'=>2000,'active'=>'A','sortorder'=>20,'descr'=>'Level 2',        'table'=>'hpositions','field'=>'level2',       'datatype'=>'STRING','options'=>''];
        $rows[] = ['reportid'=>2000,'active'=>'A','sortorder'=>30,'descr'=>'Position #',     'table'=>'positions', 'field'=>'posno',        'datatype'=>'STRING','options'=>''];
        $rows[] = ['reportid'=>2000,'active'=>'A','sortorder'=>40,'descr'=>'Hist Start Date','table'=>'hpositions','field'=>'historystart', 'datatype'=>'DATE',  'options'=>''];
        $rows[] = ['reportid'=>2000,'active'=>'A','sortorder'=>50,'descr'=>'Hist End Date',  'table'=>'hpositions','field'=>'historyend',   'datatype'=>'DATE',  'options'=>''];

        // 4000 — Incumbent History
        $rows[] = ['reportid'=>4000,'active'=>'A','sortorder'=>10,'descr'=>'Last Name',      'table'=>'incumbents',  'field'=>'lname',       'datatype'=>'STRING','options'=>''];
        $rows[] = ['reportid'=>4000,'active'=>'A','sortorder'=>20,'descr'=>'Level 1',        'table'=>'hincumbents', 'field'=>'level1',      'datatype'=>'STRING','options'=>''];
        $rows[] = ['reportid'=>4000,'active'=>'A','sortorder'=>30,'descr'=>'Level 2',        'table'=>'hincumbents', 'field'=>'level2',      'datatype'=>'STRING','options'=>''];
        $rows[] = ['reportid'=>4000,'active'=>'A','sortorder'=>40,'descr'=>'Hist Start Date','table'=>'hincumbents', 'field'=>'historystart','datatype'=>'DATE',  'options'=>''];
        $rows[] = ['reportid'=>4000,'active'=>'A','sortorder'=>50,'descr'=>'Hist End Date',  'table'=>'hincumbents', 'field'=>'historyend',  'datatype'=>'DATE',  'options'=>''];

        foreach ([5000,5010] as $rid) {
            $rows[] = ['reportid'=>$rid,'active'=>'A','sortorder'=>10,'descr'=>'Location','table'=>'positions','field'=>'level1','datatype'=>'STRING','options'=>''];
            $rows[] = ['reportid'=>$rid,'active'=>'A','sortorder'=>20,'descr'=>'Department','table'=>'positions','field'=>'level2','datatype'=>'STRING','options'=>''];
        }

        DB::table('reportqueries')->insert($rows);
    }

    private function tier1Ids(): array
    {
        return [1000,1010,1020,1030,1040,1050,2000,3000,3010,3020,3030,4000,5000,5010];
    }
}
