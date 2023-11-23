<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UsersRole;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $cre = UsersRole::create([
            'roles' => 'Superadmin',
        ])->id;
        
        User::create([
            'name' => 'Redvelvetz',
            'email' => 'redvelvetz@example.com',
            'role_id'=>$cre,
            'password' => Hash::make('password123'),
        ]);
    }
}
