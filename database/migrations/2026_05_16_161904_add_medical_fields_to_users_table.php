<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('blood_type', 5)->nullable()->after('age');
            $table->text('allergies')->nullable()->after('blood_type');
            $table->text('chronic_conditions')->nullable()->after('allergies');
            $table->string('emergency_contact_name')->nullable()->after('chronic_conditions');
            $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'blood_type', 'allergies', 'chronic_conditions',
                'emergency_contact_name', 'emergency_contact_phone',
            ]);
        });
    }
};
