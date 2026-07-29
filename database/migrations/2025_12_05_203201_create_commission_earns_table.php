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
        Schema::create('commission_earns', function (Blueprint $table) {
            $table->id();
            $table->string('affiliate_id');
            $table->unsignedBigInteger('level_id');
            $table->decimal('amount', 10, 2);
            $table->decimal('total_sales', 12, 2);
            $table->decimal('percentage', 5, 2);
            $table->string('status')->default('unpaid');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_earns');
    }
};
