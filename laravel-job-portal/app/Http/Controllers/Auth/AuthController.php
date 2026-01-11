<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\CandidateProfile;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (!$user->isActive()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Twoje konto zostało zablokowane.',
                ]);
            }

            return $this->redirectToDashboard($user);
        }

        return back()->withErrors([
            'email' => 'Nieprawidłowe dane logowania.',
        ])->onlyInput('email');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'account_type' => 'required|in:kandydat,pracodawca',
            // For employer
            'nazwa_firmy' => 'required_if:account_type,pracodawca|nullable|string|max:200',
        ]);

        $role = Role::where('nazwa', $validated['account_type'])->firstOrFail();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $role->id,
            'aktywny' => true,
        ]);

        // Create profile based on role
        if ($validated['account_type'] === 'kandydat') {
            CandidateProfile::create([
                'user_id' => $user->id,
            ]);
        } else {
            CompanyProfile::create([
                'user_id' => $user->id,
                'nazwa_firmy' => $validated['nazwa_firmy'],
            ]);
        }

        Auth::login($user);

        return $this->redirectToDashboard($user);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function redirectToDashboard(User $user): RedirectResponse
    {
        return match(true) {
            $user->isAdmin() => redirect()->route('admin.dashboard'),
            $user->isEmployer() => redirect()->route('employer.dashboard'),
            $user->isCandidate() => redirect()->route('candidate.dashboard'),
            default => redirect('/'),
        };
    }
}
