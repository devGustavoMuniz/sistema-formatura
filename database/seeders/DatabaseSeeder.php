<?php

namespace Database\Seeders;
use App\Models\Institute;
use App\Models\Student;
use App\Enums\UserType;
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
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'type' => UserType::ADMIN,
        ]);


        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'type' => UserType::ALUNO,
        ]);

         $institutes = Institute::factory(25)->create();

        Student::factory(50)->create([
            'institute_id' => function () use ($institutes) {
                return $institutes->random()->id;
            }
        ]);
    }
}
