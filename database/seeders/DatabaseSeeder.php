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

        // User::create([
        //     'name'      => 'Micheal Sameh',
        //     'email'     => 'micheal.sameh@gmail.com',
        //     'password'  => Hash::make('123456'),
        //     'phone'     => '01278783887'
        // ]);
        $this->call(RolesAndPermissionSeeder::class);
//         $role = Role::where('name', 'owner')->first();
// $user = User::find(1);
// $user->assignRole($role);


    }
}
