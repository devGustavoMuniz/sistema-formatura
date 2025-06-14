<?php
namespace App\Interfaces;

interface iValidationStrategy {
    public function validate(array $data): bool;
}
