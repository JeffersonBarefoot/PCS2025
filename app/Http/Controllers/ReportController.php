<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\HPosition;
use App\Models\Incumbent;
use App\Models\Report;
use App\Models\ReportQueries;
use App\Models\ReportColumns;
use Illuminate\Http\Response;
use Session;
use Auth;
use Illuminate\Support\Facades\Schema\columns;
use Illuminate\Support\Facades\DB;

// require("vendor/autoload.php");
//use Cartalyst\DataGrid\DataHandlers\CollectionHandler;
//use Cartalyst\DataGrid\Environment;

//use Illuminate\Http\Request;


// below are related to Nayjest Data Grid
use App\User;
use Grids;
use HTML;
use Illuminate\Support\Facades\Config;

//use Nayjest\Grids\Components\Base\RenderableRegistry;
//use Nayjest\Grids\Components\ColumnHeadersRow;
//use Nayjest\Grids\Components\ColumnsHider;
//use Nayjest\Grids\Components\CsvExport;
//use Nayjest\Grids\Components\ExcelExport;
//use Nayjest\Grids\Components\Filters\DateRangePicker;
//use Nayjest\Grids\Components\FiltersRow;
//use Nayjest\Grids\Components\HtmlTag;
//use Nayjest\Grids\Components\Laravel5\Pager;
//use Nayjest\Grids\Components\OneCellRow;
//use Nayjest\Grids\Components\RecordsPerPage;
//use Nayjest\Grids\Components\RenderFunc;
//use Nayjest\Grids\Components\ShowingRecords;
//use Nayjest\Grids\Components\TFoot;
//use Nayjest\Grids\Components\THead;
//use Nayjest\Grids\Components\TotalsRow;
//use Nayjest\Grids\DbalDataProvider;
//use Nayjest\Grids\EloquentDataProvider;
//use Nayjest\Grids\FieldConfig;
//use Nayjest\Grids\FilterConfig;
//use Nayjest\Grids\Grid;
//use Nayjest\Grids\GridConfig;

use koolreport\core\source\processes\Group;
use koolreport\core\source\processes\Sort;
use koolreport\core\source\processes\Limit;


//dump('test');


class ReportController extends Controller
{


    public function index2($var = null)
    {
        $test = new Item;

        dd($var);
        dd($test);

        Log::info($var);
        Log::info($test);

        var_dump($test);
        var_dump($var);
    }


    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('subscribed');

        // $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    //***************************************************
    //***************************************************
    //***************************************************
    //**   I N D E X
    //***************************************************
    //***************************************************
    //***************************************************
    public function index(Request $request)
    {
//        the requests below work ok...JLB 20190930
//        $url = $request->fullUrl();
//        $input = $request->all();

        // $company = $request->input('company');
        // $posno = $request->input('posno');
        // $descr = $request->input('descr');
//      dd($company);
//      dd($posno);
        // dump('ReportController.index');

        $positions = Position::all();
        //$positionsnavbar = Position::all();
//        $positionsnavbar = GetPositions('company','=','SAMPLE');
        $reports = Report::all();

        $company = $request->input('company');
        $posno = $request->input('posno');
        $descr = $request->input('descr');
        $reportsnavbar = Position::where('company', 'like', "%$company%")
            ->where('posno', 'like', "%$posno%")
            ->where('descr', 'like', "%$descr%")
            ->get();

//        return view("reports.index",
//          compact('reports'),
//          compact('reportsnavbar'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */

    //***************************************************
    //***************************************************
    //***************************************************
    //**   C R E A T E
    //**   This works together with STORE to add a new record
    //***************************************************
    //***************************************************
    //***************************************************
    public function create()
    {
        return view('positions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */

    //***************************************************
    //***************************************************
    //***************************************************
    //**   S T O R E
    //**   This works together with CREATE to add a new record
    //***************************************************
    //***************************************************
    //***************************************************
    public function store(Request $request)
    {
//      dump('positioncontroller.store');

        $request->validate([
            'company' => 'required',
            'posno' => 'required',
            'descr' => 'required'
        ]);

        $position = new Position([
            'company' => $request->get('company'),
            'posno' => $request->get('posno'),
            'descr' => $request->get('descr')
        ]);
        $position->save();
        return redirect('/positions')->with('success', 'Position saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */

    //****************************************************
    //***************************************************
    //***************************************************
    //**   S H O W
    //***************************************************
    //***************************************************
    //***************************************************

    // $id is the report ID...1, 2, 3, etc
    // $request contains the query results:  "beg|positions||company|||STRING||||" => "A"
    public function show($id, Request $request)
    {

//        dump("report show");
        dump($id);
        dump(request()->all());

        if (is_null($id)) {
            $id = 1;
        }

        $viewinchistid = $request->input('viewinchistid');
        $navbarcompany = $request->input('company');
        $begcompany = $request->input('beg|positions||company|||');
        $input = $request->all();
        $report = Report::find($id);
        $reportid = $report->reportid;
        // find the report type, i.e. POS, from $report.group1
        $reporttype = $report->group1;
        $reportsortid = $report->reportid;
        dump($reportid);
        // >>>> START >>>>>>>>>>>>>>>>>>>>>>>
        // include all queries for this reporttype (all standard POS or POSH or INC queries), and for this specific report
        $reportqueries = \DB::table('reportqueries')
            ->where('reportid', '=', $reportid)
            ->where('active', '=', "A")
            ->orderby("sortorder", "asc")
            ->get();
        dump($reportqueries);
        // >>>> END >>>>>>>>>>>>>>>>>>>>>>>

        // >>>> START >>>>>>>>>>>>>>>>>>>>>>>
        // extract all reports that are needed to poplate the left Navbar
        $availablereportsPOS = \DB::table('reports')
            ->where('active', '=', "A")
            ->where('group1', '=', "POS")
            ->orderby("group1", "asc")
            ->orderby("group2", "asc")
            ->orderby("sortorder", "asc")
            ->get();

        $availablereportsPOSH = \DB::table('reports')
            ->where('active', '=', "A")
            ->where('group1', '=', "POSH")
            ->orderby("group1", "asc")
            ->orderby("group2", "asc")
            ->orderby("sortorder", "asc")
            ->get();

        $availablereportsINC = \DB::table('reports')
            ->where('active', '=', "A")
            ->where('group1', '=', "INC")
            ->orderby("group1", "asc")
            ->orderby("group2", "asc")
            ->orderby("sortorder", "asc")
            ->get();

        $availablereportsINCH = \DB::table('reports')
            ->where('active', '=', "A")
            ->where('group1', '=', "INCH")
            ->orderby("group1", "asc")
            ->orderby("group2", "asc")
            ->orderby("sortorder", "asc")
            ->get();

        $availablereportsBUDG = \DB::table('reports')
            ->where('active', '=', "A")
            ->where('group1', '=', "BUDG")
            ->orderby("group1", "asc")
            ->orderby("group2", "asc")
            ->orderby("sortorder", "asc")
            ->get();

        $availablereportsVAC = \DB::table('reports')
            ->where('active', '=', "A")
            ->where('group1', '=', "VAC")
            ->orderby("group1", "asc")
            ->orderby("group2", "asc")
            ->orderby("sortorder", "asc")
            ->get();

        $availablereportsRECR = \DB::table('reports')
            ->where('active', '=', "A")
            ->where('group1', '=', "RECR")
            ->orderby("group1", "asc")
            ->orderby("group2", "asc")
            ->orderby("sortorder", "asc")
            ->get();
        // >>>> END >>>>>>>>>>>>>>>>>>>>>>>


        // >>>> START >>>>>>>>>>>>>>>>>>>>>>>
        // 2025 rework.  This code will replace Nayjest with Kool Report
        // the first section was my original hard coded report object
//        $positionsnavbar = position::where('company', 'like', "%SAMPLE%")
//            ->orderby("company")
//            ->orderby("descr")
//            ->get()
//            ->toArray();
        // JLB 20250504 - THE CODE ABOVE WORKED FINE, but rewriting below in an attempt to understand how to pass parameters to kool report
//        $reportdata = position::where('id','>',0)
//            ->select('company','posno','curstatus','descr','budgsal')
//            ->where('company','<>','ZTI')
//            ->orderby('curstatus')
//            ->orderby('descr')
//            ->get();
//            $reportdata = $reportdata->sortBy('descr');
        dump($input);
        $reportdata = BuildQuery($reportid, $reporttype, $input, $report);
//        $reportdata = $reportdata->select('positions.company','positions.posno','curstatus','descr','budgsal');

        // Start adding columns
        // Add columns to the Eloquent query builder ($reportdata)
        $availablereportcolumns = \DB::table('reportcolumns')
            ->where('reportid', '=', $reportid)
            ->orderby("columnorder", "asc")
            ->orderby("header", "asc")
            ->get();

        foreach ($availablereportcolumns as $repcols) {
            $colTable = $repcols->table;
            $colField = $repcols->field;
            $colHeader = $repcols->header;

            // Next line builds:  positions.curstatus as Status
            $colString = $colTable . "." . $colField . " as " . $colHeader;
            dump($colString);
            $reportdata = $reportdata->addSelect($colString);
        }
        // End adding columns

        // Add Queries / Filters
        DB::statement("
    CREATE TEMPORARY TABLE tempQueries (
        id INT,
        tablename VARCHAR(100),
        fieldname VARCHAR(100),
        BegValue VARCHAR(100),
        EndValue VARCHAR(100),
        DataType VARCHAR(100),
        whereClause VARCHAR(300)
    )
");

        $id = 0;

//clear out existing session variables that relate to report queries.
//need to do this, or else old variables hang around and cause problems when user moves to a new report
        foreach (Session::all() as $key => $obj):
            if (str_contains($key, "||||")) {
                sessionForgetOne($key);
            }
        endforeach;

        // iterate through the values in the $input array
        foreach ($input as $key => $value) {
            dump($key);
//            $value = Array->get($input, $key);

            // save the value out to a session variable so that we can pass the values back to the form when go to report.blade.show
            sessionSet($key, $value);

            // we have the key (beg/end, table, field) and the user's input value
            // first item in array is key = "_token."  Ignore this element
            // parse out data from $key and update tablename, fieldname, begvalue, endvalue
            if ($key <> "_token") {
                // parse out the key's contents
                // format is like:  beg|positions||company|||
                $break1 = strpos($key, "|");
                $break2 = strpos($key, "||");
                $break3 = strpos($key, "|||");
                $break4 = strpos($key, "||||");
                $begEnd = strtoupper(Substr($key, 0, $break1));
                $tableName = substr($key, $break1 + 1, $break2 - $break1 - 1);
                $fieldName = substr($key, $break2 + 2, $break3 - $break2 - 2);
                $datatype = substr($key, $break3 + 3, $break4 - $break3 - 3);
                $nullField = NULL;

                // if this is a BEG record, then add new record
                if ($begEnd == "BEG") {
                    $id = $id + 1;
                    DB::insert('insert into tempQueries (id, tablename, fieldname, BegValue, DataType) values (?, ?, ?, ?, ?)', [$id, $tableName, $fieldName, $value, $datatype]);
                }

                // if this is an END record then put value in record with corresponding BEG
                if ($begEnd == "END") {
                    DB::update('update tempQueries set EndValue = ? where tablename = ? and fieldname = ?', [$value, $tableName, $fieldName]);
                    //DB::update('update tempQueries set EndValue = ? where fieldname = $fieldName', [$value] );
                }
            }
        }

        $currentQueryList = \DB::table('tempQueries')
            ->get();

        dump($currentQueryList);

        foreach ($currentQueryList as $currentFilters) {
            $filTable = $currentFilters->tablename;
            $filField = $currentFilters->fieldname;
            $filBeg = $currentFilters->BegValue;
            $filEnd = $currentFilters->EndValue;
            $filType = $currentFilters->DataType;

            // Next line builds:  positions.curstatus as Status
            if (!is_null($filBeg) and !is_null($filEnd)) {
                $filString = "wherebetween(" . $filTable . "." . $filField . "[" . $filBeg . "," . $filEnd . "])";
//                $filTable . "." . $filField . " as " . $colHeader;
                dump($filString);
                $reportdata = $reportdata->whereBetween($filTable . '.' . $filField, [$filBeg, $filEnd]);
//            $reportdata = $reportdata->addSelect($colString);
            }

//            $reportdata = $reportdata->addFilter($filString);
//            $reportdata = $reportdata->whereBetween($filTable . '.' . $filField, [$filBeg, $filEnd]);
//            dump('just added a filter');

        }


        // End Queries / Filters

//        $reportdata = $reportdata->where('company', '<>', 'ZTI');
//        $reportdata = $reportdata->where('curstatus', '=', 'VACANT');

        $reportdata = $reportdata->orderby('descr', 'asc');
        $reportdata = $reportdata->orderby('curstatus', 'asc');

        $reportdata = $reportdata->get();
        $reportarray = $reportdata->toArray();


        // >>>> END >>>>>>>>>>>>>>>>>>>>>>>


//        $grid = "";
//        $gridSummary = "";
//
//        $query = BuildQuery($reportid, $reporttype, $input, $report);
//        $querySummary = "";

//$CSVData = $query->get()->toArray();
//sessionSet('CSVDataFromGrid',$CSVData);
//
//        $grid = BuildReport($reportid, $reporttype, $input, $report, $query);
//$gridSummary = BuildReportSummary($reportid,$reporttype,$input);
//        dump($grid);


        //****************************
        // R E T U R N   T O   reports.show
        return View('reports.show')
            // ->with(compact('dataGrid'))
            ->with(compact('reportarray'))
//            ->with(compact('gridSummary'))
//        // ->with(compact('text'))
            ->with(compact('report'))
            ->with(compact('reportqueries'))
//        ->with(compact('reportdata'))
            ->with(compact('availablereportsPOS'))
            ->with(compact('availablereportsPOSH'))
            ->with(compact('availablereportsINC'))
            ->with(compact('availablereportsINCH'))
            ->with(compact('availablereportsBUDG'))
            ->with(compact('availablereportsVAC'))
            ->with(compact('availablereportsRECR'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */

    //***************************************************
    //***************************************************
    //***************************************************
    //**   E D I T
    //**   this works together with UPDATE to edit a single record
    //***************************************************
    //***************************************************
    //***************************************************
    public function edit($id)
    {
        // dump('positioncontroller.edit');
        if (is_null($id)) {
            $id = 1;
        }

        $position = Position::find($id);

        return view('positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */

    //***************************************************
    //***************************************************
    //***************************************************
    //**   U P D A T E
    //**   this works together with EDIT to edit a single record
    //***************************************************
    //***************************************************
    //***************************************************
    public function update(Request $request, $id)
    {

        if (is_null($id)) {
            $id = 1;
        }

        // dump('positioncontroller.update');
        UpdatePosition($id, $request);

        return redirect('/positions')->with('success', 'Position updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */

    //***************************************************
    //***************************************************
    //***************************************************
    //**   D E S T R O Y
    //***************************************************
    //***************************************************
    //***************************************************
    public function destroy($id)
    {
        //    dump('positioncontroller.destroy');

        $position = Position::find($id);
        $position->delete();

        return redirect('/positions')->with('success', 'Position deleted!');
    }

    //***************************************************
    //***************************************************
    //***************************************************
    //**   dumpGridToCsv
    //***************************************************
    //***************************************************
    //***************************************************
    public function dumpGridToCsv()
    {

//     $fileCreated = fopen('../FileExports/TEAM00001/wxyzfile.' . getTimestamp() .  '.csv', 'w');
        // $fp = fopen('xxxfile.csv', 'w');

        $CSVData = sessionGet('CSVDataFromGrid');

//     foreach ($CSVData as $exportRecord) {
//       // dd($pos);
//         fputcsv($fileCreated, $exportRecord);
//     }
//     fclose($fileCreated);

        return redirect('/reports/2')->with('success', 'CSV Export File Created');

    }
}
