<?php

namespace App\Services;

use App\Models\Report;
use App\Models\ReportQueries;
use App\Models\ReportColumns;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReportService
{
    /**
     * Get the first accessible report for a user.
     */
    public function getFirstAccessibleReport($userId)
    {
        return Report::where('user_id', $userId)->first();
    }

    /**
     * Get a report by its ID.
     */
    public function getReportById($id)
    {
        return Report::find($id);
    }

    /**
     * Fetch report data based on filters and report configuration.
     */
    public function getReportData($report, $filters)
    {
        $query = $this->buildReportQuery($report, $filters);
        return $query->get();
    }

    /**
     * Build the query for the report dynamically.
     */
    protected function buildReportQuery($report, $filters)
    {
        $query = DB::table($report->table_name);

        // Apply filters based on the columns
        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                $query->where($key, 'LIKE', "%{$value}%");
            }
        }

        return $query;
    }

    /**
     * Get navigation bar reports (e.g., side navigation items).
     */
    public function getNavbarReports()
    {
        return [
            'POS'  => Report::where('group1', 'POS')->get(),
            'POSH' => Report::where('group1', 'POSH')->get(),
            'INC'  => Report::where('group1', 'INC')->get(),
        ];
    }

    /**
     * Get the report columns dynamically.
     */
    public function getReportColumns($report)
    {
        return ReportColumns::where('report_id', $report->id)
            ->orderBy('columnorder', 'asc')
            ->get();
    }

    /**
     * Export the session-stored grid data to CSV.
     */
    public function exportGridToCsv()
    {
        $csvData = Session::get('CSVDataFromGrid');

        $fileName = storage_path('exports/report_' . time() . '.csv');
        $handle = fopen($fileName, 'w');

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);
    }
}