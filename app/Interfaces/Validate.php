<?php

namespace App\Interfaces;

interface Validate
{
    public function validate(...$args): self;
}
