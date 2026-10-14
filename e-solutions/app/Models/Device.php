<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'device_id',
        'name',
        'location',
        'status',
        'relay_active',
        'max_power_kw',
        'current_power_kw',
        'temperature',
        'rssi',
        'snr',
        'last_seen_at',
    ];

    protected $casts = [
        'relay_active' => 'boolean',
        'max_power_kw' => 'float',
        'current_power_kw' => 'float',
        'temperature' => 'float',
        'rssi' => 'integer',
        'snr' => 'float',
        'last_seen_at' => 'datetime',
    ];

    public function telemetry()
    {
        return $this->hasMany(Telemetry::class, 'device_id', 'device_id');
    }
}
