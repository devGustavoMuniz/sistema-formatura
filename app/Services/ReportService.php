<?php

namespace App\Services;

use App\Interfaces\DAOs\iStudentDAO;
use App\Interfaces\Services\iReportService;
use Illuminate\Database\Eloquent\Collection;

class ReportService implements iReportService
{
    private iStudentDAO $studentDAO;

    public function __construct(iStudentDAO $studentDAO)
    {
        $this->studentDAO = $studentDAO;
    }

    /**
     * Gera um relatório de alunos por instituição.
     *
     * @param int $instituteId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function generateStudentsByInstituteReport(int $instituteId): Collection
    {
        // Agora chama o método correto que garante o retorno de uma Collection
        return $this->studentDAO->getCollection(['institute_id' => $instituteId]);
    }
}
