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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('id')->on('locations')->cascadeOnDelete();
            $table->unsignedBigInteger('zone_id');
            $table->foreign('zone_id')->references('id')->on('zones')->cascadeOnDelete();
            $table->integer('panel_no')->unique();
            $table->string('title')->nullable();
            $table->string('address')->nullable();
            $table->string('operator_name')->nullable();
            $table->string('operator_mobile')->nullable();
            $table->float('total_limit')->default(0);
            $table->float('today_limit')->default(100);
            $table->tinyInteger('plc_reset')->default(0);
            $table->tinyInteger('panel_lock')->default(0);
            $table->tinyInteger('mode')->default(0);
            $table->tinyInteger('reset_totalizer')->default(0);
            $table->tinyInteger('reset_memory')->default(0);
            $table->text('panel_unlock_timing')->nullable();
            $table->string('cf_test')->nullable();
            $table->string('url_switch')->nullable();
            $table->string('PlcMicrocontroler')->nullable();
            $table->string('pipe_size')->nullable();
            $table->decimal('min_tds')->default(0);
            $table->decimal('max_tds')->default(0);
            $table->decimal('tds_bit')->default(0);
            $table->string('cto')->nullable();
            $table->string('cto_remark')->nullable();
            $table->string('data_n_1')->nullable();
            $table->string('data_n_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};

