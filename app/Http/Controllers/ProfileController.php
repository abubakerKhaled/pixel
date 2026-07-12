<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\ProfileResource;
use App\Models\Follow;
use App\Models\Profile;
use App\Querys\ProfilePageQuery;
use App\Querys\ProfileWithRepliesQuery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        Follow::createFollow($currentProfile, $profile);

        return back()->with('success', "You are now following @{$profile->handle}");
    }

    public function unfollow(Profile $profile)
    {
        $currentProfile = Auth::user()->profile;

        Follow::removeFollow($currentProfile, $profile);

        return back()->with('success', "You have unfollowed @{$profile->handle}");
    }

    public function edit(Request $request): Response
    {
        $profile = $request->user()->profile;

        return Inertia::render('Profile/Edit', [
            'profile' => $profile,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $profile = $request->user()->profile;

        $validated = $request->validated();

        $profile->user->update([
            'name' => $validated['name'],
        ]);

        $profile->update([
            'display_name' => $validated['name'],
            'handle' => $validated['handle'],
            'bio' => $validated['bio'],
        ]);

        return redirect()->route('profiles.show', $profile);
    }
}
