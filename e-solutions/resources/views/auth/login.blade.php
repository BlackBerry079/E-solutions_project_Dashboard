@php $errors = $errors ?? new \Illuminate\Support\ViewErrorBag; @endphp
<!DOCTYPE html>
<html lang="nl" class="h-full bg-[#00282E]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inloggen | E-Solutions &bull; Duurzame Energie & Laadsystemen</title>

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
        <div class="absolute -top-40 right-1/4 w-[500px] h-[500px] bg-[#00464F]/50 rounded-full blur-[130px]"></div>
        <div class="absolute -bottom-40 left-1/4 w-[550px] h-[550px] bg-amberEnergy-500/10 rounded-full blur-[140px]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#00464F_1px,transparent_1px)] [background-size:24px_24px] opacity-25"></div>
    </div>

    <div class="w-full max-w-md my-6">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-[#00373E] via-[#00464F] to-[#04616D] text-amberEnergy-400 shadow-xl shadow-[#001E22]/60 mb-4 border border-amberEnergy-500/40 ring-4 ring-[#001A1D]/60 relative">
                <svg class="w-8 h-8 drop-shadow-[0_2px_8px_rgba(246,192,3,0.5)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                </svg>
                <!-- Small status dot -->
                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
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
                Duurzame Energie &bull; Slimme Laadpleinen &bull; Krachtpatsers
            </p>
        </div>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="mb-5 p-4 rounded-2xl bg-emerald-950/80 border border-emerald-500/50 text-emerald-200 text-sm flex items-center gap-3 shadow-lg">
                <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- General Error Alert -->
        @if (session('error'))
            <div class="mb-5 p-4 rounded-2xl bg-red-950/80 border border-red-500/50 text-red-200 text-sm flex items-center gap-3 shadow-lg">
                <svg class="w-5 h-5 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Login Card -->
        <div class="bg-[#002D34]/90 backdrop-blur-md rounded-3xl shadow-2xl shadow-black/50 border border-[#004D57]/70 p-7 sm:p-9 transition-all relative">
            <form action="{{ route('login.custom') }}" method="POST" class="space-y-5">
                @csrf

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
                            value="{{ old('email', 'demo@esolutions.nl') }}"
                            placeholder="naam@esg-tech.nl"
                            required
                            autocomplete="email"
                            class="block w-full pl-11 pr-4 py-3 bg-[#001E23]/80 border @error('email') border-red-500 focus:border-red-400 @else border-[#004953] focus:border-amberEnergy-400 @enderror rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-amberEnergy-400/20 transition duration-150"
                        >
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Wachtwoord input -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                            Wachtwoord
                        </label>
                        <a href="#" class="text-xs font-semibold text-amberEnergy-400 hover:text-amberEnergy-300 transition">
                            Wachtwoord vergeten?
                        </a>
                    </div>
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
                            value="password123"
                            placeholder="••••••••••••"
                            required
                            autocomplete="current-password"
                            class="block w-full pl-11 pr-11 py-3 bg-[#001E23]/80 border @error('password') border-red-500 focus:border-red-400 @else border-[#004953] focus:border-amberEnergy-400 @enderror rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-amberEnergy-400/20 transition duration-150"
                        >
                        <button
                            type="button"
                            id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-amberEnergy-400 focus:outline-none transition"
                            aria-label="Wachtwoord weergeven"
                        >
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Onthoud mij -->
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        class="w-4 h-4 rounded text-amberEnergy-500 bg-[#001E23] border-[#004953] focus:ring-amberEnergy-400"
                    >
                    <label for="remember" class="ml-2.5 text-xs text-slate-300 select-none">
                        Onthoud mijn sessie op dit apparaat
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full flex items-center justify-center py-3.5 px-4 rounded-xl text-slate-950 font-bold text-sm bg-gradient-to-r from-amberEnergy-400 via-amberEnergy-500 to-amberEnergy-400 hover:brightness-105 shadow-lg shadow-amberEnergy-500/20 active:scale-[0.99] transition duration-150 group cursor-pointer"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" fill="currentColor"></polygon>
                    </svg>
                    <span>Inloggen</span>
                    <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>

            <!-- Bottom Tech badges -->
            <div class="mt-6 pt-5 border-t border-[#00434C] flex items-center justify-between text-[11px] text-slate-400">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Laadportaal actief
                </span>
                <span>Regio Dordrecht &bull; DaVinci</span>
            </div>
        </div>

        <!-- Registration Link -->
        <p class="text-center text-sm text-slate-400 mt-6">
            Nog geen E-Solutions account?
            <a href="{{ route('registration') }}" class="font-bold text-amberEnergy-400 hover:text-amberEnergy-300 hover:underline">
                Meld je hier aan
            </a>
        </p>

        <!-- Footer Note -->
        <div class="mt-8 text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} E-Solutions / ESG Tech BV &bull; Grondig, Grenzeloos
        </div>
    </div>

    <!-- Toggle Password Visibility Script -->
    <script>
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (toggleBtn && passwordInput) {
            toggleBtn.addEventListener('click', () => {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';

                if (isPassword) {
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    `;
                } else {
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `;
                }
            });
        }
    </script>
</body>
</html>
