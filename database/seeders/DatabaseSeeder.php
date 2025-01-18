<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RolesAndPermissionSeeder::class);
        $user = User::create([
            'name' => [
                'en' => 'Micheal Sameh',
                'ar' => 'ميشيل سامح',
            ],
            'email'     => 'micheal.s.samir@gmail.com',
            'password'  => Hash::make('123456'),
            'phone'     => '01278783887',
            'age'       => 23,
        ]);
        $role = Role::where('name', 'owner')->first();
        $user->assignRole($role);

        $user = User::create([
            'name' => [
                'en' => 'patient',
                'ar' => 'مريض',
            ],
            'email'     => 'paitent@gmail.com',
            'password'  => Hash::make('123456'),
            'phone'     => '01278783888',
            'age'       => 22,
        ]);
        $role = Role::where('name', 'paitent')->first();
        $user->assignRole($role);


    }
}
