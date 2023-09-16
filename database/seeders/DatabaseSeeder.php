<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Event::insert([
            [
                'name' => 'Evento de programação backend java',
                'start_date' => now()->addDays(10)->format('Y-m-d'),
                'end_date' => now()->addDays(12)->format('Y-m-d'),
                'status' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Evento de programação backend php',
                'start_date' => now()->addDays(10)->format('Y-m-d'),
                'end_date' => now()->addDays(12)->format('Y-m-d'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Evento de programação frontend',
                'start_date' => now()->addDays(10)->format('Y-m-d'),
                'end_date' => now()->addDays(12)->format('Y-m-d'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Evento de programação frontend em reactjs',
                'start_date' => now()->addDays(10)->format('Y-m-d'),
                'end_date' => now()->addDays(12)->format('Y-m-d'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Evento de programação frontend em nextjs',
                'start_date' => now()->addDays(10)->format('Y-m-d'),
                'end_date' => now()->addDays(12)->format('Y-m-d'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        \App\Models\Event::factory()->count(5)->create();
    }
}
