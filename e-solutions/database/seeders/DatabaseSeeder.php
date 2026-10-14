<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Device;
use App\Models\Telemetry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Beheerdersaccount (Admin met rechten om systemen aan te passen)
        User::updateOrCreate(
            ['email' => 'admin@esolutions.nl'],
            [
                'name' => 'Admin E-Solutions',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );

        // 2. Standaard Demo gebruiker (Alleen-lezen weergave)
        User::updateOrCreate(
            ['email' => 'demo@esolutions.nl'],
            [
                'name' => 'Demo Gebruiker',
                'password' => Hash::make('password123'),
                'is_admin' => false,
            ]
        );

        // 3. Raspberry Pi Pico + LoRa sensor nodes
        $pico1 = Device::updateOrCreate(
            ['device_id' => 'PICO-LORA-01'],
            [
                'name' => 'Pi Pico Snellader A1',
                'location' => 'Duurzaamheidsfabriek Dordrecht',
                'status' => 'charging',
                'relay_active' => true,
                'max_power_kw' => 22.0,
                'current_power_kw' => 18.4,
                'temperature' => 24.6,
                'rssi' => -68,
                'snr' => 9.4,
                'last_seen_at' => Carbon::now()->subSeconds(14),
            ]
        );

        $pico2 = Device::updateOrCreate(
            ['device_id' => 'PICO-LORA-02'],
            [
                'name' => 'Pi Pico Zonnepark Hub',
                'location' => 'Haven Alblasserdam',
                'status' => 'online',
                'relay_active' => true,
                'max_power_kw' => 44.0,
                'current_power_kw' => 31.2,
                'temperature' => 21.2,
                'rssi' => -82,
                'snr' => 7.8,
                'last_seen_at' => Carbon::now()->subSeconds(32),
            ]
        );

        $pico3 = Device::updateOrCreate(
            ['device_id' => 'PICO-LORA-03'],
            [
                'name' => 'Pi Pico Batterij Buffer',
                'location' => 'ESG Tech Testlab DaVinci',
                'status' => 'idle',
                'relay_active' => false,
                'max_power_kw' => 50.0,
                'current_power_kw' => 0.0,
                'temperature' => 19.1,
                'rssi' => -74,
                'snr' => 8.9,
                'last_seen_at' => Carbon::now()->subMinutes(2),
            ]
        );

        // 4. Recente MQTT Telemetrie logs
        if (Telemetry::count() === 0) {
            Telemetry::create([
                'device_id' => 'PICO-LORA-01',
                'topic' => 'esolutions/lora/dordrecht/pico01/telemetry',
                'voltage' => 231.2,
                'current_amp' => 79.5,
                'power_kw' => 18.4,
                'temperature' => 24.6,
                'rssi' => -68,
                'snr' => 9.4,
                'raw_payload' => json_encode(['v' => 231.2, 'a' => 79.5, 'kw' => 18.4, 't' => 24.6, 'rssi' => -68]),
                'created_at' => Carbon::now()->subSeconds(14),
            ]);

            Telemetry::create([
                'device_id' => 'PICO-LORA-02',
                'topic' => 'esolutions/lora/alblasserdam/pico02/telemetry',
                'voltage' => 229.8,
                'current_amp' => 135.7,
                'power_kw' => 31.2,
                'temperature' => 21.2,
                'rssi' => -82,
                'snr' => 7.8,
                'raw_payload' => json_encode(['v' => 229.8, 'a' => 135.7, 'kw' => 31.2, 't' => 21.2, 'rssi' => -82]),
                'created_at' => Carbon::now()->subSeconds(32),
            ]);

            Telemetry::create([
                'device_id' => 'PICO-LORA-03',
                'topic' => 'esolutions/lora/davinci/pico03/telemetry',
                'voltage' => 230.0,
                'current_amp' => 0.0,
                'power_kw' => 0.0,
                'temperature' => 19.1,
                'rssi' => -74,
                'snr' => 8.9,
                'raw_payload' => json_encode(['v' => 230.0, 'a' => 0.0, 'kw' => 0.0, 't' => 19.1, 'rssi' => -74]),
                'created_at' => Carbon::now()->subMinutes(2),
            ]);
        }
    }
}
