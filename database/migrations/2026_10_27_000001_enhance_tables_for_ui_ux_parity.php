<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to enhance schema for complete UI/UX mockup parity.
     */
    public function up(): void
    {
        // 1. Enhance Campaigns Table
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('location', 150)->nullable()->after('end_date');
            $table->string('beneficiary_summary', 150)->nullable()->after('location');
            $table->string('video_url', 500)->nullable()->after('beneficiary_summary');
            $table->json('key_highlights')->nullable()->after('video_url');
            $table->json('faq_items')->nullable()->after('key_highlights');
        });

        // 2. Enhance Events Table
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('id')->constrained('cause_categories')->nullOnDelete();
            $table->string('outcome_summary', 255)->nullable()->after('description');
        });

        // 3. Enhance Volunteers Table
        Schema::table('volunteers', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->string('area_of_interest', 100)->nullable()->after('skills');
            $table->text('about_volunteer')->nullable()->after('area_of_interest');
        });

        // 4. Create Team Members Table (for About Us page leadership & team grid)
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('role', 100);
            $table->text('bio')->nullable();
            $table->string('photo', 255)->nullable();
            $table->json('social_links')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');

        Schema::table('volunteers', function (Blueprint $table) {
            $table->dropColumn(['date_of_birth', 'area_of_interest', 'about_volunteer']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'outcome_summary']);
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['location', 'beneficiary_summary', 'video_url', 'key_highlights', 'faq_items']);
        });
    }
};
