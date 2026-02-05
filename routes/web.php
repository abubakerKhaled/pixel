<?php

use App\Http\Controllers\ProfileController;
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
            'replayCount' => 22,
            'repostCount' => 132,
        ],
    ];

    $replies = [
        [
            'profile' => [
                'displayName' => 'Simon',
                'handle' => 'simonswiss',
                'avatar' => '/images/simon-chilling.png',
            ],
            'postedAgo' => '3', // we will compute it from the date it was published at
            'content' => <<<'str'
                <p>Heh — this looks just like me!</p>
            str,
            'likeCount' => 54,
            'replayCount' => 97,
            'repostCount' => 45,
        ],
    ];

    $feedItems = json_decode(json_encode($feedItems));
    $replies = json_decode(json_encode($replies));

    return view('feed', compact(['feedItems', 'replies']));
});

Route::get('/{profile:handle}', [ProfileController::class, 'show'])->name('profiles.show');
Route::get('/{profile:handle}/with-replies', [ProfileController::class, 'replies'])->name('profiles.replies');
