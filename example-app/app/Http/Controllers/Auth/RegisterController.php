<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        //register logic

        $request->validate([
            'name' => 'required|string|max:15',
            'email' => 'required|string|email|unique:users|max:40',
            'password' => 'required|confirmed|min:6|max:40'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email, 
            'password' => Hash::make($request->password)
        ]);

        // Auth::login($user);
        // Session::forget(['name', 'email', 'password']);

        return redirect('/')->with('success', 'Partner registration successful.');
    }
}


