<?php

namespace App\Strategies;

use App\Interfaces\iValidationStrategy;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AdminValidationStrategy implements iValidationStrategy
{
    public function validate(array $data): bool
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return true;
    }
}
