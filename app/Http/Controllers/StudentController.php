<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\iInstituteService;
use App\Interfaces\Services\iStudentService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    private iStudentService $studentService;
    private iInstituteService $instituteService;

    public function __construct(iStudentService $studentService, iInstituteService $instituteService)
    {
        $this->studentService = $studentService;
        $this->instituteService = $instituteService;
    }

    /**
     * Exibe a lista paginada de alunos.
     */
    public function index(Request $request)
    {
        $filters = $request->only('search', 'institute_id');
        $students = $this->studentService->getPaginatedStudents($filters);

        $institutes = $this->instituteService->getAllInstitutesCollection([]);

        return Inertia::render('Admin/Students/Index', [
            'students' => $students,
            'institutes' => $institutes,
            'filters' => $filters,
        ]);
    }

    /**
     * Exibe o formulário de criação de aluno.
     */
    public function create()
    {
        // Chama o método que retorna a coleção completa para o dropdown
        $institutes = $this->instituteService->getAllInstitutesCollection([]);
        return Inertia::render('Admin/Students/Create', [
            'institutes' => $institutes
        ]);
    }

    public function store(Request $request)
    {

        $this->studentService->createStudentAndUser($request->all());

        return redirect()->route('admin.students.index')->with('success', 'Aluno criado com sucesso!');
    }

    public function show(int $id)
    {
        $student = $this->studentService->findStudentById($id);
        return Inertia::render('Admin/Students/Show', ['student' => $student]);
    }

    public function edit(int $id)
    {
        $student = $this->studentService->findStudentById($id);
        $institutes = $this->instituteService->getAllInstitutesCollection([]);
        return Inertia::render('Admin/Students/Edit', [
            'student' => $student,
            'institutes' => $institutes,
        ]);
    }

    /**
     * Atualiza os dados de um aluno específico.
     */
    public function update(Request $request, int $id)
    {

        $this->studentService->updateStudent($id, $request->all());
        return redirect()->route('admin.students.index')->with('success', 'Aluno atualizado com sucesso!');
    }

    /**
     * Remove um aluno e seu usuário associado.
     */
    public function destroy(int $id)
    {

        $this->studentService->deleteStudent($id);
        return redirect()->route('admin.students.index')->with('success', 'Aluno excluído com sucesso!');
    }
}
