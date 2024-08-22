<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
