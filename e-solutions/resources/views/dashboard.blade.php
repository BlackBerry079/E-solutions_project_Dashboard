@php $errors = $errors ?? new \Illuminate\Support\ViewErrorBag; @endphp
<!DOCTYPE html>
<html lang="nl" class="h-full bg-[#001E22]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Energie Portaal &bull; Pi Pico & LoRa Monitoring | E-Solutions &bull; ESG Tech</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN fallback + Vite build support) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Space Grotesk"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        petrol: {
                            800: '#00464F',
                            900: '#00333A',
                            950: '#001E22',
                        },
                        amberEnergy: {
                            400: '#FFD026',
                            500: '#F6C003',
                            600: '#DDAA00',
                        }
                    }
                }
            }
        }
    </script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-full font-sans antialiased text-slate-100 bg-[#001E22] flex flex-col selection:bg-amberEnergy-500 selection:text-slate-950">

    <!-- Navigation Header -->
    <header class="bg-[#002D34]/95 border-b border-[#004D57]/70 sticky top-0 z-30 shadow-lg backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#00373E] to-[#04616D] border border-amberEnergy-500/40 text-amberEnergy-400 flex items-center justify-center shadow-md shadow-black/40 group-hover:border-amberEnergy-400 transition">
                        <svg class="w-5 h-5 drop-shadow-[0_1px_4px_rgba(246,192,3,0.5)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-lg font-extrabold tracking-tight text-white font-display uppercase">E-Solutions</span>
                            <span class="px-2 py-0.5 text-[10px] font-bold tracking-wider text-amberEnergy-400 bg-amberEnergy-400/10 border border-amberEnergy-400/30 rounded-md uppercase">ESG Tech</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- User Auth status / Actions -->
            <div class="flex items-center gap-3 sm:gap-4">
                @auth
                    <div class="text-right hidden sm:block">
                        <div class="flex items-center gap-1.5 justify-end">
                            <p class="text-sm font-bold text-white">{{ Auth::user()->name }}</p>
                            @if(Auth::user()->is_admin)
                                <span class="px-1.5 py-0.5 text-[10px] font-bold bg-amberEnergy-400 text-slate-950 rounded">Admin</span>
                            @endif
                        </div>
                        <p class="text-xs text-amberEnergy-400/90">{{ Auth::user()->email }}</p>
                    </div>
                    <a
                        href="{{ route('signout') }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs sm:text-sm font-bold text-slate-900 bg-amberEnergy-400 hover:bg-amberEnergy-300 rounded-xl shadow-md shadow-amberEnergy-400/20 transition duration-150"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Uitloggen</span>
                    </a>
                @else
                    <div class="hidden sm:flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#001E23] text-slate-300 border border-[#00434C]">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span> Openbaar Systeem (Inzichtelijk)
                        </span>
                    </div>
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-xs sm:text-sm font-bold text-slate-950 bg-amberEnergy-400 hover:bg-amberEnergy-300 rounded-xl shadow-md shadow-amberEnergy-400/20 transition duration-150"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span>Inloggen voor Beheer</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Flash messages -->
        @if (session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-950/80 border border-emerald-500/50 text-emerald-200 flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-red-950/80 border border-red-500/50 text-red-200 flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-white">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        <!-- System Architecture Banner -->
        <div class="bg-gradient-to-r from-[#003840] via-[#00464F] to-[#04616D] border border-amberEnergy-500/30 rounded-3xl p-6 sm:p-8 text-white shadow-2xl mb-8 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-amberEnergy-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amberEnergy-400/20 text-amberEnergy-300 text-xs font-bold tracking-wide uppercase border border-amberEnergy-400/40">
                            ⚡ Pi Pico &bull; LoRa &bull; MQTT Database
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Open Systeem Live
                        </span>
                        @auth
                            @if(Auth::user()->is_admin)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amberEnergy-400 text-slate-950 flex items-center gap-1">
                                    👑 Admin Bediening Geactiveerd
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#001E23] text-slate-300 border border-[#00434C]">
                                    👁️ Alleen Lezen (Gebruiker)
                                </span>
                            @endif
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#001E23] text-slate-300 border border-[#00434C]">
                                👁️ Openbare Monitoring (Alleen Lezen)
                            </span>
                        @endauth
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight font-display">
                        E-Solutions Live Sensornetwerk
                    </h1>
                    <p class="mt-2 text-slate-300 text-sm sm:text-base max-w-2xl leading-relaxed">
                        Data wordt via <strong>Raspberry Pi Pico</strong> microcontrollers verzonden via <strong>LoRa</strong> radiofrequenties naar de <strong>MQTT database</strong>. Iedereen kan de energiestromen vrij inzien. Het schakelen van relais en aanpassen van vermogens is voorbehouden aan <strong>Admins</strong>.
                    </p>
                </div>

                <!-- Quick Summary KPI Badges -->
                <div class="grid grid-cols-3 gap-3 bg-[#002227]/70 p-4 rounded-2xl border border-[#004D57]/60 backdrop-blur-sm shrink-0">
                    <div class="text-center px-2">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Pico Nodes</span>
                        <span class="text-xl sm:text-2xl font-black text-amberEnergy-400 font-display">{{ $devices->count() }}</span>
                    </div>
                    <div class="text-center px-2 border-x border-[#00414B]">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Totaal Vermogen</span>
                        <span class="text-xl sm:text-2xl font-black text-white font-display">{{ round($devices->sum('current_power_kw'), 1) }} <span class="text-xs font-normal text-slate-400">kW</span></span>
                    </div>
                    <div class="text-center px-2">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">LoRa Status</span>
                        <span class="text-xl sm:text-2xl font-black text-emerald-400 font-display">100%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 1: Raspberry Pi Pico & LoRa Nodes Overzicht -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl font-extrabold text-white font-display flex items-center gap-2">
                        <span>📡</span> Raspberry Pi Pico LoRa Knooppunten
                    </h2>
                    <p class="text-xs text-slate-400">Actieve hardware nodes met live laadvermogen, relais-status en LoRa radio-signaal (RSSI/SNR)</p>
                </div>
                @auth
                    @if(Auth::user()->is_admin)
                        <span class="text-xs px-2.5 py-1 rounded-md font-bold bg-amberEnergy-400/20 text-amberEnergy-300 border border-amberEnergy-400/40">
                            ⚙️ Bediening Ingeschakeld
                        </span>
                    @endif
                @endauth
            </div>

            <!-- Device Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($devices as $device)
                <div class="bg-[#002D34]/95 rounded-2xl border {{ $device->relay_active ? 'border-[#004D57]/80' : 'border-red-900/50' }} p-6 shadow-xl flex flex-col justify-between transition relative overflow-hidden">
                    <!-- Ambient Status glow -->
                    @if($device->relay_active)
                        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
                    @else
                        <div class="absolute top-0 right-0 w-32 h-32 bg-red-500/10 rounded-full blur-2xl pointer-events-none"></div>
                    @endif

                    <div>
                        <!-- Header of card -->
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <span class="font-mono text-[11px] font-bold text-amberEnergy-400 px-2 py-0.5 rounded bg-[#001E23] border border-[#00434C]">
                                    {{ $device->device_id }}
                                </span>
                                <h3 class="font-bold text-white text-base mt-2">{{ $device->name }}</h3>
                                <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                                    <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $device->location }}
                                </p>
                            </div>
                            <div>
                                @if($device->relay_active && $device->current_power_kw > 0)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Laden
                                    </span>
                                @elseif($device->relay_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-500/20 text-sky-300 border border-sky-500/40">
                                        <span class="w-2 h-2 rounded-full bg-sky-400"></span> Stand-by
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-red-500/20 text-red-300 border border-red-500/40">
                                        <span class="w-2 h-2 rounded-full bg-red-400"></span> Noodstop / Uit
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Telemetrie metrics grid -->
                        <div class="grid grid-cols-2 gap-2.5 my-4">
                            <div class="bg-[#001E23] p-3 rounded-xl border border-[#00434C]">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block">Vermogen</span>
                                <span class="text-lg font-black text-white font-display">{{ $device->current_power_kw }} <span class="text-xs font-normal text-slate-400">kW</span></span>
                                <span class="text-[10px] text-slate-400 block mt-0.5">Max: {{ $device->max_power_kw }} kW</span>
                            </div>
                            <div class="bg-[#001E23] p-3 rounded-xl border border-[#00434C]">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block">Temperatuur</span>
                                <span class="text-lg font-black text-slate-200 font-display">{{ $device->temperature }} <span class="text-xs font-normal text-slate-400">°C</span></span>
                                <span class="text-[10px] text-emerald-400 block mt-0.5">Normaal bereik</span>
                            </div>
                            <div class="bg-[#001E23] p-3 rounded-xl border border-[#00434C]">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block">LoRa RSSI</span>
                                <span class="text-sm font-bold text-amberEnergy-400 font-mono">{{ $device->rssi }} dBm</span>
                                <span class="text-[10px] text-slate-400 block mt-0.5">Signaalsterkte</span>
                            </div>
                            <div class="bg-[#001E23] p-3 rounded-xl border border-[#00434C]">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block">LoRa SNR</span>
                                <span class="text-sm font-bold text-sky-400 font-mono">{{ $device->snr }} dB</span>
                                <span class="text-[10px] text-slate-400 block mt-0.5">Ruisverhouding</span>
                            </div>
                        </div>

                        <!-- Relais status balk -->
                        <div class="pt-3 border-t border-[#00414B] flex items-center justify-between text-xs">
                            <span class="text-slate-400">Hardware Relais:</span>
                            @if($device->relay_active)
                                <span class="font-bold text-emerald-400 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> STROOM AAN
                                </span>
                            @else
                                <span class="font-bold text-red-400 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> ONDERBROKEN
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Actions Area: Admin vs Viewer -->
                    <div class="mt-5 pt-4 border-t border-[#00414B]">
                        @auth
                            @if(Auth::user()->is_admin)
                                <!-- ADMIN CONTROLS -->
                                <div class="space-y-3">
                                    <!-- Toggle Relay Form -->
                                    <form action="{{ route('admin.devices.toggle', $device->id) }}" method="POST">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-xl text-xs font-bold transition duration-150 {{ $device->relay_active ? 'bg-red-500/20 hover:bg-red-500/30 text-red-300 border border-red-500/40' : 'bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300 border border-emerald-500/40' }}"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                            <span>{{ $device->relay_active ? 'Schakel Relais UIT (Noodstop)' : 'Schakel Relais IN (Stroom AAN)' }}</span>
                                        </button>
                                    </form>

                                    <!-- Adjust Max Power Limit -->
                                    <form action="{{ route('admin.devices.power', $device->id) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <div class="relative flex-1">
                                            <input
                                                type="number"
                                                name="max_power_kw"
                                                step="0.5"
                                                min="1"
                                                max="350"
                                                value="{{ $device->max_power_kw }}"
                                                class="w-full bg-[#001E23] border border-[#00434C] rounded-lg px-2.5 py-1.5 text-xs text-white font-mono focus:outline-none focus:border-amberEnergy-400"
                                            >
                                            <span class="absolute right-2 top-1.5 text-[10px] text-slate-400">kW</span>
                                        </div>
                                        <button
                                            type="submit"
                                            class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-950 bg-amberEnergy-400 hover:bg-amberEnergy-300 transition"
                                        >
                                            Limiet Opslaan
                                        </button>
                                    </form>

                                    <!-- Simulate LoRa packet -->
                                    <form action="{{ route('admin.devices.simulate', $device->id) }}" method="POST">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="w-full text-center text-[11px] font-medium text-slate-400 hover:text-amberEnergy-400 transition"
                                        >
                                            🔄 Simuleer LoRa Meting
                                        </button>
                                    </form>
                                </div>
                            @else
                                <!-- REGULAR USER / VIEW ONLY -->
                                <div class="bg-[#001E23] p-2.5 rounded-xl border border-[#00434C] text-center">
                                    <span class="text-xs text-slate-400 flex items-center justify-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-amberEnergy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        Alleen Admins mogen relais bedienen
                                    </span>
                                </div>
                            @endif
                        @else
                            <!-- GUEST / OPEN SYSTEM -->
                            <div class="bg-[#001E23] p-2.5 rounded-xl border border-[#00434C] text-center">
                                <span class="text-xs text-slate-400 flex items-center justify-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-amberEnergy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    Openbaar inzichtelijk &bull; <a href="{{ route('login') }}" class="text-amberEnergy-400 underline font-semibold">Log in als Admin</a>
                                </span>
                            </div>
                        @endauth
                    </div>

                </div>
                @endforeach
            </div>
        </div>

        <!-- Section 2: Recente MQTT LoRa Telemetrie Logs -->
        <div class="bg-[#002D34]/90 rounded-2xl border border-[#004D57]/70 p-6 shadow-xl mb-10">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                <div>
                    <h3 class="font-bold text-white text-base sm:text-lg font-display flex items-center gap-2">
                        <span>📥</span> Live MQTT Telemetrie Logs
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Recente berichten binnengekomen via de LoRa Gateway & MQTT Broker</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-mono font-medium bg-[#001E23] text-amberEnergy-400 border border-[#00434C]">
                        MQTT Topic: esolutions/lora/+/telemetry
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-[#00414B]">
                <table class="w-full text-left text-xs sm:text-sm text-slate-300">
                    <thead class="text-[11px] uppercase tracking-wider bg-[#001E23] text-slate-400 border-b border-[#00434C]">
                        <tr>
                            <th scope="col" class="px-4 py-3">Tijd</th>
                            <th scope="col" class="px-4 py-3">Pico Node</th>
                            <th scope="col" class="px-4 py-3">MQTT Topic</th>
                            <th scope="col" class="px-4 py-3">Spanning (V)</th>
                            <th scope="col" class="px-4 py-3">Stroom (A)</th>
                            <th scope="col" class="px-4 py-3">Vermogen (kW)</th>
                            <th scope="col" class="px-4 py-3">LoRa RSSI / SNR</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#00414B] font-mono text-xs">
                        @forelse($telemetryLogs as $log)
                        <tr class="hover:bg-[#002329] transition">
                            <td class="px-4 py-3 text-slate-400 whitespace-nowrap">
                                {{ $log->created_at->format('H:i:s') }}
                                <span class="text-[10px] text-slate-500 block font-sans">({{ $log->created_at->diffForHumans() }})</span>
                            </td>
                            <td class="px-4 py-3 font-bold text-amberEnergy-400 whitespace-nowrap">
                                {{ $log->device_id }}
                            </td>
                            <td class="px-4 py-3 text-slate-400 text-[11px] max-w-[200px] truncate" title="{{ $log->topic }}">
                                {{ $log->topic }}
                            </td>
                            <td class="px-4 py-3 text-white">{{ $log->voltage ?? '-' }} V</td>
                            <td class="px-4 py-3 text-white">{{ $log->current_amp ?? '-' }} A</td>
                            <td class="px-4 py-3 font-bold text-emerald-400">{{ $log->power_kw ?? '0.0' }} kW</td>
                            <td class="px-4 py-3">
                                <span class="text-amberEnergy-400">{{ $log->rssi ?? '-' }} dBm</span>
                                <span class="text-slate-500"> / </span>
                                <span class="text-sky-400">{{ $log->snr ?? '-' }} dB</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-slate-500 font-sans text-sm">
                                Nog geen MQTT telemetriepakketten ontvangen.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section 3: Pi Pico & LoRa Integration Guide -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
            <!-- Pi Pico Hardware specificatie -->
            <div class="bg-[#002D34]/90 rounded-2xl border border-[#004D57]/70 p-6 shadow-xl">
                <div class="flex items-center gap-3 mb-4">
                    <span class="p-2.5 rounded-xl bg-[#001E23] text-amberEnergy-400 border border-[#00434C]">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="font-bold text-white text-base font-display">Raspberry Pi Pico + LoRa Architectuur</h3>
                        <p class="text-xs text-slate-400">Draadloze telemetrie over lange afstanden</p>
                    </div>
                </div>
                <div class="space-y-3 text-xs text-slate-300 leading-relaxed">
                    <p>
                        Elk E-Solutions laadplein is uitgerust met een <strong>Raspberry Pi Pico</strong> gekoppeld aan een <strong>LoRa transceiver</strong> (bijv. SX1276/SX1262 op 868 MHz).
                    </p>
                    <ul class="list-disc list-inside space-y-1 text-slate-400">
                        <li><strong>Sensoren:</strong> Meet spanning (V), stroom (CT-klem A) en temperatuur.</li>
                        <li><strong>LoRa Gateway:</strong> Ontvangt de pakketten op de centrale bedrijfshub in Dordrecht.</li>
                        <li><strong>MQTT Broker:</strong> Publiceert de JSON payload naar de centrale database.</li>
                    </ul>
                </div>
            </div>

            <!-- API Koppeling snippet voor Pi Pico / Python -->
            <div class="bg-[#002D34]/90 rounded-2xl border border-[#004D57]/70 p-6 shadow-xl flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-bold text-white text-base font-display flex items-center gap-2">
                            <span>💻</span> HTTP / MQTT Ingestion API
                        </h3>
                        <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">POST /api/mqtt/telemetry</span>
                    </div>
                    <p class="text-xs text-slate-400 mb-3">Voorbeeld JSON payload die de Pico of de LoRa-MQTT bridge verstuurt:</p>
                    <pre class="bg-[#001E23] p-3 rounded-xl border border-[#00434C] text-[11px] font-mono text-amberEnergy-400 overflow-x-auto">{
  "device_id": "PICO-LORA-01",
  "voltage": 231.4,
  "current_amp": 16.2,
  "power_kw": 3.7,
  "temperature": 22.8,
  "rssi": -72,
  "snr": 8.5
}</pre>
                </div>
                <div class="mt-4 pt-3 border-t border-[#00414B] flex items-center justify-between text-xs text-slate-400">
                    <span>Authenticatie: Open Ingestion</span>
                    <a href="https://esg-tech.nl" target="_blank" class="text-amberEnergy-400 hover:underline">ESG Tech Documentatie &rarr;</a>
                </div>
            </div>
        </div>

        @if(Auth::check() && Auth::user()->is_admin && isset($allUsers) && count($allUsers) > 0)
        <!-- Section 4: Admin Portaal & Geregistreerde Gebruikers (Alleen voor Admins) -->
        <div class="bg-[#002D34]/90 rounded-2xl border border-[#004D57]/70 p-6 shadow-xl mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-white text-base sm:text-lg font-display flex items-center gap-2">
                        <span>👑</span> Beheerpaneel &bull; Geregistreerde Gebruikers
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Overzicht van alle geregistreerde accounts (totaal: {{ count($allUsers) }})</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amberEnergy-400 text-slate-950">
                    Admin View
                </span>
            </div>
            <div class="overflow-x-auto rounded-xl border border-[#00414B]">
                <table class="w-full text-left text-xs sm:text-sm text-slate-300">
                    <thead class="text-[11px] uppercase tracking-wider bg-[#001E23] text-slate-400 border-b border-[#00434C]">
                        <tr>
                            <th scope="col" class="px-4 py-3">ID</th>
                            <th scope="col" class="px-4 py-3">Naam</th>
                            <th scope="col" class="px-4 py-3">E-mailadres</th>
                            <th scope="col" class="px-4 py-3">Rol</th>
                            <th scope="col" class="px-4 py-3">Geregistreerd</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#00414B]">
                        @foreach($allUsers as $u)
                        <tr class="hover:bg-[#002329] transition">
                            <td class="px-4 py-3 text-slate-400 font-mono text-xs">#{{ $u->id }}</td>
                            <td class="px-4 py-3 font-semibold text-white">{{ $u->name }}</td>
                            <td class="px-4 py-3 font-mono text-xs text-slate-300">{{ $u->email }}</td>
                            <td class="px-4 py-3">
                                @if($u->is_admin)
                                    <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-amberEnergy-400 text-slate-950">
                                        Admin
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-[#001E23] text-slate-300 border border-[#00434C]">
                                        Gebruiker
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-400">{{ $u->created_at ? $u->created_at->format('d-m-Y H:i') : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </main>

    <!-- Footer -->
    <footer class="bg-[#00181B] border-t border-[#003840] mt-auto py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
            <div>
                &copy; {{ date('Y') }} E-Solutions / ESG Tech BV &bull; Pi Pico LoRa &bull; MQTT Database Portaal
            </div>
            <div class="flex items-center gap-4 text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-amberEnergy-400 transition">Live Monitoring</a>
                <a href="{{ route('login') }}" class="hover:text-amberEnergy-400 transition">Inloggen</a>
                <a href="{{ route('registration') }}" class="hover:text-amberEnergy-400 transition">Registreren</a>
                <a href="https://esg-tech.nl" target="_blank" class="hover:text-amberEnergy-400 transition">ESG-Tech.nl</a>
            </div>
        </div>
    </footer>

</body>
</html>
