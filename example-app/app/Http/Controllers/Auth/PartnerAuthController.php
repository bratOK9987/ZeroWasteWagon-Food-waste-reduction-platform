<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerAuthController extends Controller
{
    // Show the partner login form
    public function showLoginForm()
    {
        return view('partner_login');
    }

    // Handle login request for partners
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Attempt to log in the partner
    if (Auth::guard('partner')->attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();

        // Ensure the partner is really authenticated
        if (!Auth::guard('partner')->check()) {
            return back()->withErrors([
                'email' => 'Authentication failed, please try again.',
            ])->withInput($request->except('password'));
        }

        return redirect()->intended('/partner/dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->withInput($request->except('password'));
}
}

