<?php

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses(RefreshDatabase::class);

// publish testing
test('it allows a profile to publish a post', function(){
    $profile = Profile::factory()->create();

    $post = Post::publish($profile, 'Hello World');

    expect($post->exists())->toBeTrue();
    expect($post->profile->is($profile))->toBeTrue();
    expect($post->parent_id)->toBeNull();
    expect($post->repost_of_id)->toBeNull();
});

// reply testing
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

// repostt testing
test('create plain repost', function(){
    $orginal = Post::factory()->create();

    $reposter = Profile::factory()->create();
    $repost = Post::repost($reposter, $orginal);

    expect($repost->repostOf->is($orginal))->toBeTrue();
    expect($orginal->reposts)->toHaveCount(1);
    expect($repost->content)->toBeNull();
});


test('can have many reposts', function(){
    $orginal = Post::factory()->create();

    $reposts = Post::factory()->count(4)->repost($orginal)->create();

    expect($reposts->first()->repostOf->is($orginal))->toBeTrue();
    expect($orginal->reposts)->toHaveCount(4);
    expect($orginal->reposts->contains($reposts->first()))->toBeTrue();
});

// quote testing
test('create plain quote', function(){
    $quote = 'this is a quote';
    $orginal = Post::factory()->create();

    $reposter = Profile::factory()->create();
    $quote = Post::repost($reposter, $orginal, $quote);

    expect($quote->repostOf->is($orginal))->toBeTrue();
    expect($orginal->reposts)->toHaveCount(1);
    expect($quote->content === $quote);
});


// duplicate reposts
test('prevents duplicate reposts', function() {
    $original = Post::factory()->create();
    $profile = Profile::factory()->create();

    $r1 = Post::repost($profile, $original);
    $r2 = Post::repost($profile, $original);

    expect($r1->id)->toBe($r2->id);
});

// remove a repost
test('remove repost', function() {
    $original = Post::factory()->create();
    $repost = Post::factory()->repost($original)->create();

    $profile = $repost->profile;

    $success = Post::removeRepost($profile, $original);

    expect($original->reposts)->toHaveCount(0);
    expect($success)->toBeTrue();
});
