@php $errors = $errors ?? new \Illuminate\Support\ViewErrorBag; @endphp
<!DOCTYPE html>
<html lang="nl" class="h-full bg-[#00282E]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aanmelden | E-Solutions &bull; Duurzame Energie & Laadsystemen</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN fallback + Vite build support) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Space Grotesk"', 'sans-serif'],
                    },
                    colors: {
                        petrol: {
                            50: '#ecfdf7',
                            100: '#d1fae9',
                            200: '#a7f3d5',
                            300: '#6ee7ba',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
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
<body class="h-full flex items-center justify-center p-4 sm:p-6 lg:p-8 font-sans antialiased text-slate-100 bg-[#002227] selection:bg-amberEnergy-500 selection:text-slate-900 relative overflow-x-hidden">

    <!-- Background glowing ambience (Energy grid feel) -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-40 left-1/4 w-[500px] h-[500px] bg-[#00464F]/50 rounded-full blur-[130px]"></div>
        <div class="absolute -bottom-40 right-1/4 w-[550px] h-[550px] bg-amberEnergy-500/10 rounded-full blur-[140px]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#00464F_1px,transparent_1px)] [background-size:24px_24px] opacity-25"></div>
    </div>

    <div class="w-full max-w-md my-8">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-[#00373E] via-[#00464F] to-[#04616D] text-amberEnergy-400 shadow-xl shadow-[#001E22]/60 mb-4 border border-amberEnergy-500/40 ring-4 ring-[#001A1D]/60 relative">
                <svg class="w-8 h-8 drop-shadow-[0_2px_8px_rgba(246,192,3,0.5)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                </svg>
            </div>

            <div class="flex items-center justify-center gap-2">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white font-display uppercase">
                    E-Solutions
                </h1>
                <span class="px-2 py-0.5 text-[10px] font-bold tracking-wider text-amberEnergy-400 bg-amberEnergy-400/10 border border-amberEnergy-400/30 rounded-md uppercase">
                    ESG Tech
                </span>
            </div>

            <p class="mt-2 text-xs sm:text-sm text-slate-300 font-medium">
                Nieuwe gebruiker of installateur registreren
            </p>
        </div>

        <!-- General Error Alert -->
        @if ($errors->any())
            <div class="mb-5 p-4 rounded-2xl bg-red-950/80 border border-red-500/50 text-red-200 text-sm shadow-lg">
                <div class="flex items-center gap-2 font-semibold mb-1">
                    <svg class="w-4 h-4 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Controleer de volgende punten:
                </div>
                <ul class="list-disc list-inside text-xs space-y-0.5 text-red-300">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Registration Card -->
        <div class="bg-[#002D34]/90 backdrop-blur-md rounded-3xl shadow-2xl shadow-black/50 border border-[#004D57]/70 p-7 sm:p-9 transition-all relative">
            <form action="{{ route('register.custom') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Naam input -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Volledige naam / Bedrijfsnaam
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5 text-amberEnergy-500/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="bijv. Kees van Vliet"
                            required
                            autocomplete="name"
                            class="block w-full pl-11 pr-4 py-2.5 bg-[#001E23]/80 border @error('name') border-red-500 focus:border-red-400 @else border-[#004953] focus:border-amberEnergy-400 @enderror rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-amberEnergy-400/20 transition duration-150"
                        >
                    </div>
                    @error('name')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- E-mail input -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Zakelijk E-mailadres
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5 text-amberEnergy-500/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                            </svg>
                        </div>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="kees@bedrijf.nl"
                            required
                            autocomplete="email"
                            class="block w-full pl-11 pr-4 py-2.5 bg-[#001E23]/80 border @error('email') border-red-500 focus:border-red-400 @else border-[#004953] focus:border-amberEnergy-400 @enderror rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-amberEnergy-400/20 transition duration-150"
                        >
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Wachtwoord input -->
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Wachtwoord
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5 text-amberEnergy-500/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Minimaal 6 tekens"
                            required
                            autocomplete="new-password"
                            class="block w-full pl-11 pr-4 py-2.5 bg-[#001E23]/80 border @error('password') border-red-500 focus:border-red-400 @else border-[#004953] focus:border-amberEnergy-400 @enderror rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-amberEnergy-400/20 transition duration-150"
                        >
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror

                    <!-- Password strength bar -->
                    <div class="mt-2 flex items-center gap-1.5">
                        <div class="h-1 flex-1 bg-[#001E23] rounded-full overflow-hidden">
                            <div id="strengthBar1" class="h-full bg-slate-700 transition-all duration-300"></div>
                        </div>
                        <div class="h-1 flex-1 bg-[#001E23] rounded-full overflow-hidden">
                            <div id="strengthBar2" class="h-full bg-slate-700 transition-all duration-300"></div>
                        </div>
                        <div class="h-1 flex-1 bg-[#001E23] rounded-full overflow-hidden">
                            <div id="strengthBar3" class="h-full bg-slate-700 transition-all duration-300"></div>
                        </div>
                        <span id="strengthText" class="text-[11px] text-slate-400 pl-1 font-medium">Sterkte</span>
                    </div>
                </div>

                <!-- Voorwaarden akkoord -->
                <div class="flex items-start pt-1">
                    <input
                        type="checkbox"
                        id="terms"
                        name="terms"
                        required
                        class="w-4 h-4 mt-0.5 rounded text-amberEnergy-500 bg-[#001E23] border-[#004953] focus:ring-amberEnergy-400"
                    >
                    <label for="terms" class="ml-2.5 text-xs text-slate-300 leading-relaxed select-none">
                        Ik ga akkoord met de <a href="#" class="text-amberEnergy-400 underline hover:text-amberEnergy-300">algemene voorwaarden</a> van E-Solutions / ESG Tech.
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full mt-2 flex items-center justify-center py-3.5 px-4 rounded-xl text-slate-950 font-bold text-sm bg-gradient-to-r from-amberEnergy-400 via-amberEnergy-500 to-amberEnergy-400 hover:brightness-105 shadow-lg shadow-amberEnergy-500/20 active:scale-[0.99] transition duration-150 group cursor-pointer"
                >
                    <span>Account Registreren</span>
                    <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- Terug naar Login Link -->
        <p class="text-center text-sm text-slate-400 mt-6">
            Heb je al een account bij E-Solutions?
            <a href="{{ route('login') }}" class="font-bold text-amberEnergy-400 hover:text-amberEnergy-300 hover:underline">
                Log direct in
            </a>
        </p>

        <!-- Footer Note -->
        <div class="mt-8 text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} E-Solutions / ESG Tech BV &bull; Grondig, Grenzeloos
        </div>
    </div>

    <!-- Password strength indicator script -->
    <script>
        const pwd = document.getElementById('password');
        const b1 = document.getElementById('strengthBar1');
        const b2 = document.getElementById('strengthBar2');
        const b3 = document.getElementById('strengthBar3');
        const txt = document.getElementById('strengthText');

        if (pwd) {
            pwd.addEventListener('input', () => {
                const val = pwd.value;
                let score = 0;
                if (val.length >= 6) score++;
                if (val.length >= 8 && /[A-Z]/.test(val) && /[0-9]/.test(val)) score++;
                if (val.length >= 10 && /[^A-Za-z0-9]/.test(val)) score++;

                b1.className = 'h-full transition-all duration-300 ' + (score >= 1 ? 'bg-amber-400' : 'bg-slate-700');
                b2.className = 'h-full transition-all duration-300 ' + (score >= 2 ? 'bg-emerald-400' : 'bg-slate-700');
                b3.className = 'h-full transition-all duration-300 ' + (score >= 3 ? 'bg-emerald-500' : 'bg-slate-700');

                if (val.length === 0) {
                    txt.innerText = 'Sterkte';
                    txt.className = 'text-[11px] text-slate-400 pl-1 font-medium';
                } else if (score === 1) {
                    txt.innerText = 'Zwak';
                    txt.className = 'text-[11px] text-amber-400 pl-1 font-semibold';
                } else if (score === 2) {
                    txt.innerText = 'Matig';
                    txt.className = 'text-[11px] text-emerald-400 pl-1 font-semibold';
                } else if (score === 3) {
                    txt.innerText = 'Sterk';
                    txt.className = 'text-[11px] text-emerald-300 pl-1 font-semibold';
                }
            });
        }
    </script>
</body>
</html>
