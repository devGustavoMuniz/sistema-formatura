<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\iInstituteService;
use App\Interfaces\Services\iReportService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    private iInstituteService $instituteService;
    private iReportService $reportService;

    public function __construct(iInstituteService $instituteService, iReportService $reportService)
    {
        $this->instituteService = $instituteService;
        $this->reportService = $reportService;
    }

    /**
     * Exibe a página de relatórios e gera os dados se os filtros forem fornecidos.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'report_type' => 'sometimes|string|in:students_by_institute',
            'institute_id' => 'required_if:report_type,students_by_institute|exists:institutes,id'
        ]);

        $reportData = [];
        if ($request->input('report_type') === 'students_by_institute') {
            $reportData = $this->reportService->generateStudentsByInstituteReport($request->input('institute_id'));
        }

        return Inertia::render('Admin/Reports/Index', [
            'institutes' => $this->instituteService->getAllInstitutes([]),
            'reportData' => $reportData,
            'filters' => $request->only(['report_type', 'institute_id'])
        ]);
    }
}
