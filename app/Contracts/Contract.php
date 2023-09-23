<?php

namespace App\Contracts;

use App\Interfaces\Validate;

abstract class Contract implements Validate
{
    public function __construct(
        public bool $isValid = true,
        public array $errors = [],
    ) {
    }
}
