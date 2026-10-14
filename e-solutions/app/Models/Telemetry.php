<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telemetry extends Model
{
    protected $table = 'telemetry_logs';
    public $timestamps = false; // We use created_at automatically via schema

    protected $fillable = [
        'device_id',
        'topic',
        'voltage',
        'current_amp',
        'power_kw',
        'temperature',
        'rssi',
        'snr',
        'raw_payload',
        'created_at',
    ];

    protected $casts = [
        'voltage' => 'float',
        'current_amp' => 'float',
        'power_kw' => 'float',
        'temperature' => 'float',
        'rssi' => 'integer',
        'snr' => 'float',
        'created_at' => 'datetime',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'device_id');
    }
}
