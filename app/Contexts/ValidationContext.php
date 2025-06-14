<?php
namespace App\Contexts;

use App\Interfaces\iValidationStrategy;

class ValidationContext
{
    private iValidationStrategy $strategy;

    public function __construct(iValidationStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function validate(array $data): bool
    {
        return $this->strategy->validate($data);
    }
}
