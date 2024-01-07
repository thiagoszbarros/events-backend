<?php

declare(strict_types=1);

namespace App\Validations;

abstract class Validation
{
    abstract public function rule(): \Closure;

    abstract public function message(): string;
}
