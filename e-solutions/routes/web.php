<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\DeviceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Open Dashboard (Openbaar inzichtelijk voor iedereen)
Route::get('/', [CustomAuthController::class, 'dashboard'])->name('home');
Route::get('/dashboard', [CustomAuthController::class, 'dashboard'])->name('dashboard');

// Authenticatie Routes
Route::get('/login', [CustomAuthController::class, 'login'])->name('login');
Route::post('/custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');

Route::get('/registration', [CustomAuthController::class, 'registration'])->name('registration');
Route::get('/register', [CustomAuthController::class, 'registration'])->name('register');
Route::post('/custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');

// Uitloggen
Route::get('/signout', [CustomAuthController::class, 'signOut'])->name('signout');
Route::post('/logout', [CustomAuthController::class, 'signOut'])->name('logout');

// Systeembediening (Relais & Vermogen aanpassen - Alleen Admin!)
Route::post('/admin/devices/{id}/toggle-relay', [DeviceController::class, 'toggleRelay'])->name('admin.devices.toggle');
Route::post('/admin/devices/{id}/update-power', [DeviceController::class, 'updatePower'])->name('admin.devices.power');
Route::post('/admin/devices/{id}/simulate', [DeviceController::class, 'simulateTelemetry'])->name('admin.devices.simulate');

// Pi Pico & LoRa MQTT Ingestion Webhook / API
Route::post('/api/mqtt/telemetry', [DeviceController::class, 'storeMqttTelemetry'])->name('api.mqtt.telemetry');
