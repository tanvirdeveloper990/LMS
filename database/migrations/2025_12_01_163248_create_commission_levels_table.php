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
        Schema::create('commission_levels', function (Blueprint $table) {
            $table->id();
            $table->string('level')->nullable();
            $table->bigInteger('start')->nullable();
            $table->bigInteger('end')->nullable();
            $table->bigInteger('persentage')->nullable(); // Example: 10.50%
            $table->string('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_levels');
    }
};
