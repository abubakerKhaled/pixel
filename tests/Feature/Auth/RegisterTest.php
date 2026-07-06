<?php

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

test('guest can view the registration page', function () {
    $response = get(route('register'));

    $response->assertStatus(200);
});

test('guest can register with valid data', function () {
    $response = post(route('register'), [
        'name' => 'John Doe',
        'handle' => 'johndoe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $user = User::where('email', 'john@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->name)->toBe('John Doe');

    $profile = Profile::where('user_id', $user->id)->first();
    expect($profile)->not->toBeNull();
    expect($profile->handle)->toBe('johndoe');
    expect($profile->display_name)->toBe('John Doe');
    expect($profile->avatar_url)->toBe('https://i.pravatar.cc/300?u=johndoe');
    expect($profile->cover_url)->toBe('https://dummyimage.com/1400x640/333/f76a00?text=johndoe');

    assertAuthenticatedAs($user);
    $response->assertRedirect(route('profiles.show', $profile));
});

test('registration validation fails for short name', function () {
    $response = post(route('register'), [
        'name' => 'Jo',
        'handle' => 'johndoe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('registration validation fails for duplicate handle', function () {
    Profile::factory()->create(['handle' => 'existinghandle']);

    $response = post(route('register'), [
        'name' => 'John Doe',
        'handle' => 'existinghandle',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors(['handle']);
});

test('registration validation fails for duplicate email', function () {
    User::factory()->create(['email' => 'duplicate@example.com']);

    $response = post(route('register'), [
        'name' => 'John Doe',
        'handle' => 'johndoe',
        'email' => 'duplicate@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors(['email']);
});

test('registration validation fails for mismatched password confirmation', function () {
    $response = post(route('register'), [
        'name' => 'John Doe',
        'handle' => 'johndoe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'different_password',
    ]);

    $response->assertSessionHasErrors(['password']);
});
