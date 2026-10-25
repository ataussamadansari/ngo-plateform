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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->nullable()->constrained('campaigns')->nullOnDelete();
            $table->string('receipt_number', 50)->unique()->nullable();
            $table->string('donor_name', 150);
            $table->string('donor_email', 150)->nullable();
            $table->string('donor_phone', 20)->index();
            $table->string('donor_pan', 20)->nullable();
            $table->text('donor_address')->nullable();
            $table->decimal('amount', 12, 2);
            $table->enum('payment_mode', ['upi_qr', 'bank_transfer', 'cash'])->default('upi_qr');
            $table->string('utr_number', 100)->unique();
            $table->string('payment_screenshot', 255)->nullable();
            $table->string('donor_message', 500)->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending')->index();
            $table->text('admin_remarks')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
