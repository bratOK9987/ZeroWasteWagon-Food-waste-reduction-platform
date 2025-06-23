<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function finish()
    {
        return view('user_dashboard');
    }

    public function store(Request $request)
    {
        //register logic

        $request->validate([
            'email' => 'required|string|email|max:40',
            'password' => 'required|string|max:40'
        ]);

        if(Auth::attempt($request->only('email', 'password')))
        {
            return redirect()->route('dashboard');
        }

        // Auth::login($user);
        // Session::forget(['name', 'email', 'password']);

        return back()
            ->withInput()
            ->withErrors([
                'email' => 'This credentianls do not match our records.'
            ]);
    }
}
