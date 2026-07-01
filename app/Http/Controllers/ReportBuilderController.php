<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\ReportQueries;
use App\Models\ReportColumns;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ReportBuilderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $teamId  = Auth::user()->currentTeam->id;
        $isAdmin = Auth::user()->hasTeamRole(Auth::user()->currentTeam, 'admin')
                   || Auth::user()->ownsTeam(Auth::user()->currentTeam);

        $firstReport = Report::accessibleBy($teamId, Auth::id(), $isAdmin)
            ->orderBy('sortorder')
            ->first();

        if ($firstReport) {
            return redirect()->route('reports.show', $firstReport->id);
        }

        return view('reportbuilders.show', ['reports' => [], 'report' => null,
            'reportqueries' => collect(), 'reportarray' => [],
            'availablereportsPOS'  => collect(), 'availablereportsPOSH' => collect(),
            'availablereportsINC'  => collect(), 'availablereportsINCH' => collect(),
            'availablereportsBUDG' => collect(), 'availablereportsVAC'  => collect(),
            'availablereportsRECR' => collect(),
        ]);
    }

    public function show($id, Request $request)
    {
        if (is_null($id)) {
            $id = 1;
        }

        $input  = $request->all();
        $report = Report::find($id);

        if (!$report) {
            abort(404, 'Report not found');
        }

        $user    = Auth::user();
        $teamId  = $user->currentTeam->id;
        $isAdmin = $user->hasTeamRole($user->currentTeam, 'admin') || $user->ownsTeam($user->currentTeam);

        $reportid   = $report->reportid;
        $reporttype = $report->group1;

        $reportqueries = DB::table('reportqueries')
            ->where('reportid', $reportid)
            ->where('active', 'A')
            ->orderBy('sortorder')
            ->get();

        $navReports = fn(string $type) => Report::accessibleBy($teamId, $user->id, $isAdmin)
            ->where('group1', $type)->orderBy('sortorder')->get();

        $availablereportsPOS  = $navReports('POS');
        $availablereportsPOSH = $navReports('POSH');
        $availablereportsINC  = $navReports('INC');
        $availablereportsINCH = $navReports('INCH');
        $availablereportsBUDG = $navReports('BUDG');
        $availablereportsVAC  = $navReports('VAC');
        $availablereportsRECR = $navReports('RECR');

        $reportdata = BuildQuery($reportid, $reporttype, $input, $report, $teamId);

        $availablereportcolumns = DB::table('reportcolumns')
            ->where('reportid', '=', $reportid)
            ->orderby('columnorder', 'asc')
            ->get();

        foreach ($availablereportcolumns as $repcols) {
            $colString = $repcols->table . '.' . $repcols->field . ' as ' . $repcols->header;
            $reportdata = $reportdata->addSelect($colString);
        }

        DB::statement('CREATE TEMPORARY TABLE tempQueries (
            id INT,
            tablename VARCHAR(100),
            fieldname VARCHAR(100),
            BegValue VARCHAR(100),
            EndValue VARCHAR(100),
            DataType VARCHAR(100),
            whereClause VARCHAR(300)
        )');

        foreach (Session::all() as $key => $obj) {
            if (str_contains($key, '||||')) {
                sessionForgetOne($key);
            }
        }

        $counter = 0;

        foreach ($input as $key => $value) {
            sessionSet($key, $value);

            if ($key !== '_token') {
                $break1 = strpos($key, '|');
                $break2 = strpos($key, '||');
                $break3 = strpos($key, '|||');
                $break4 = strpos($key, '||||');
                $begEnd    = strtoupper(substr($key, 0, $break1));
                $tableName = substr($key, $break1 + 1, $break2 - $break1 - 1);
                $fieldName = substr($key, $break2 + 2, $break3 - $break2 - 2);
                $datatype  = substr($key, $break3 + 3, $break4 - $break3 - 3);

                if ($begEnd === 'BEG') {
                    $counter++;
                    DB::insert('insert into tempQueries (id, tablename, fieldname, BegValue, DataType) values (?, ?, ?, ?, ?)',
                        [$counter, $tableName, $fieldName, $value, $datatype]);
                }

                if ($begEnd === 'END') {
                    DB::update('update tempQueries set EndValue = ? where tablename = ? and fieldname = ?',
                        [$value, $tableName, $fieldName]);
                }
            }
        }

        $currentQueryList = DB::table('tempQueries')->get();

        foreach ($currentQueryList as $f) {
            $beg      = $f->BegValue ?? '';
            $end      = $f->EndValue ?? '';
            $datatype = strtoupper($f->DataType ?? 'STRING');
            $field    = $f->tablename . '.' . $f->fieldname;

            if ($beg === '') continue; // nothing to filter on

            if ($end !== '') {
                $reportdata = $reportdata->whereBetween($field, [$beg, $end]);
            } elseif ($datatype === 'STRING') {
                $reportdata = $reportdata->where($field, '=', $beg);
            } else {
                // DATE or DECIMAL with no upper bound: match on or after/at-least
                $reportdata = $reportdata->where($field, '>=', $beg);
            }
        }

        // Sorting — user-clicked column wins; otherwise use reportcolumns.sortorder
        $currentSort = $input['sort'] ?? '';
        $currentDir  = in_array($input['dir'] ?? '', ['asc', 'desc']) ? $input['dir'] : 'asc';

        $colSortMap = [];
        foreach ($availablereportcolumns as $rc) {
            $colSortMap[$rc->header] = $rc->table . '.' . $rc->field;
        }

        if ($currentSort && isset($colSortMap[$currentSort])) {
            $reportdata = $reportdata->orderBy($colSortMap[$currentSort], $currentDir);
        } else {
            foreach ($availablereportcolumns->where('sortorder', '>', 0)->sortBy('sortorder') as $s) {
                $reportdata = $reportdata->orderBy($s->table . '.' . $s->field, 'asc');
            }
        }

        $reportarray = $reportdata->get()->toArray();

        return view('reportbuilders.show',
            compact('reportarray', 'report', 'reportqueries', 'availablereportcolumns',
                'currentSort', 'currentDir',
                'availablereportsPOS', 'availablereportsPOSH',
                'availablereportsINC', 'availablereportsINCH',
                'availablereportsBUDG', 'availablereportsVAC',
                'availablereportsRECR'));
    }

    // ── CSV Export ────────────────────────────────────────────────────────────

    public function exportCsv($id, Request $request)
    {
        $report = Report::find($id);
        if (!$report) abort(404);

        $user   = Auth::user();
        $teamId = $user->currentTeam->id;
        $input  = $request->all();

        $reportdata = BuildQuery($report->reportid, $report->group1, $input, $report, $teamId);

        $columns = DB::table('reportcolumns')
            ->where('reportid', $report->reportid)
            ->orderBy('columnorder')
            ->get();

        foreach ($columns as $col) {
            $reportdata = $reportdata->addSelect($col->table . '.' . $col->field . ' as ' . $col->header);
        }

        // Parse filters directly from request params (no temp table needed)
        $filters = [];
        foreach ($input as $key => $value) {
            if (strpos($key, '|') === false) continue;
            $b1 = strpos($key, '|');
            $b2 = strpos($key, '||');
            $b3 = strpos($key, '|||');
            $b4 = strpos($key, '||||');
            $be  = strtoupper(substr($key, 0, $b1));
            $tbl = substr($key, $b1 + 1, $b2 - $b1 - 1);
            $fld = substr($key, $b2 + 2, $b3 - $b2 - 2);
            $dt  = substr($key, $b3 + 3, $b4 - $b3 - 3);
            $fk  = $tbl . '.' . $fld;
            if ($be === 'BEG') $filters[$fk] = ['beg' => $value ?? '', 'end' => '', 'dt' => $dt];
            if ($be === 'END' && isset($filters[$fk])) $filters[$fk]['end'] = $value ?? '';
        }

        foreach ($filters as $field => $f) {
            if ($f['beg'] === '') continue;
            if ($f['end'] !== '') {
                $reportdata = $reportdata->whereBetween($field, [$f['beg'], $f['end']]);
            } elseif (strtoupper($f['dt']) === 'STRING') {
                $reportdata = $reportdata->where($field, '=', $f['beg']);
            } else {
                $reportdata = $reportdata->where($field, '>=', $f['beg']);
            }
        }

        // Sort
        $currentSort = $input['sort'] ?? '';
        $currentDir  = in_array($input['dir'] ?? '', ['asc', 'desc']) ? $input['dir'] : 'asc';
        $colSortMap  = $columns->mapWithKeys(fn($rc) => [$rc->header => $rc->table . '.' . $rc->field])->toArray();

        if ($currentSort && isset($colSortMap[$currentSort])) {
            $reportdata = $reportdata->orderBy($colSortMap[$currentSort], $currentDir);
        } else {
            foreach ($columns->where('sortorder', '>', 0)->sortBy('sortorder') as $s) {
                $reportdata = $reportdata->orderBy($s->table . '.' . $s->field, 'asc');
            }
        }

        // toBase() bypasses Eloquent model instantiation → plain stdClass results
        $rows     = $reportdata->toBase()->get();
        $filename = Str::slug($report->descr) . '-' . now()->format('Y-m-d') . '.csv';

        // Build CSV in memory to avoid output-buffering issues with streamDownload
        $buf = fopen('php://memory', 'r+');
        fputcsv($buf, $columns->pluck('header')->toArray());
        foreach ($rows as $row) {
            fputcsv($buf, array_values((array) $row));
        }
        rewind($buf);
        $csv = stream_get_contents($buf);
        fclose($buf);

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // ── Report Builder ────────────────────────────────────────────────────────

    public function copy($id)
    {
        $source = Report::find($id);
        if (!$source) abort(404);

        $user   = Auth::user();
        $teamId = $user->currentTeam->id;

        $newId = DB::table('reports')->insertGetId([
            'reportid'   => 0,
            'teamid'     => $teamId,
            'userid'     => $user->id,
            'active'     => 'A',
            'private'    => 'N',
            'is_system'  => false,
            'group1'     => $source->group1,
            'group2'     => $source->group2,
            'sortorder'  => $source->sortorder,
            'descr'      => 'Copy of ' . $source->descr,
            'notes'      => $source->notes,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('reports')->where('id', $newId)->update(['reportid' => $newId]);

        // Copy columns
        foreach (DB::table('reportcolumns')->where('reportid', $source->reportid)->get() as $col) {
            $arr = (array) $col;
            unset($arr['id'], $arr['created_at'], $arr['updated_at']);
            $arr['reportid'] = $newId;
            DB::table('reportcolumns')->insert($arr);
        }

        // Copy filter queries
        foreach (DB::table('reportqueries')->where('reportid', $source->reportid)->get() as $q) {
            $arr = (array) $q;
            unset($arr['id'], $arr['created_at'], $arr['updated_at']);
            $arr['reportid'] = $newId;
            DB::table('reportqueries')->insert($arr);
        }

        return redirect()->route('reports.edit', $newId)
            ->with('success', 'Report copied — customize it below, then run it.');
    }

    public function edit($id)
    {
        $report = Report::find($id);
        if (!$report) abort(404);

        $user    = Auth::user();
        $isAdmin = $user->hasTeamRole($user->currentTeam, 'admin') || $user->ownsTeam($user->currentTeam);

        if ($report->is_system || ($report->userid !== $user->id && !$isAdmin)) {
            abort(403, 'You may only edit reports you created.');
        }

        $columns = DB::table('reportcolumns')
            ->where('reportid', $report->reportid)
            ->orderBy('columnorder')
            ->get();

        $existingKeys = $columns->map(fn($c) => $c->table . '.' . $c->field)->toArray();

        $availableColumns = array_values(array_filter(
            self::columnCatalog($report->group1),
            fn($c) => !in_array($c[0] . '.' . $c[1], $existingKeys)
        ));

        return view('reportbuilders.edit', compact('report', 'columns', 'availableColumns'));
    }

    public function update($id, Request $request)
    {
        $report = Report::find($id);
        if (!$report) abort(404);

        $user    = Auth::user();
        $isAdmin = $user->hasTeamRole($user->currentTeam, 'admin') || $user->ownsTeam($user->currentTeam);

        if ($report->is_system || ($report->userid !== $user->id && !$isAdmin)) {
            abort(403);
        }

        $report->update([
            'descr'   => $request->input('descr'),
            'notes'   => $request->input('notes', ''),
            'private' => $request->input('private', 'N'),
        ]);

        foreach ($request->input('columns', []) as $colId => $colData) {
            DB::table('reportcolumns')
                ->where('id', $colId)
                ->where('reportid', $report->reportid)
                ->update([
                    'columnorder' => (int) ($colData['columnorder'] ?? 10),
                    'header'      => $colData['header'] ?? '',
                    'hidden'      => isset($colData['hidden']) ? 'Y' : 'N',
                    'sortorder'   => (int) ($colData['sortorder'] ?? 0),
                    'grouporder'  => (int) ($colData['grouporder'] ?? 0),
                    'subtotal'    => isset($colData['subtotal']) ? 'Y' : 'N',
                    'total'       => isset($colData['total']) ? 'Y' : 'N',
                ]);
        }

        // Add newly selected columns
        $addColumns = $request->input('add_columns', []);
        if (!empty($addColumns)) {
            $maxOrder = DB::table('reportcolumns')->where('reportid', $report->reportid)->max('columnorder') ?? 0;
            $nextOrder = $maxOrder + 10;
            $catalog   = collect(self::columnCatalog($report->group1));

            foreach ($addColumns as $colKey) {
                [$tbl, $fld] = array_pad(explode('.', $colKey, 2), 2, '');
                $match = $catalog->first(fn($c) => $c[0] === $tbl && $c[1] === $fld);
                DB::table('reportcolumns')->insert([
                    'reportid'    => $report->reportid,
                    'columnorder' => $nextOrder,
                    'table'       => $tbl,
                    'field'       => $fld,
                    'header'      => $match ? $match[2] : $fld,
                    'format'      => $match ? $match[3] : '',
                    'sortable'    => 'Y',
                    'sortorder'   => 0,
                    'grouporder'  => 0,
                    'subtotal'    => 'N',
                    'total'       => 'N',
                    'count'       => 'N',
                    'hidden'      => 'N',
                ]);
                $nextOrder += 10;
            }
        }

        return redirect()->route('reports.edit', $report->id)
            ->with('success', 'Report saved.');
    }

    // ── Column Catalog ────────────────────────────────────────────────────────
    // Returns every [table, field, header, format] tuple valid for a given group1.

    private static function columnCatalog(string $group1): array
    {
        $pos = [
            ['positions','posno',        'Pos #',            ''],
            ['positions','descr',        'Position',         ''],
            ['positions','active',       'Active',           ''],
            ['positions','curstatus',    'Status',           ''],
            ['positions','level1',       'Level 1',          ''],
            ['positions','level2',       'Level 2',          ''],
            ['positions','level3',       'Level 3',          ''],
            ['positions','level4',       'Level 4',          ''],
            ['positions','level5',       'Level 5',          ''],
            ['positions','group1',       'Group 1',          ''],
            ['positions','group2',       'Group 2',          ''],
            ['positions','group3',       'Group 3',          ''],
            ['positions','company',      'Company',          ''],
            ['positions','budgsal',      'Budg Salary',      'R$,2'],
            ['positions','payrate',      'Pay Rate',         'R$,2'],
            ['positions','paytype',      'Pay Type',         ''],
            ['positions','payfreq',      'Pay Freq',         ''],
            ['positions','fulltimeequiv','FTE',              'R#,5'],
            ['positions','ftehours',     'FTE Hours',        'R#,3'],
            ['positions','ftefreq',      'FTE Freq',         ''],
            ['positions','annftehour',   'Ann FTE Hours',    'R#,3'],
            ['positions','exempt',       'Exempt',           ''],
            ['positions','funded',       'Funded',           ''],
            ['positions','eeoclass',     'EEO Class',        ''],
            ['positions','jobcode',      'Job Code',         ''],
            ['positions','jobdesc',      'Job Description',  ''],
            ['positions','salgrade',     'Salary Grade',     ''],
            ['positions','salupper',     'Salary Upper',     'R$,2'],
            ['positions','sallower',     'Salary Lower',     'R$,2'],
            ['positions','salfreq',      'Salary Freq',      ''],
            ['positions','reptoposno',   'Reports-To Pos#',  ''],
            ['positions','reptodesc',    'Reports-To',       ''],
            ['positions','reptocomp',    'Reports-To Co',    ''],
            ['positions','reptopos2',    'Reports-To Pos#2', ''],
            ['positions','reptodesc2',   'Reports-To 2',     ''],
            ['positions','reptocom2',    'Reports-To Co2',   ''],
            ['positions','supempno',     'Sup Emp#',         ''],
            ['positions','supname',      'Supervisor',       ''],
            ['positions','supcompany',   'Sup Company',      ''],
            ['positions','startdate',    'Start Date',       'DATE'],
            ['positions','enddate',      'End Date',         'DATE'],
            ['positions','avail_date',   'Avail Date',       'DATE'],
            ['positions','trans_date',   'Trans Date',       'DATE'],
            ['positions','lastactdate',  'Last Activity',    'DATE'],
            ['positions','last_fil',     'Last Filled',      'DATE'],
            ['positions','last_vac',     'Last Vacant',      'DATE'],
            ['positions','last_par',     'Last Partial',     'DATE'],
            ['positions','last_ove',     'Last Overfilled',  'DATE'],
            ['positions','vac_times',    'Vac Times',        'R#,0'],
            ['positions','vac_months',   'Vac Months',       'R#,2'],
            ['positions','reason',       'Reason',           ''],
            ['positions','multincumb',   'Multi Incumbent',  ''],
            ['positions','linktoabra',   'Link To ABRA',     ''],
            ['positions','userdef1',     'User Def 1',       ''],
            ['positions','userdef2',     'User Def 2',       ''],
            ['positions','userdef3',     'User Def 3',       ''],
            ['positions','userdef4',     'User Def 4',       ''],
            ['positions','userdef5',     'User Def 5',       ''],
            ['positions','userdef6',     'User Def 6',       ''],
        ];

        $hpos = [
            ['hpositions','historystart',  'Hist Start',         'DATE'],
            ['hpositions','historyend',    'Hist End',           'DATE'],
            ['hpositions','historyreason', 'Hist Reason',        ''],
            ['hpositions','posno',         'Hist Pos #',         ''],
            ['hpositions','descr',         'Hist Position',      ''],
            ['hpositions','curstatus',     'Hist Status',        ''],
            ['hpositions','level1',        'Hist Level 1',       ''],
            ['hpositions','level2',        'Hist Level 2',       ''],
            ['hpositions','level3',        'Hist Level 3',       ''],
            ['hpositions','level4',        'Hist Level 4',       ''],
            ['hpositions','level5',        'Hist Level 5',       ''],
            ['hpositions','budgsal',       'Hist Budg Salary',   'R$,2'],
            ['hpositions','payrate',       'Hist Pay Rate',      'R$,2'],
            ['hpositions','fulltimeequiv', 'Hist FTE',           'R#,5'],
            ['hpositions','exempt',        'Hist Exempt',        ''],
            ['hpositions','funded',        'Hist Funded',        ''],
            ['hpositions','eeoclass',      'Hist EEO Class',     ''],
            ['hpositions','jobcode',       'Hist Job Code',      ''],
            ['hpositions','salgrade',      'Hist Sal Grade',     ''],
            ['hpositions','salupper',      'Hist Sal Upper',     'R$,2'],
            ['hpositions','sallower',      'Hist Sal Lower',     'R$,2'],
            ['hpositions','reptoposno',    'Hist Rpts-To Pos#',  ''],
            ['hpositions','reptodesc',     'Hist Reports-To',    ''],
            ['hpositions','startdate',     'Hist Start Date',    'DATE'],
            ['hpositions','enddate',       'Hist End Date',      'DATE'],
            ['hpositions','trans_date',    'Hist Trans Date',    'DATE'],
            ['hpositions','reason',        'Hist Reason Code',   ''],
            ['hpositions','userdef1',      'Hist User Def 1',    ''],
            ['hpositions','userdef2',      'Hist User Def 2',    ''],
            ['hpositions','userdef3',      'Hist User Def 3',    ''],
            ['hpositions','userdef4',      'Hist User Def 4',    ''],
            ['hpositions','userdef5',      'Hist User Def 5',    ''],
            ['hpositions','userdef6',      'Hist User Def 6',    ''],
        ];

        $inc = [
            ['incumbents','empno',        'Emp #',         ''],
            ['incumbents','lname',        'Last Name',     ''],
            ['incumbents','fname',        'First Name',    ''],
            ['incumbents','mi',           'MI',            ''],
            ['incumbents','jobtitle',     'Job Title',     ''],
            ['incumbents','jobcode',      'Job Code',      ''],
            ['incumbents','company',      'Company',       ''],
            ['incumbents','posno',        'Pos # (inc)',   ''],
            ['incumbents','annual',       'Annual Salary', 'R$,2'],
            ['incumbents','salary',       'Salary',        'R$,2'],
            ['incumbents','unitrate',     'Pay Rate',      'R$,2'],
            ['incumbents','normunit',     'Norm Units',    'R#,3'],
            ['incumbents','payfreq',      'Pay Freq',      ''],
            ['incumbents','ann_cost',     'Ann Cost',      'R$,2'],
            ['incumbents','posstart',     'Pos Start',     'DATE'],
            ['incumbents','posstop',      'Pos Stop',      'DATE'],
            ['incumbents','fulltimeequiv','FTE',           'R#,5'],
            ['incumbents','active',       'Active',        ''],
            ['incumbents','lsalary',      'Last Salary',   'R$,2'],
            ['incumbents','nextpay',      'Next Pay',      'DATE'],
            ['incumbents','nextincr',     'Next Incr',     'R#,3'],
            ['incumbents','lasthire',     'Last Hire',     'DATE'],
            ['incumbents','active_pos',   'Pos Active',    ''],
            ['incumbents','trans_date',   'Trans Date',    'DATE'],
            ['incumbents','reason',       'Reason',        ''],
            ['incumbents','lastact',      'Last Activity', 'DATE'],
            ['incumbents','hrmsreas',     'HRMS Reason',   ''],
            ['incumbents','hrmsdate',     'HRMS Date',     'DATE'],
            ['incumbents','race',         'Race',          ''],
            ['incumbents','sex',          'Sex',           ''],
            ['incumbents','education',    'Education',     ''],
            ['incumbents','level1',       'Level 1',       ''],
            ['incumbents','level2',       'Level 2',       ''],
            ['incumbents','level3',       'Level 3',       ''],
            ['incumbents','level4',       'Level 4',       ''],
            ['incumbents','level5',       'Level 5',       ''],
            ['incumbents','userdef1',     'User Def 1',    ''],
            ['incumbents','userdef2',     'User Def 2',    ''],
            ['incumbents','userdef3',     'User Def 3',    ''],
            ['incumbents','userdef4',     'User Def 4',    ''],
            ['incumbents','userdef5',     'User Def 5',    ''],
            ['incumbents','userdef6',     'User Def 6',    ''],
        ];

        $hinc = [
            ['hincumbents','historystart',  'Hist Start',       'DATE'],
            ['hincumbents','historyend',    'Hist End',         'DATE'],
            ['hincumbents','historyreason', 'Hist Reason',      ''],
            ['hincumbents','empno',         'Hist Emp #',       ''],
            ['hincumbents','lname',         'Hist Last Name',   ''],
            ['hincumbents','fname',         'Hist First Name',  ''],
            ['hincumbents','jobtitle',      'Hist Job Title',   ''],
            ['hincumbents','jobcode',       'Hist Job Code',    ''],
            ['hincumbents','annual',        'Hist Annual Sal',  'R$,2'],
            ['hincumbents','salary',        'Hist Salary',      'R$,2'],
            ['hincumbents','unitrate',      'Hist Pay Rate',    'R$,2'],
            ['hincumbents','payfreq',       'Hist Pay Freq',    ''],
            ['hincumbents','ann_cost',      'Hist Ann Cost',    'R$,2'],
            ['hincumbents','posstart',      'Hist Pos Start',   'DATE'],
            ['hincumbents','posstop',       'Hist Pos Stop',    'DATE'],
            ['hincumbents','fulltimeequiv', 'Hist FTE',         'R#,5'],
            ['hincumbents','trans_date',    'Hist Trans Date',  'DATE'],
            ['hincumbents','reason',        'Hist Reason Code', ''],
            ['hincumbents','lasthire',      'Hist Last Hire',   'DATE'],
            ['hincumbents','level1',        'Hist Level 1',     ''],
            ['hincumbents','level2',        'Hist Level 2',     ''],
            ['hincumbents','level3',        'Hist Level 3',     ''],
            ['hincumbents','level4',        'Hist Level 4',     ''],
            ['hincumbents','level5',        'Hist Level 5',     ''],
            ['hincumbents','race',          'Hist Race',        ''],
            ['hincumbents','sex',           'Hist Sex',         ''],
            ['hincumbents','education',     'Hist Education',   ''],
            ['hincumbents','userdef1',      'Hist User Def 1',  ''],
            ['hincumbents','userdef2',      'Hist User Def 2',  ''],
            ['hincumbents','userdef3',      'Hist User Def 3',  ''],
            ['hincumbents','userdef4',      'Hist User Def 4',  ''],
            ['hincumbents','userdef5',      'Hist User Def 5',  ''],
            ['hincumbents','userdef6',      'Hist User Def 6',  ''],
        ];

        // Position columns available when joining through incumbents
        $posForInc = [
            ['positions','posno',        'Pos #',          ''],
            ['positions','descr',        'Position',       ''],
            ['positions','curstatus',    'Pos Status',     ''],
            ['positions','level1',       'Pos Level 1',    ''],
            ['positions','level2',       'Pos Level 2',    ''],
            ['positions','level3',       'Pos Level 3',    ''],
            ['positions','level4',       'Pos Level 4',    ''],
            ['positions','level5',       'Pos Level 5',    ''],
            ['positions','group1',       'Pos Group 1',    ''],
            ['positions','group2',       'Pos Group 2',    ''],
            ['positions','budgsal',      'Budg Salary',    'R$,2'],
            ['positions','fulltimeequiv','Budg FTE',       'R#,5'],
            ['positions','payrate',      'Budg Pay Rate',  'R$,2'],
            ['positions','exempt',       'Exempt',         ''],
            ['positions','eeoclass',     'EEO Class',      ''],
            ['positions','salgrade',     'Sal Grade',      ''],
            ['positions','salupper',     'Sal Upper',      'R$,2'],
            ['positions','sallower',     'Sal Lower',      'R$,2'],
            ['positions','reptodesc',    'Reports-To',     ''],
            ['positions','reptoposno',   'Rpts-To Pos#',   ''],
            ['positions','startdate',    'Pos Start Date', 'DATE'],
            ['positions','funded',       'Funded',         ''],
            ['positions','jobcode',      'Pos Job Code',   ''],
        ];

        return match($group1) {
            'POS'  => $pos,
            'POSH' => array_merge($pos, $hpos),
            'INC'  => array_merge($inc, $posForInc),
            'INCH' => array_merge($inc, $hinc, $posForInc),
            'VAC'  => $pos,
            default => $pos,
        };
    }

    public function destroy($id)
    {
        $report = Report::find($id);
        if (!$report) abort(404);

        $user    = Auth::user();
        $isAdmin = $user->hasTeamRole($user->currentTeam, 'admin') || $user->ownsTeam($user->currentTeam);

        if ($report->is_system || ($report->userid !== $user->id && !$isAdmin)) {
            abort(403);
        }

        DB::table('reportcolumns')->where('reportid', $report->reportid)->delete();
        DB::table('reportqueries')->where('reportid', $report->reportid)->delete();
        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Report deleted.');
    }

    public function dumpGridToCsv()
    {
        $CSVData = sessionGet('CSVDataFromGrid');

        return redirect('/reports')->with('success', 'CSV Export File Created');
    }
}
