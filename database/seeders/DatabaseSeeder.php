<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(25)->create();

        $role = Role::create([
            'name' => 'Superadmin',
        ]);

        User::create([
            'name' => 'Superadmin',
            'email' => "supereasyadmin@albarranaufala.com",
            'password' => Hash::make('password'),
            'role_id' => $role->id
        ]);
    }
}
