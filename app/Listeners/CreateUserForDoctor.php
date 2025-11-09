<?php

namespace App\Listeners;

use App\Events\DoctorCreated;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserForDoctor
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DoctorCreated $event): void
    {
        $doctor = $event->doctor;
        // dd($doctor);
        // Generate email from doctor's name (e.g., first part of name + @clinic.com)
        $nameParts = explode(' ', $doctor->localized_name);
        $email = strtolower($nameParts[0]).'@clinic.com';

        // Ensure unique email
        $originalEmail = $email;
        $counter = 1;
        while (User::where('email', $email)->exists()) {
            $email = strtolower($nameParts[0]).$counter.'@clinic.com';
            $counter++;
        }

        // Create user
        $user = User::create([
            'name' => $doctor->name, // JSON name
            'email' => $email,
            'password' => Hash::make('password123'), // Default password
            'phone' => $doctor->phone,
            'password' => Hash::make('123456'),
            'status' => 1, // Active by default
            'age' => $doctor->age,

        ]);

        // Assign doctor role
        $user->assignRole('doctor');

        // Link user to doctor
        $doctor->update(['user_id' => $user->id]);
    }
}
