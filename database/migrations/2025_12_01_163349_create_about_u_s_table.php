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
        Schema::create('about_u_s', function (Blueprint $table) {
            $table->id();
            
            // Main Section
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('contact_button_text')->nullable();
            $table->string('contact_button_link')->nullable();
            $table->string('service_button_text')->nullable();
            $table->string('service_button_link')->nullable();
            $table->string('image')->nullable();

            // Counts
            $table->string('client_count')->nullable();
            $table->string('client_title')->nullable();
            $table->string('monthly_transaction_count')->nullable();
            $table->string('monthly_transaction_title')->nullable();
            $table->string('member_count')->nullable();
            $table->string('member_title')->nullable();
            $table->string('experience_count')->nullable();
            $table->string('experience_title')->nullable();

            // Mission Section
            $table->string('mission_title')->nullable();
            $table->text('mission_description')->nullable();
            $table->string('mission_title_2')->nullable();
            $table->string('list_1')->nullable();
            $table->string('list_2')->nullable();
            $table->string('list_3')->nullable();
            $table->string('list_4')->nullable();
            $table->string('list_5')->nullable();
            $table->string('list_6')->nullable();

            // Our Work Section
            $table->string('ourwork_title')->nullable();
            $table->string('list_1_title')->nullable();
            $table->string('list_1_subtitle')->nullable();
            $table->string('list_2_title')->nullable();
            $table->string('list_2_subtitle')->nullable();
            $table->string('list_3_title')->nullable();
            $table->string('list_3_subtitle')->nullable();
            $table->string('list_4_title')->nullable();
            $table->string('list_4_subtitle')->nullable();
            $table->string('list_5_title')->nullable();
            $table->string('list_5_subtitle')->nullable();

            // How to Work Section
            $table->string('how_to_work_title')->nullable();
            $table->text('how_to_work_subtitle')->nullable();
            $table->string('how_to_work_button_text')->nullable();
            $table->string('how_to_work_button_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_u_s');
    }
};
