<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\ProfileResource;
use App\Models\Follow;
use App\Models\Profile;
use App\Querys\ProfilePageQuery;
use App\Querys\ProfileWithRepliesQuery;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function show(Profile $profile): Response
    {
        $profile->loadCount(['following', 'followers']);

        $posts = ProfilePageQuery::for($profile, Auth::user()?->profile)->get();

        return Inertia::render('Profiles/Show', [
            'profile' => new ProfileResource($profile),
            'posts' => PostResource::collection($posts),
        ]);
    }

    public function replies(Profile $profile): Response
    {
        $profile->loadCount(['following', 'followers']);

        $posts = ProfileWithRepliesQuery::for($profile, Auth::user()?->profile)->get();

        return Inertia::render('Profiles/Replies', [
            'profile' => new ProfileResource($profile),
            'posts' => PostResource::collection($posts),
        ]);
    }

    public function follow(Profile $profile)
    {
        $currentProfile = Auth::user()->profile;

        $follow = Follow::createFollow($currentProfile, $profile);

        return response()->json(['follow' => $follow]);
    }

    public function unfollow(Profile $profile)
    {
        $currentProfile = Auth::user()->profile;

        $success = Follow::removeFollow($currentProfile, $profile);

        return response()->json(['success' => $success]);
    }
}
