<?php

namespace App\Interfaces\Services;

use Illuminate\Database\Eloquent\Collection;

interface iReportService
{
    /**
     * Gera um relatório de alunos por instituição.
     *
     * @param int $instituteId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function generateStudentsByInstituteReport(int $instituteId): Collection;
}
