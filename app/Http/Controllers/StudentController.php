<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\iInstituteService;
use App\Enums\UserType;
use App\Models\User;
use App\Interfaces\Services\iStudentService;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
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

    public function index(Request $request)
    {
        $filters = $request->only('search', 'institute_id');
        $students = $this->studentService->getAllStudents($filters);
        
        $institutes = $this->instituteService->getAllInstitutesNoPagination([]);

        return Inertia::render('Admin/Students/Index', [
            'students' => $students,
            'filters' => $filters,
            'allInstitutes' => $institutes, 
        ]);
    }


    public function create()
    {
        $institutes = $this->instituteService->getAllInstitutesNoPagination([]);
        return Inertia::render('Admin/Students/Create', [
            'institutes' => $institutes
        ]);
    }

    public function store(Request $request)
    {
        // 1. Valide os dados necessários para o User e para o Student
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'ra' => 'required|string|unique:students,ra',
            'institute_id' => 'required|exists:institutes,id',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make('password'),
            'type' => UserType::ALUNO,
        ]);

        $studentData = [
            'name' => $validatedData['name'],
            'ra' => $validatedData['ra'],
            'institute_id' => $validatedData['institute_id'],
            'user_id' => $user->id, 
        ];

        $this->studentService->createStudent($studentData);

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
        $institutes = $this->instituteService->getAllInstitutesNoPagination([]);
        return Inertia::render('Admin/Students/Edit', [
            'student' => $student,
            'institutes' => $institutes,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $this->studentService->updateStudent($id, $request->all());
        return redirect()->route('admin.students.index')->with('success', 'Aluno atualizado com sucesso!');
    }

    public function destroy(int $id)
    {
        $this->studentService->deleteStudent($id);
        return redirect()->route('admin.students.index')->with('success', 'Aluno excluído com sucesso!');
    }
}
