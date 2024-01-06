<?php

namespace App\Services;

use App\Validations\Validation;

abstract class Contract
{
    public bool $isValid = true;

    public string $error = '';

    public function validate(Validation $validation)
    {
        $this->isValid &&
            ! $validation->rule()() &&
            $this->invalidate(error: $validation->message());
    }

    private function invalidate(string $error): void
    {
        $this->isValid = false;
        $this->error = $error;
    }
}
