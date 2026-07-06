<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $profile = Profile::create([
            'user_id' => $user->id,
            'handle' => $validated['handle'],
            'display_name' => $validated['name'],
            'avatar_url' => 'https://i.pravatar.cc/300?u='.$validated['handle'],
            'cover_url' => 'https://dummyimage.com/1400x640/333/f76a00?text='.$validated['handle'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('profiles.show', $profile));
    }
}
