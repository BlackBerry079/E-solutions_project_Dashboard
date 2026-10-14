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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->unique(); // bijv. PICO-LORA-01
            $table->string('name');
            $table->string('location');
            $table->string('status')->default('online'); // online, offline, charging, idle
            $table->boolean('relay_active')->default(true); // Relais / Stroomvoorziening aan/uit
            $table->float('max_power_kw')->default(22.0); // Instelbare limiet door Admin
            $table->float('current_power_kw')->default(0.0);
            $table->float('temperature')->default(20.0);
            $table->integer('rssi')->default(-75); // LoRa signaalsterkte (dBm)
            $table->float('snr')->default(8.0); // LoRa Signaal-Ruisverhouding
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();
        });

        Schema::create('telemetry_logs', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->index();
            $table->string('topic')->nullable(); // bijv. esolutions/lora/pico-01/data
            $table->float('voltage')->nullable();
            $table->float('current_amp')->nullable();
            $table->float('power_kw')->nullable();
            $table->float('temperature')->nullable();
            $table->integer('rssi')->nullable();
            $table->float('snr')->nullable();
            $table->text('raw_payload')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telemetry_logs');
        Schema::dropIfExists('devices');
    }
};
