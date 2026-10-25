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
        Schema::create('fund_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->nullable()->constrained('campaigns')->nullOnDelete();
            $table->string('title', 255);
            $table->string('beneficiary_name', 200);
            $table->decimal('amount_spent', 12, 2);
            $table->date('distribution_date')->index();
            $table->string('payment_reference', 150)->nullable();
            $table->string('proof_bill_image', 255)->nullable();
            $table->json('impact_photos')->nullable();
            $table->text('description');
            $table->boolean('is_public')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_distributions');
    }
};
