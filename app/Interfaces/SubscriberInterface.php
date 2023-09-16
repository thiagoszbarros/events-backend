<?php

namespace App\Interfaces;

interface SubscriberInterface
{
    public function index($offset = null);
    public function store($subscriber);
}
