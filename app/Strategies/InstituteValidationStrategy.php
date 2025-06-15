<?php

namespace App\Strategies;

use App\Interfaces\iValidationStrategy;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InstituteValidationStrategy implements iValidationStrategy
{
    /**
     * Valida os dados para criar ou atualizar uma instituição.
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
            'cnpj' => 'required|string|unique:institutes,cnpj,' . $id . '|size:14',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
}
