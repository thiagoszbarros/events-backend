<?php

namespace App\Shared\Dtos;

class ResultDto
{
    public function __construct(
        public string $data,
        public int $code
    ) {
    }
}
