<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $user = \App\Models\User::where('employee_id', $request->employee_id)
            ->where('role', ucfirst($request->role))
            ->first();

        if (!$user) {
            return redirect()->back()->withErrors([
                'employee_id' => 'These credentials do not match our records.',
            ])->withInput();
        }

        if (ucfirst($request->role) === 'Admin') {
            if (!Hash::check($request->password, $user->password)) {
                return redirect()->back()->withErrors([
                    'password' => 'Incorrect password.',
                ])->withInput();
            }
        }

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
