<?php

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it likes a post', function () {
    $profile = Profile::factory()->create();

    $otherProfile = Profile::factory()->create();

    Post::factory()->create(['profile_id' => $otherProfile->id]);

    $profile->follow($otherProfile);

    $this->actingAs($profile->user);

    visit(route('posts.index'))
        ->click('@like-button')
        ->assertSeeIn('@like-post-count', '1');
});