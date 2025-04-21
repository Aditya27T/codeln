<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Material;
use App\Models\Question;
use App\Models\UserProgress;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call individual seeders
        $this->call([
            UserSeeder::class,
            MaterialSeeder::class,
            QuestionSeeder::class,
            UserProgressSeeder::class,
        ]);
    }
}