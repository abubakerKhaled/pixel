<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

test('guest can view the login page', function () {
    $response = get(route('login'));

    $response->assertStatus(200);
});

test('guest can log in with valid credentials', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    $response = post(route('login'), [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    assertAuthenticatedAs($user);
    $response->assertRedirect(route('posts.index'));
});

test('login fails with invalid credentials', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    $response = post(route('login'), [
        'email' => $user->email,
        'password' => 'wrong_password',
    ]);

    assertGuest();
    $response->assertSessionHasErrors(['email']);
});
