<?php

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses(RefreshDatabase::class);

test('guests cannot view or submit the edit profile form', function () {
    get(route('profiles.edit'))->assertRedirect(route('login'));
    put(route('profiles.update'), [])->assertRedirect(route('login'));
});

test('authenticated user can view their edit profile form', function () {
    $profile = Profile::factory()->create();

    actingAs($profile->user)
        ->get(route('profiles.edit'))
        ->assertStatus(200);
});

test('authenticated user can update profile with correct password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('correct_password'),
    ]);
    $profile = Profile::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = actingAs($user)->put(route('profiles.update'), [
        'name' => 'Updated Name',
        'handle' => 'updatedhandle',
        'bio' => 'Updated bio content',
        'password' => 'correct_password',
    ]);

    $response->assertRedirect(route('profiles.show', $profile->refresh()));

    expect($profile->refresh()->display_name)->toBe('Updated Name');
    expect($profile->handle)->toBe('updatedhandle');
    expect($profile->bio)->toBe('Updated bio content');
    expect($user->refresh()->name)->toBe('Updated Name');
});

test('profile update fails with incorrect password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('correct_password'),
    ]);
    $profile = Profile::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = actingAs($user)->put(route('profiles.update'), [
        'name' => 'Updated Name',
        'handle' => 'updatedhandle',
        'bio' => 'Updated bio content',
        'password' => 'wrong_password',
    ]);

    $response->assertSessionHasErrors(['password']);
});

test('profile update fails with duplicate handle', function () {
    $user = User::factory()->create([
        'password' => Hash::make('correct_password'),
    ]);
    $profile = Profile::factory()->create([
        'user_id' => $user->id,
    ]);

    // Create another profile with the taken handle
    Profile::factory()->create([
        'handle' => 'takenhandle',
    ]);

    $response = actingAs($user)->put(route('profiles.update'), [
        'name' => 'Updated Name',
        'handle' => 'takenhandle',
        'bio' => 'Updated bio content',
        'password' => 'correct_password',
    ]);

    $response->assertSessionHasErrors(['handle']);
});

test('user can keep their own handle when updating profile', function () {
    $user = User::factory()->create([
        'password' => Hash::make('correct_password'),
    ]);
    $profile = Profile::factory()->create([
        'user_id' => $user->id,
        'handle' => 'myownhandle',
    ]);

    $response = actingAs($user)->put(route('profiles.update'), [
        'name' => 'Updated Name',
        'handle' => 'myownhandle',
        'bio' => 'Updated bio content',
        'password' => 'correct_password',
    ]);

    $response->assertRedirect(route('profiles.show', $profile->refresh()));
    expect($profile->refresh()->handle)->toBe('myownhandle');
});
