<?php

namespace App\Shared\Dtos;

class ResultDto
{
    public function __construct(
        public mixed $data,
        public int $code
    ) {
    }
}
