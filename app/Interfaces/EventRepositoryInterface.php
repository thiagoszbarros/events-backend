<?php

namespace App\Interfaces;

interface EventRepositoryInterface
{
    public function index(): object;
    public function find(string $id): object|null;
    public function store(object $event): object|null;
    public function update(string $id, object $event): void;
    public function delete(string $id): void;
}
