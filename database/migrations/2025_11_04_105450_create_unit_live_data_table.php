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
        Schema::create('unit_live_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete();
            $table->tinyInteger('emergency_stop_status')->default(0);
            $table->tinyInteger('door_limit_switch_status')->default(0);
            $table->float('current_flow')->default(0);
            $table->float('today_flow')->default(0);
            $table->tinyInteger('panel_lock_status')->default(0);
            $table->tinyInteger('overload_status')->default(0);
            $table->string('error_code')->nullable();
            $table->tinyInteger('flow_status')->default(0);
            $table->tinyInteger('auto_manual')->default(0);
            $table->float('tank_level')->default(0);
            $table->float('kld_limit_send')->default(0);
            $table->float('output_value')->default(0);
            $table->integer('rtc_dd')->default(0);
            $table->integer('rtc_hh')->default(0);
            $table->integer('rtc_mm')->default(0);
            $table->string('ph')->nullable();
            $table->string('tds')->nullable();
            $table->float('pipe_size')->default(0);
            $table->float('totalizer')->default(0);
            $table->string('version')->nullable();
            $table->string('api_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_live_data');
    }
};
