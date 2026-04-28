<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('appointments', function (Blueprint $table) {

        if (!Schema::hasColumn('appointments', 'patient_name')) {
            $table->string('patient_name');
        }

        if (!Schema::hasColumn('appointments', 'patient_email')) {
            $table->string('patient_email');
        }

        if (!Schema::hasColumn('appointments', 'appointment_time')) {
            $table->time('appointment_time')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            //
        });
    }
};
