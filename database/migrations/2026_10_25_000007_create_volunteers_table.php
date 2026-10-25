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
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->string('volunteer_code', 50)->unique()->nullable();
            $table->string('full_name', 150);
            $table->string('email', 150)->unique();
            $table->string('phone', 20)->unique();
            $table->string('city', 100)->index();
            $table->text('address')->nullable();
            $table->string('occupation', 100)->nullable();
            $table->json('skills');
            $table->enum('availability', ['weekdays', 'weekends', 'flexible'])->default('weekends');
            $table->string('profile_photo', 255)->nullable();
            $table->string('id_proof_path', 255)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'inactive'])->default('pending')->index();
            $table->date('joined_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
