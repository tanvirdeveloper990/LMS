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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('badge_text')->nullable();
            $table->string('title_1')->nullable();
            $table->string('title_2')->nullable();
            $table->text('description')->nullable();
            $table->string('card1_image')->nullable();
            $table->string('card1_title')->nullable();
            $table->string('card1_subtitle')->nullable();
            $table->string('card2_image')->nullable();
            $table->string('card2_title')->nullable();
            $table->string('card2_subtitle')->nullable();
            $table->string('card3_image')->nullable();
            $table->string('card3_title')->nullable();
            $table->string('card3_subtitle')->nullable();
            $table->string('card4_image')->nullable();
            $table->string('card4_title')->nullable();
            $table->string('card4_subtitle')->nullable();
            $table->string('image')->nullable();
            $table->string('badge_image')->nullable();
            $table->string('badge_title')->nullable();
            $table->string('badge_subtitle')->nullable();
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
