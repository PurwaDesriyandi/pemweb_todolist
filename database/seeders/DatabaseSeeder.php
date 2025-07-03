<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\RoleAndPermissionSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleAndPermissionSeeder::class);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password'=> Hash::make('admin')
        ]);
        $admin->assignRole('admin');

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password'=> Hash::make('12345')
        ]);
        $user->assignRole('user');
    }
}
