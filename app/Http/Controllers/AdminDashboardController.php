<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\iInstituteService;
use App\Interfaces\Services\iStudentService;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    private iInstituteService $instituteService;
    private iStudentService $studentService;

    public function __construct(iInstituteService $instituteService, iStudentService $studentService)
    {
        $this->instituteService = $instituteService;
        $this->studentService = $studentService;
    }

    /**
     * Exibe o dashboard administrativo com estatísticas.
     */
    public function index()
    {
        $totalInstitutes = $this->instituteService->getAllInstitutes([])->count();
        $totalStudents = $this->studentService->getAllStudents([])->count();

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'institutes' => $totalInstitutes,
                'students' => $totalStudents,
            ],
        ]);
    }
}
