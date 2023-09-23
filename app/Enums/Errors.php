<?php

namespace App\Enums;

enum Errors
{
    case FIRST;

    public function position()
    {
        return match ($this) {
            $this::FIRST => 0,
        };
    }
}
