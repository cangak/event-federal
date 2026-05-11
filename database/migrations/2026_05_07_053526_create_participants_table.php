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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();

            $table->string('bib_number')->unique();
            $table->string('qr_token')->unique();

            $table->string('name');
            $table->string('community')->nullable();

            $table->date('birth_date')->nullable();

            $table->text('address')->nullable();

            $table->string('phone', 20)->unique();
            $table->string('emergency_contact', 20);
            $table->enum('blood_type', [
                'A',
                'B',
                'AB',
                'O',
                'A+',
                'B+',
                'AB+',
                'O+',
                'A-',
                'B-',
                'AB-',
                'O-',
            ])->nullable();

            $table->timestamp('registered_at')->nullable();
            $table->timestamp('cp1_at')->nullable();
            $table->timestamp('cp2_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};