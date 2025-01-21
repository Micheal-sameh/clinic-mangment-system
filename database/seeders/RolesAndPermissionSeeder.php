<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
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
        $users_edit = Permission::firstOrCreate(['name' => 'users_edit']);
        $users_show = Permission::firstOrCreate(['name' => 'users_show']);
        $users_delete = Permission::firstOrCreate(['name' => 'users_delete']);
        $users_reset_pass = Permission::firstOrCreate(['name' => 'users_reset_pass']);
        $users_profile = Permission::firstOrCreate(['name' => 'users_profile']);

        $procedures_list = Permission::firstOrCreate(['name' => 'procedures_list']);
        $procedures_create = Permission::firstOrCreate(['name' => 'procedures_create']);
        $procedures_edit = Permission::firstOrCreate(['name' => 'procedures_edit']);
        $procedures_show = Permission::firstOrCreate(['name' => 'procedures_show']);
        $procedures_delete = Permission::firstOrCreate(['name' => 'procedures_delete']);
        $procedures_update = Permission::firstOrCreate(['name' => 'procedures_update']);


        $owner = Role::firstOrCreate(['name' => 'owner']);
        $owner->givePermissionTo([
            $users_list,
            $users_create,
            $users_edit,
            $users_show,
            $users_delete,
            $users_reset_pass,
            $users_profile,

            $procedures_list,
            $procedures_create,
            $procedures_edit,
            $procedures_show,
            $procedures_delete,
            $procedures_update,
        ]);

        $secretary = Role::firstOrCreate(['name' => 'secretary']);
        $secretary->givePermissionTo([
            $users_profile,
            $procedures_list,
            $procedures_show,
        ]);

        $patient = Role::firstOrCreate(['name' => 'patient']);
        $patient->givePermissionTo([
            $users_profile,
        ]);



    }
}
