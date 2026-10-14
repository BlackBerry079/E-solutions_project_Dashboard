<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Device;
use App\Models\Telemetry;
use Carbon\Carbon;

class DeviceController extends Controller
{
    /**
     * Schakel relais aan/uit (alleen voor Admins!)
     */
    public function toggleRelay($id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'Toegang geweigerd: Alleen systeembeheerders (Admins) mogen de hardware relais en laadstations schakelen.');
        }

        $device = Device::findOrFail($id);
        $device->relay_active = !$device->relay_active;
        $device->status = $device->relay_active ? 'charging' : 'idle';
        $device->current_power_kw = $device->relay_active ? min($device->max_power_kw, 18.5) : 0.0;
        $device->save();

        $action = $device->relay_active ? 'ingeschakeld (Stroom AAN)' : 'uitgeschakeld (Stroom UIT / Noodstop)';
        return redirect()->back()->with('success', "Relais van {$device->name} is succesvol {$action}.");
    }

    /**
     * Maximum laadvermogen (kW) instellen (alleen voor Admins!)
     */
    public function updatePower(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'Toegang geweigerd: Alleen systeembeheerders (Admins) mogen het maximaal vermogen (kW) wijzigen.');
        }

        $request->validate([
            'max_power_kw' => 'required|numeric|min:1|max:350',
        ]);

        $device = Device::findOrFail($id);
        $device->max_power_kw = $request->max_power_kw;
        if ($device->current_power_kw > $device->max_power_kw) {
            $device->current_power_kw = $device->max_power_kw;
        }
        $device->save();

        return redirect()->back()->with('success', "Max vermogen voor {$device->name} is bijgewerkt naar {$device->max_power_kw} kW.");
    }

    /**
     * API Endpoint voor Raspberry Pi Pico / LoRa Gateway / MQTT Webhook
     */
    public function storeMqttTelemetry(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string',
            'topic' => 'nullable|string',
            'voltage' => 'nullable|numeric',
            'current_amp' => 'nullable|numeric',
            'power_kw' => 'nullable|numeric',
            'temperature' => 'nullable|numeric',
            'rssi' => 'nullable|integer',
            'snr' => 'nullable|numeric',
        ]);

        $device = Device::firstOrCreate(
            ['device_id' => $validated['device_id']],
            [
                'name' => 'Pi Pico Node ' . $validated['device_id'],
                'location' => 'ESG Tech Laadplein',
                'status' => 'online',
            ]
        );

        // Update live status van de Pi Pico node
        $device->current_power_kw = $validated['power_kw'] ?? $device->current_power_kw;
        $device->temperature = $validated['temperature'] ?? $device->temperature;
        $device->rssi = $validated['rssi'] ?? $device->rssi;
        $device->snr = $validated['snr'] ?? $device->snr;
        $device->last_seen_at = Carbon::now();
        $device->status = ($device->relay_active && $device->current_power_kw > 0.5) ? 'charging' : 'online';
        $device->save();

        // Bewaar de meting in het MQTT telemetrie log
        $telemetry = Telemetry::create([
            'device_id' => $device->device_id,
            'topic' => $validated['topic'] ?? 'esolutions/lora/' . strtolower($device->device_id) . '/data',
            'voltage' => $validated['voltage'] ?? 230.0,
            'current_amp' => $validated['current_amp'] ?? 16.0,
            'power_kw' => $validated['power_kw'] ?? $device->current_power_kw,
            'temperature' => $validated['temperature'] ?? $device->temperature,
            'rssi' => $validated['rssi'] ?? -75,
            'snr' => $validated['snr'] ?? 8.0,
            'raw_payload' => json_encode($request->all()),
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'LoRa MQTT telemetrie succesvol ontvangen en opgeslagen',
            'device' => $device->device_id,
            'timestamp' => Carbon::now()->toIso8601String(),
        ], 200);
    }

    /**
     * Simuleer een nieuwe Pi Pico LoRa meting (Handig voor presentaties/tests)
     */
    public function simulateTelemetry($id)
    {
        $device = Device::findOrFail($id);
        
        $volts = round(228 + (rand(0, 40) / 10), 1); // 228.0 - 232.0 V
        $temp = round(20 + (rand(0, 50) / 10), 1);   // 20.0 - 25.0 °C
        $rssi = rand(-85, -62);                       // LoRa signaal
        $snr = round(6 + (rand(0, 40) / 10), 1);      // 6.0 - 10.0 dB

        if ($device->relay_active) {
            $kw = round(min($device->max_power_kw, max(3.5, $device->max_power_kw * (rand(60, 95) / 100))), 1);
            $amps = round(($kw * 1000) / $volts, 1);
        } else {
            $kw = 0.0;
            $amps = 0.0;
        }

        $device->current_power_kw = $kw;
        $device->temperature = $temp;
        $device->rssi = $rssi;
        $device->snr = $snr;
        $device->last_seen_at = Carbon::now();
        $device->status = ($device->relay_active && $kw > 0) ? 'charging' : ($device->relay_active ? 'online' : 'idle');
        $device->save();

        Telemetry::create([
            'device_id' => $device->device_id,
            'topic' => 'esolutions/lora/' . strtolower($device->device_id) . '/data',
            'voltage' => $volts,
            'current_amp' => $amps,
            'power_kw' => $kw,
            'temperature' => $temp,
            'rssi' => $rssi,
            'snr' => $snr,
            'raw_payload' => json_encode(['v' => $volts, 'a' => $amps, 'kw' => $kw, 'rssi' => $rssi]),
            'created_at' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', "Nieuw LoRa MQTT pakket gesimuleerd voor {$device->device_id}: {$kw} kW, {$volts}V, RSSI {$rssi} dBm.");
    }
}
