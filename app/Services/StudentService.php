<?php

namespace App\Services;

use App\Contexts\ValidationContext;
use App\Interfaces\DAOs\iStudentDAO;
use App\Interfaces\Services\iStudentService;
use App\Models\Student;
use App\Observers\LogObserver;
use App\Strategies\StudentValidationStrategy;
use Illuminate\Database\Eloquent\Collection;

class StudentService implements iStudentService
{
    private iStudentDAO $dao;

    public function __construct(iStudentDAO $dao)
    {
        $this->dao = $dao;
    }

    public function getAllStudents(array $filters): Collection
    {
        return $this->dao->getAll($filters);
    }

    public function findStudentById(int $id): ?Student
    {
        return $this->dao->findById($id);
    }

    public function createStudent(array $data): Student
    {

        $validationContext = new ValidationContext(new StudentValidationStrategy());
        $validationContext->validate($data);

        $student = $this->dao->create($data);


        $student->addObserver(new LogObserver());
        $student->notify();

        return $student;
    }

    public function updateStudent(int $id, array $data): bool
    {
        $data['id'] = $id;
        $validationContext = new ValidationContext(new StudentValidationStrategy());
        $validationContext->validate($data);

        return $this->dao->update($id, $data);
    }

    public function deleteStudent(int $id): bool
    {
        return $this->dao->delete($id);
    }
}
