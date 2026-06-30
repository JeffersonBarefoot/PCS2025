<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Position;
use App\Models\ReportQueries;
use App\Models\ReportColumns;
use Illuminate\Support\Facades\Session;
use App\Services\ReportService; // Introduced dedicated service class
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    protected $reportService;

    /**
     * Construct and inject the necessary service.
     */
    public function __construct(ReportService $reportService)
    {
        $this->middleware('auth'); // Ensure user is authenticated
        $this->reportService = $reportService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the first report the authenticated user has access to
        $report = $this->reportService->getFirstAccessibleReport(Auth::id());

        if ($report) {
            // Redirect to the first accessible report if it exists
            return redirect()->route('reports.show', $report->id);
        }

        // If no reports exist or are accessible, show the reports index page
        return view('reports.index', ['reports' => []]);
    }

    /**
     * Show the specified report.
     */
    public function show($id, Request $request)
    {
        // Fetch the report, handle filters, and retrieve necessary data via the `ReportService`.
        $report = $this->reportService->getReportById($id);
        $filterData = $request->all();

        // Check report exists
        if (!$report) {
            abort(404, "Report not found");
        }

        // Fetch data for the report, including queries, navbars, and columns
        $reportData = $this->reportService->getReportData($report, $filterData);
        $navbarReports = $this->reportService->getNavbarReports();
        $columns = $this->reportService->getReportColumns($report);

        // Return to the view with the necessary data
        return view('reports.show', [
            'report'        => $report,
            'reportData'    => $reportData,
            'columns'       => $columns,
            'navbarReports' => $navbarReports,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('positions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input request
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'posno'   => 'required|string|max:255',
            'descr'   => 'required|string|max:255',
        ]);

        // Create the position
        $position = Position::create($validated);

        // Redirect with success message
        return redirect('/positions')->with('success', 'Position saved!');
    }

    /**
     * Edit the specified resource.
     */
    public function edit($id)
    {
        $position = Position::findOrFail($id);

        return view('positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $position = Position::findOrFail($id);

        // Validate and update position
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'posno'   => 'required|string|max:255',
            'descr'   => 'required|string|max:255',
        ]);

        $position->update($validated);

        return redirect('/positions')->with('success', 'Position updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $position = Position::findOrFail($id);
        $position->delete();

        return redirect('/positions')->with('success', 'Position deleted!');
    }

    /**
     * Dump grid data to CSV.
     * This uses session-stored grid data to export.
     */
    public function dumpGridToCsv()
    {
        $this->reportService->exportGridToCsv();

        return redirect()->route('reports.index')->with('success', 'CSV export file created successfully!');
    }
}
