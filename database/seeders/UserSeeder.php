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
            'age'       => 28,
        ]);
        $role = Role::where('name', 'secretary')->first();
        $user->assignRole($role);

        $user = User::create([
            'name' => [
                'en' => 'patient',
                'ar' => 'مريض',
            ],
            'email'     => 'paitent@gmail.com',
            'password'  => Hash::make('password'),
            'phone'     => '01278783888',
            'age'       => 22,
        ]);
        $role = Role::where('name', 'paitent')->first();
        $user->assignRole($role);
    }
}
