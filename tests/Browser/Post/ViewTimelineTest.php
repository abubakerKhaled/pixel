<?php

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated users can view their timeline', function () {
    $profile = Profile::factory()->create();

    $otherProfile = Profile::factory()->create();

    Post::factory(2)->create(['profile_id' => $otherProfile->id]);

    Post::factory()->create(['profile_id' => $profile->id]);

    $profile->follow($otherProfile);

    $this->actingAs($profile->user);

    $page = visit(route('posts.index'));
    
    $page->assertCount('@post-feed-item', 3);
});