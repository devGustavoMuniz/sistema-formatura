<?php

namespace App\Strategies;

use App\Interfaces\iValidationStrategy;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PhotoValidationStrategy implements iValidationStrategy
{
    /**
     * Valida os dados para o upload de uma foto.
     *
     * @param array $data Os dados a serem validados.
     * @return bool
     * @throws ValidationException
     */
    public function validate(array $data): bool
    {
        $validator = Validator::make($data, [
            'student_id' => 'required|exists:students,id',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
}
