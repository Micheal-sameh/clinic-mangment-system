<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users_list = Permission::firstOrCreate(['name' => 'users_list']);
        $users_create = Permission::firstOrCreate(['name' => 'users_create']);
        $users_show = Permission::firstOrCreate(['name' => 'users_show']);
        $users_delete = Permission::firstOrCreate(['name' => 'users_delete']);
        $users_reset_pass = Permission::firstOrCreate(['name' => 'users_reset_pass']);


        $owner = Role::firstOrCreate(['name' => 'super_admin']);
        $owner->givePermissionTo([
            $users_list,
            $users_create,
            $users_show,
            $users_delete,
            $users_reset_pass,
        ]);


    }
}
