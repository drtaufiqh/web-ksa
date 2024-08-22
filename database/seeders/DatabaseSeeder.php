<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Menghasilkan 10 data dummy users
        User::factory()->count(10)->create();

        // Membuat user dengan email dan password spesifik
        User::create([
            'name' => 'John Doe',
            'email' => 'abcd@def.co',
            'password' => Hash::make('abcde'),
        ]);
    }
}
