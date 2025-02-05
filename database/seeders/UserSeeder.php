<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => [
                'en' => 'admin',
                'ar' => 'أدمن',
            ],
            'email'     => 'admin@admin.com',
            'password'  => Hash::make('password'),
            'phone'     => '01234567890',
            'status'    => 1,
            'age'       => 35,
        ]);
        $role = Role::where('name', 'admin')->first();
        $user->assignRole($role);

        $user = User::create([
            'name' => [
                'en' => 'secretary',
                'ar' => 'سكرتر',
            ],
            'email'     => 'secretary@gmail.com',
            'password'  => Hash::make('password'),
            'phone'     => '01278783884',
            'status'    => 1,
            'age'       => 28,
        ]);
        $role = Role::where('name', 'secretary')->first();
        $user->assignRole($role);

        $user = User::create([
            'name' => [
                'en' => 'patient1',
                'ar' => '1مريض',
            ],
            'email'     => 'patient@gmail.com',
            'password'  => Hash::make('password'),
            'phone'     => '01278783888',
            'status'    => 1,
            'age'       => 22,
        ]);
        $role = Role::where('name', 'patient')->first();
        $user->assignRole($role);

        $user = User::create([
            'name' => [
                'en' => 'patient2',
                'ar' => 'مريض2',
            ],
            'email'     => 'patient2@gmail.com',
            'password'  => Hash::make('password'),
            'phone'     => '01278783808',
            'status'    => 1,
            'age'       => 22,
        ]);
        $role = Role::where('name', 'patient')->first();
        $user->assignRole($role);
    }
}
