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
        Schema::create('morning_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete();
            $table->float('totalizer')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('morning_data');
    }
};
