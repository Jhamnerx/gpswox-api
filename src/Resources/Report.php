<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class Report
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get reports
     * Retrieves all reports.
     * 
     * @param array $filters Optional filters
     * @return array List of reports
     */
    public function getReports(array $filters = [])
    {
        return $this->client->request('GET', 'api/get_reports', ['query' => $filters]);
    }

    /**
     * Get report types
     * Retrieves available report types.
     * 
     * @param array $params Optional parameters
     * @return array Report types
     */
    public function getReportTypes(array $params = [])
    {
        return $this->client->request('GET', 'api/get_reports_types', ['query' => $params]);
    }

    /**
     * Get data to add report
     * Retrieves necessary data for creating a report.
     * 
     * @param array $params Optional parameters
     * @return array Report creation data
     */
    public function addReportData(array $params = [])
    {
        return $this->client->request('GET', 'api/add_report_data', ['query' => $params]);
    }

    /**
     * Create report
     * Creates a new report.
     * 
     * @param array $data Report data
     * @return array Created report response
     */
    public function addReport(array $data)
    {
        return $this->client->request('POST', 'api/add_report', ['json' => $data]);
    }

    /**
     * Edit report
     * Updates an existing report.
     * 
     * @param int $reportId Report ID
     * @param array $data Report data to update
     * @return array Updated report response
     */
    public function editReport(int $reportId, array $data)
    {
        $data['report_id'] = $reportId;
        return $this->client->request('POST', 'api/edit_report', ['json' => $data]);
    }

    /**
     * Generate report
     * Generates a report with specified parameters.
     * 
     * @param int $reportId Report ID
     * @param array $data Generation parameters (from, to, etc.)
     * @return array Generated report data
     */
    public function generateReport(int $reportId, array $data)
    {
        $data['report_id'] = $reportId;
        return $this->client->request('POST', 'api/generate_report', ['json' => $data]);
    }

    /**
     * Delete report
     * Deletes a report.
     * 
     * @param int $reportId Report ID
     * @return array Deletion response
     */
    public function destroyReport(int $reportId)
    {
        return $this->client->request('GET', 'api/destroy_report', ['query' => ['report_id' => $reportId]]);
    }
}
