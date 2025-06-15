<?php

namespace App\Strategies;

use App\Interfaces\iValidationStrategy;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StudentValidationStrategy implements iValidationStrategy
{
    /**
     * Valida os dados para criar ou atualizar um aluno.
     *
     * @param array $data Os dados a serem validados.
     * @return bool
     * @throws ValidationException
     */
    public function validate(array $data): bool
    {
        $id = $data['id'] ?? null;

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'ra' => 'required|string|unique:students,ra,' . $id,
            'institute_id' => 'required|exists:institutes,id',
            'user_id' => 'required|exists:users,id',
            'password' => ['required', 'string', 'min:8','confirmed'],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
}
