<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::get('/dev/login', function () {
    $user = User::inRandomOrder()->first();

    Auth::login($user);
    request()->session()->regenerate();

    return redirect()->intended(route('profiles.show', $user->profile));
})->name('dev.login');

Route::get('/dev/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->intended('/feed');
})->name('dev.logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::scopeBindings()->group(function () {
        Route::post(
            '/{profile:handle}/post/{post}/reply',
            [PostController::class, 'reply']
        )->name('posts.reply');

        Route::post(
            '/{profile:handle}/post/{post}/repost',
            [PostController::class, 'repost']
        )->name('posts.repost');

        Route::post(
            '/{profile:handle}/post/{post}/destroy',
            [PostController::class, 'destroy']
        )->name('posts.destroy');

        Route::post(
            '/{profile:handle}/post/{post}/quote',
            [PostController::class, 'quote']
        )->name('posts.quote');

        Route::post(
            '/{profile:handle}/post/{post}/like',
            [PostController::class, 'like']
        )->name('posts.like');

        Route::post(
            '/{profile:handle}/post/{post}/unlike',
            [PostController::class, 'unlike']
        )->name('posts.unlike');
    });

    Route::post('/{profile:handle}/follow', [ProfileController::class, 'follow'])->name('profiles.follow');
    Route::post('/{profile:handle}/unfollow', [ProfileController::class, 'unfollow'])->name('profiles.unfollow');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profiles.update');
});

Route::get('/register', [AuthController::class, 'create'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register');

Route::get('/login', [SessionsController::class, 'create'])->name('login');
Route::post('/login', [SessionsController::class, 'store'])->name('login');

Route::delete('/logout', [SessionsController::class, 'destroy'])->name('logout');

Route::get('/{profile:handle}', [ProfileController::class, 'show'])->name('profiles.show');
Route::get('/{profile:handle}/replies', [ProfileController::class, 'replies'])->name('profiles.replies');
Route::scopeBindings()->group(function () {
    Route::get('/{profile:handle}/post/{post}', [PostController::class, 'show'])->name('posts.show');
});
