<?php

declare(strict_types=1);

namespace App\Shared\Dtos;

class ResultDto
{
    public function __construct(
        public mixed $data,
        public int $code
    ) {
    }
}
