<?php

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it shows a single post', function () {
    $profile = Profile::factory()->create();

    $post = Post::factory()->create(['profile_id' => $profile->id]);

    $this->actingAs($profile->user);

    visit(route('posts.index'))
        ->click('@visit-post-link')
        ->assertSee($post->content);
});