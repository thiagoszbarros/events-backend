<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventSubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\EventsSubscribers::factory()
            ->count(50)
            ->create();
    }
}
