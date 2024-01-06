<?php

namespace App\Validations;

abstract class Validation
{
    abstract public function rule(): \Closure;
    abstract public function message(): string;
}
