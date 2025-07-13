<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
        ]);

        \App\Models\Property::factory(20)->create(
            [
                'user_id' => 1,
            ]
        );

        // Create demo chatbot
        \App\Models\Chatbot::create([
            'id' => 1,
            'user_id' => 1,
            'primary_color' => '#FF6B9D',
            'include_not_available_property' => true,
            'welcome_message' => 'Hi there 👋<br>Welcome to ElfSight!<br>How can I help you today?',
            'headline' => 'Virtual Assistant',
        ]);
    }
}
