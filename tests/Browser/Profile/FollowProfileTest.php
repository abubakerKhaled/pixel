<?php

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a user can follow another profile', function () {
    $profile = Profile::factory()->create();

    $otherProfile = Profile::factory()->create();

    $this->actingAs($profile->user);

    visit(route('profiles.show', $otherProfile))
        ->click('@follow-button')
        ->assertSee('You are now following');
});