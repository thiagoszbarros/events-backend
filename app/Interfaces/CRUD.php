<?php

namespace App\Interfaces;

interface CRUD
{
    public function index($offset = null);
    public function show(string $id);
    public function store(object $event);
    public function update(string $id, object $event);
    public function delete(string $id);
}
