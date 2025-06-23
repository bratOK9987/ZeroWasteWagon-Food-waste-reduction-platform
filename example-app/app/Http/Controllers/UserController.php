<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];

        $messages = [
            'name.required' => 'Your name is required.',
            'email.required' => 'An email address is required.',
            'email.email' => 'You must enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'A password is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('register')
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validated();

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect('/login')->with('success', 'Registration successful.');
    }

    public function account()
    {
        $user = Auth::user();
        return view('user_account', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'The provided password does not match your current password.',
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('user.account')->with('success', 'Password updated successfully.');
    }
}




// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Invitation;
// use App\Models\User;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Session;

// class UserController extends Controller
// {
//     public function showRegistrationForm()
//     {
//         return view('user_registration');
//     }

//     public function register(Request $request)
//     {
//         // Validate user input
//         $validatedData = $request->validate([
//             'user_name' => 'required',
//             'user_email' => 'required|email|unique:users,email',
//             'user_password' => 'required|min:6|confirmed',
//         ]);

//         // Create new user
//         $user = User::create([
//             'name' => $validatedData['user_name'],
//             'email' => $validatedData['user_email'],
//             'password' => bcrypt($validatedData['user_password']),
//         ]);

//         // Redirect user after registration
//         return redirect('/')->with('success', 'User registered successfully!');
//     }
// }


// class UserController extends Controller
// {
//     public function showUserRegistrationPage()
//     {
//         return view('user_regisration');
//     }

//     public function UserRegistration(Request $request)
//     {
//         $validatedData = $request->validate([
//             'user_name' => 'required|string|max:255',
//             'user_email' => 'required|string|email|max:255|unique:partners',
//             'user_password' => 'required|string|min:6|confirmed',
//         ]);

//         session($validatedData);
//         Partner::create([
//             'user_name' => $validatedData['user_name'],
//             'user_email' => $validatedData['user_email'],
//             'user_password' => Hash::make($validatedData['password']),
//         ]);

//         // Clear the session data related to registration
//         Session::forget(['user_name', 'user_email', 'user_password']);
//     }
// }



