<?php

namespace App\Interfaces\Services;

use Illuminate\Database\Eloquent\Collection;

interface iReportService
{
    /**
     * Gera um relatório com o total de alunos por instituição.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function generateStudentsByInstituteReport(): Collection;

    /**
     * Gera um relatório com o total de fotos por aluno.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function generatePhotosByStudentReport(): Collection;
}
