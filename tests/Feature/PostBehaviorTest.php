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

test('can reply to post', function(){
    $orginal = Post::factory()->create();

    $replier = Profile::factory()->create();
    $reply = Post::reply($replier, $orginal, 'This is a reply');

    expect($reply->parent->is($orginal))->toBeTrue();
    expect($orginal->replies)->toHaveCount(1);
});


test('can have many replies', function(){
    $orginal = Post::factory()->create();

    $replies = Post::factory()->count(4)->reply($orginal)->create();

    expect($replies->first()->parent->is($orginal))->toBeTrue();
    expect($orginal->replies)->toHaveCount(4);
    expect($orginal->replies->contains($replies->first()))->toBeTrue();
});
