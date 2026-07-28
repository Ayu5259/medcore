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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained();
            $table->foreignId('patient_id')->constrained();
            $table->date('appointment_date');
            $table->time('appointment_end_time');
            $table->time('appointment_start_time');

            $table->string('reason');
            $table->integer('room_number');
            $table->enum('status', [
                'pending',
                'confirmed',
                'cancelled',
                'completed',
            ]);
            $table->enum('visit_type', [
                'InPerson',
                'Online',
                'Emergency',
                'FollowUp',
            ]);
            $table->text('notes')->nullable();
            $table->timestamps();
            //duration
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
