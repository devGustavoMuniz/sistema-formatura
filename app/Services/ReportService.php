<?php

namespace App\Services;

use App\Interfaces\DAOs\iInstituteDAO;
use App\Interfaces\DAOs\iStudentDAO;
use App\Interfaces\Services\iReportService;
use Illuminate\Database\Eloquent\Collection;

class ReportService implements iReportService
{
    private iInstituteDAO $instituteDAO;
    private iStudentDAO $studentDAO;

    public function __construct(iInstituteDAO $instituteDAO, iStudentDAO $studentDAO)
    {
        $this->instituteDAO = $instituteDAO;
        $this->studentDAO = $studentDAO;
    }

    public function generateStudentsByInstituteReport(): Collection
    {
        return $this->instituteDAO->getAllWithStudentCount();
    }

    public function generatePhotosByStudentReport(): Collection
    {
        return $this->studentDAO->getAllWithPhotoCount();
    }
}
