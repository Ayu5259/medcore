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
            // Add a general address field
            $table->text('address')->nullable();

            // Make province and city optional
            $table->string('province')->nullable()->change();
            $table->string('city')->nullable()->change();

            // Remove unnecessary detailed address fields
            $table->dropColumn([
                'street',
                'alley',
                'plaque',
                'unit',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restore detailed address fields
            $table->string('street')->nullable();
            $table->string('alley')->nullable();
            $table->string('plaque')->nullable();
            $table->string('unit')->nullable();

            // Remove the general address field
            $table->dropColumn('address');

            // Restore province and city as required
            $table->string('province')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
        });
    }
};
