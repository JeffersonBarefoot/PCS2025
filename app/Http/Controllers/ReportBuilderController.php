<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\ReportQueries;
use App\Models\ReportColumns;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReportBuilderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $firstReport = DB::table('reports')->where('active', 'A')->orderby('sortorder')->first();

        if ($firstReport) {
            return redirect()->route('reports.show', $firstReport->id);
        }

        return view('reports.index', ['reports' => []]);
    }

    public function show($id, Request $request)
    {
        if (is_null($id)) {
            $id = 1;
        }

        $input = $request->all();
        $report = Report::find($id);

        if (!$report) {
            abort(404, 'Report not found');
        }

        $reportid = $report->reportid;
        $reporttype = $report->group1;

        $reportqueries = DB::table('reportqueries')
            ->where('reportid', '=', $reportid)
            ->where('active', '=', 'A')
            ->orderby('sortorder', 'asc')
            ->get();

        $availablereportsPOS  = DB::table('reports')->where('active', 'A')->where('group1', 'POS')->orderby('sortorder')->get();
        $availablereportsPOSH = DB::table('reports')->where('active', 'A')->where('group1', 'POSH')->orderby('sortorder')->get();
        $availablereportsINC  = DB::table('reports')->where('active', 'A')->where('group1', 'INC')->orderby('sortorder')->get();
        $availablereportsINCH = DB::table('reports')->where('active', 'A')->where('group1', 'INCH')->orderby('sortorder')->get();
        $availablereportsBUDG = DB::table('reports')->where('active', 'A')->where('group1', 'BUDG')->orderby('sortorder')->get();
        $availablereportsVAC  = DB::table('reports')->where('active', 'A')->where('group1', 'VAC')->orderby('sortorder')->get();
        $availablereportsRECR = DB::table('reports')->where('active', 'A')->where('group1', 'RECR')->orderby('sortorder')->get();

        $reportdata = BuildQuery($reportid, $reporttype, $input, $report);

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

        foreach ($currentQueryList as $currentFilters) {
            if (!is_null($currentFilters->BegValue) && !is_null($currentFilters->EndValue)) {
                $reportdata = $reportdata->whereBetween(
                    $currentFilters->tablename . '.' . $currentFilters->fieldname,
                    [$currentFilters->BegValue, $currentFilters->EndValue]
                );
            }
        }

        $reportdata  = $reportdata->orderby('descr', 'asc')->orderby('curstatus', 'asc');
        $reportarray = $reportdata->get()->toArray();

        return view('reportbuilders.show',
            compact('reportarray', 'report', 'reportqueries',
                'availablereportsPOS', 'availablereportsPOSH',
                'availablereportsINC', 'availablereportsINCH',
                'availablereportsBUDG', 'availablereportsVAC',
                'availablereportsRECR'));
    }

    public function dumpGridToCsv()
    {
        $CSVData = sessionGet('CSVDataFromGrid');

        return redirect('/reports')->with('success', 'CSV Export File Created');
    }
}
