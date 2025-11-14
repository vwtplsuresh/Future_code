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
        Schema::create('daily_totailzers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete();
            $table->float('totalizer');
            $table->tinyInteger('is_online')->default(0);
            $table->tinyInteger('is_panel_lock')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_totailzers');
    }
};
