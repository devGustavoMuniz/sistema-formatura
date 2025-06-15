<?php

namespace App\Services;

use App\Contexts\ValidationContext;
use App\Enums\UserType;
use App\Interfaces\DAOs\iStudentDAO;
use App\Interfaces\Services\iStudentService;
use App\Models\Student;
use App\Models\User;
use App\Observers\LogObserver;
use App\Strategies\StudentValidationStrategy;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentService implements iStudentService
{
    private iStudentDAO $dao;

    public function __construct(iStudentDAO $dao)
    {
        $this->dao = $dao;
    }

    public function getPaginatedStudents(array $filters): LengthAwarePaginator
    {
        return $this->dao->getPaginated($filters);
    }

    public function getAllStudentsCollection(array $filters): Collection
    {
        return $this->dao->getCollection($filters);
    }

    public function findStudentById(int $id): ?Student
    {
        return $this->dao->findById($id);
    }

    public function createStudentAndUser(array $data): Student
    {



        return DB::transaction(function () use ($data) {

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'type' => UserType::ALUNO,
            ]);

            $studentData = [
                'name' => $data['name'],
                'ra' => $data['ra'],
                'institute_id' => $data['institute_id'],
                'user_id' => $user->id,
                'password' => $data['password'],
                'password_confirmation' => $data['password_confirmation'],
            ];

            $validationContext = new ValidationContext(new StudentValidationStrategy());
            $validationContext->validate($studentData);

            $student = $this->dao->create($studentData);

            $student->addObserver(new LogObserver());
            $student->notify();

            return $student;
        });
    }

    public function updateStudent(int $id, array $data): bool
    {
        $data['id'] = $id;
        $validationContext = new ValidationContext(new StudentValidationStrategy());
        $validationContext->validate($data);

        return DB::transaction(function () use ($id, $data) {
            $student = $this->dao->findById($id);
            if (!$student) {
                return false;
            }


            $studentUpdated = $this->dao->update($id, $data);

            $userUpdated = true;
            $userData = array_filter([
                'name' => $data['name'] ?? null,
                'email' => $data['email'] ?? null,
            ]);
            if (!empty($userData)) {
                $userUpdated = $student->user->update($userData);
            }

            return $studentUpdated && $userUpdated;
        });
    }

    public function deleteStudent(int $id): bool
    {
        $student = $this->dao->findById($id);

        if ($student) {

            return DB::transaction(function () use ($student) {
                $user = $student->user;
                $student->delete();
                return $user->delete();
            });
        }

        return false;
    }
}
