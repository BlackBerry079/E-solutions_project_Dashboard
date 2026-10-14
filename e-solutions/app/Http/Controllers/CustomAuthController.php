<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Device;
use App\Models\Telemetry;

class CustomAuthController extends Controller
{
    /**
     * Toon het inlogformulier
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Toon het inlogformulier (alias)
     */
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Verwerk inlogverzoek
     */
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Vul een geldig e-mailadres in.',
            'email.email' => 'Het ingevoerde e-mailadres is niet geldig.',
            'password.required' => 'Vul je wachtwoord in.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')
                ->with('success', 'Welkom terug! Je bent succesvol ingelogd.');
        }

        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'De ingevoerde gegevens zijn niet correct. Controleer je e-mail en wachtwoord.']);
    }

    /**
     * Toon het registratieformulier
     */
    public function registration()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.registration');
    }

    /**
     * Verwerk registratieverzoek
     */
    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:6',
        ], [
            'name.required' => 'Vul je naam in.',
            'email.required' => 'Vul een geldig e-mailadres in.',
            'email.unique' => 'Dit e-mailadres is al in gebruik.',
            'password.required' => 'Vul een wachtwoord in.',
            'password.min' => 'Het wachtwoord moet minimaal 6 tekens bevatten.',
        ]);

        $data = $request->all();
        $this->create($data);

        return redirect()->route('login')
            ->with('success', 'Je account is succesvol aangemaakt! Je kunt nu inloggen.');
    }

    /**
     * Maak een nieuwe gebruiker aan
     */
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Toon het dashboard (Open systeem: data openbaar inzichtelijk, aanpassingen vereisen Admin)
     */
    public function dashboard()
    {
        $devices = Device::all();
        $telemetryLogs = Telemetry::latest('created_at')->limit(8)->get();
        $allUsers = (Auth::check() && Auth::user()->is_admin) ? User::latest()->get() : collect();

        return view('dashboard', compact('devices', 'telemetryLogs', 'allUsers'));
    }

    /**
     * Uitloggen en sessie beëindigen
     */
    public function signOut(Request $request)
    {
        Session::flush();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Je bent succesvol uitgelogd.');
    }
}
