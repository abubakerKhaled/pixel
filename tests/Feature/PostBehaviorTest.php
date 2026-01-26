<?php

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses(RefreshDatabase::class);


test('it allows a profile to publish a post', function(){
    $profile = Profile::factory()->create();

    $post = Post::publish($profile, 'Hello World');

    expect($post->exists())->toBeTrue();
    expect($post->profile->is($profile))->toBeTrue();
    expect($post->parent_id)->toBeNull();
    expect($post->repost_of_id)->toBeNull();
});