<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/feed', function () {
    $feedItems = [
        [
            'profile' => [
                'displayName' => 'Michael',
                'handle' => 'mmich_jj',
                'avatar' => '/images/michael.png',
            ],
            'postedAgo' => '3', // we will compute it from the date it was published at
            'content' => <<<'str'
                <p>
                    I made this! <a href="#">#myartwork</a> <a href="#">#pixl</a>
                </p>
                <img src="/images/simon-chilling.png" alt="" />
            str,
            'likeCount' => 23,
            'replyCount' => 22,
            'repostCount' => 132
        ],
    ];

    $feedItems = json_decode(json_encode($feedItems));

    return view('feed', compact('feedItems'));
});

Route::get('/profile', function () {
    $feedItems = [
        [
            'profile' => [
                'displayName' => 'Michael',
                'handle' => 'mmich_jj',
                'avatar' => '/images/michael.png',
            ],
            'postedAgo' => '3', // we will compute it from the date it was published at
            'content' => <<<'str'
                <p>
                    I made this! <a href="#">#myartwork</a> <a href="#">#pixl</a>
                </p>
                <img src="/images/simon-chilling.png" alt="" />
            str,
            'likeCount' => 23,
            'replyCount' => 22,
            'repostCount' => 132
        ],
    ];

    $feedItems = json_decode(json_encode($feedItems));
    
    return view('profile', compact('feedItems'));
});
