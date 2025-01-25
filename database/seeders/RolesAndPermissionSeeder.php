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

        $reservations_list = Permission::firstOrCreate(['name' => 'reservations_list']);
        $reservations_create = Permission::firstOrCreate(['name' => 'reservations_create']);
        $reservations_add = Permission::firstOrCreate(['name' => 'reservations_add']);
        $reservations_edit = Permission::firstOrCreate(['name' => 'reservations_edit']);
        $reservations_show = Permission::firstOrCreate(['name' => 'reservations_show']);
        $reservations_delete = Permission::firstOrCreate(['name' => 'reservations_delete']);
        $reservations_apply = Permission::firstOrCreate(['name' => 'reservations_apply']);
        $reservations_paid = Permission::firstOrCreate(['name' => 'reservations_paid']);
        $reservations_history = Permission::firstOrCreate(['name' => 'reservations_history']);
        $reservations_notes = Permission::firstOrCreate(['name' => 'reservations_notes']);

        $workDays_list = Permission::firstOrCreate(['name' => 'workDays_list']);
        $workDays_create = Permission::firstOrCreate(['name' => 'workDays_create']);



        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
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

            $reservations_list,
            $reservations_create,
            $reservations_add,
            $reservations_edit,
            $reservations_show,
            $reservations_delete,
            $reservations_apply,
            $reservations_history,

            $reservations_notes,

            $workDays_list,
            $workDays_create,
        ]);

        $secretary = Role::firstOrCreate(['name' => 'secretary']);
        $secretary->givePermissionTo([
            $users_profile,

            $procedures_list,
            $procedures_show,

            $reservations_list,
            $reservations_create,
            $reservations_add,
            $reservations_edit,
            $reservations_show,
            $reservations_delete,
            $reservations_paid,
            $reservations_history,

            $workDays_list,
        ]);

        $patient = Role::firstOrCreate(['name' => 'patient']);
        $patient->givePermissionTo([
            $users_profile,

            $reservations_list,
            $reservations_create,
            $reservations_edit,
            $reservations_show,
            $reservations_delete,
            $reservations_history,
            
            $workDays_list,
        ]);
    }
}
