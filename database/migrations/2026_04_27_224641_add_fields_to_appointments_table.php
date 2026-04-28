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

        if (!Schema::hasColumn('appointments', 'patient_phone')) {
            $table->string('patient_phone')->nullable();
        }

        if (!Schema::hasColumn('appointments', 'notes')) {
            $table->text('notes')->nullable();
        }

        if (!Schema::hasColumn('appointments', 'status')) {
            $table->string('status')->default('pending');
        }
    });
}

public function down()
{
    Schema::table('appointments', function (Blueprint $table) {
        $table->dropColumn([
            'patient_name',
            'patient_email',
            'patient_phone',
            'appointment_date',
            'appointment_time',
            'notes',
            'status'
        ]);
    });
}
};
