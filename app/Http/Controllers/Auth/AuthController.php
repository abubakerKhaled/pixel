<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3', 'trim'],
            'handle' => ['required', 'string', 'max:255', 'min:3', 'trim', 'unique:profiles', 'handle'],
            'email' => ['required', 'email', 'max:255', 'unique:users', 'trim'],
            'password' => ['required', 'string', 'max:255', 'min:8', 'trim', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'max:255', 'min:8', 'trim'],
        ]);

        $user = User::create([
            'name' => $validated('name'),
            'email' => $validated('email'),
            'password' => Hash::make($validated('password')),
        ]);

        $profile = Profile::create([
            'user_id' => $user->id,
            'handle' => $validated('handle'),
        ]);

        Auth::login($user);
        request()->session()->regenerate();

        return redirect()->intended(route('profiles.show', $profile));
    }
}
