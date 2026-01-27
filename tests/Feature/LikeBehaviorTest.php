<?php

use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses(RefreshDatabase::class);


test('profile can like a post', function () {
    $profile = Profile::factory()->create();
    $post = Post::factory()->create();

    $like = Like::createLike($profile, $post);

    expect($profile->likes)->toHaveCount(1);
    expect($profile->likes->contains($like))->toBeTrue();

    expect($post->likes)->toHaveCount(1);
    expect($post->likes->contains($like))->toBeTrue();

    expect($like->post->is($post))->toBeTrue();
    expect($like->profile->is($profile))->toBeTrue();
});


test('prevents duplicate likes', function() {
    $profile = Profile::factory()->create();
    $post = Post::factory()->create();

    $l1 = Like::createLike($profile, $post);
    $l2 = Like::createLike($profile, $post);

    expect($l1->id)->toBe($l2->id);
});

test('remove a like', function() {
    $profile = Profile::factory()->create();
    $post = Post::factory()->create();

    $like = Like::createLike($profile, $post);

    $success = Like::removeLike($profile, $post);

    // Verify it's gone
    expect($profile->likes)->toHaveCount(0);
    expect($profile->likes->contains($like))->toBeFalse();
    expect($post->likes)->toHaveCount(0);
    expect($post->likes->contains($like))->toBeFalse();
    expect($success)->toBeTrue();
});