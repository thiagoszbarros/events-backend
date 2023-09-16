<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Subscriber::factory()
            ->count(5)
            ->create();
    }
}
