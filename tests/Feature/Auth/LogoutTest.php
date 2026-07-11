<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\delete;

uses(RefreshDatabase::class);

test('authenticated user can log out', function () {
    $user = User::factory()->create();

    $response = actingAs($user)
        ->delete(route('logout'));

    assertGuest();
    $response->assertRedirect('/');
});

test('guest log out is handled gracefully', function () {
    $response = delete(route('logout'));

    assertGuest();
    $response->assertRedirect('/');
});
