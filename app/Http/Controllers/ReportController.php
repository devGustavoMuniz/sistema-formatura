<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\iInstituteService;
use Inertia\Inertia;

class ReportController extends Controller
{
    private iInstituteService $instituteService;

    public function __construct(iInstituteService $instituteService)
    {
        $this->instituteService = $instituteService;
    }

    /**
     * Exibe a página de relatórios.
     */
    public function index()
    {

        $institutes = $this->instituteService->getAllInstitutes([]);

        return Inertia::render('Admin/Reports/Index', [
            'institutes' => $institutes,
        ]);
    }
}
