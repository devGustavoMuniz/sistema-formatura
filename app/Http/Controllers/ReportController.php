<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\iReportService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    private iReportService $reportService;

    public function __construct(iReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Exibe a página de relatórios e gera os dados se um tipo de relatório for solicitado.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'report_type' => 'sometimes|string|in:students_by_institution,photos_by_student',
        ]);

        $reportData = [];
        $reportType = $request->input('report_type');

        if ($reportType === 'students_by_institution') {
            $reportData = $this->reportService->generateStudentsByInstituteReport();
        } elseif ($reportType === 'photos_by_student') {
            $reportData = $this->reportService->generatePhotosByStudentReport();
        }

        return Inertia::render('Admin/Reports/Index', [
            'reportData' => $reportData,
            'filters' => $request->only(['report_type'])
        ]);
    }
}
