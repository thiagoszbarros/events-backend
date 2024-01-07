<?php

declare(strict_types=1);

namespace App\Services;

use App\Validations\Validation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class Contract
{
    protected bool $isValid = true;

    private string $error = '';

    protected string $message = '';

    protected Collection|Model|null $data = null;

    protected function validate(Validation $validation): void
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

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function getMessage(): mixed
    {
        return $this->message;
    }
}
