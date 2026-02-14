<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Profile $profile): View
    {
        $profile->loadCount(['following', 'followers']);

        $posts = Post::query()
            ->where('profile_id', $profile->id)
            ->whereNull('parent_id')
            ->with([
                'profile',
                'repostOf' => fn ($query) => $query->withCount(['likes', 'reposts', 'replies']),
                'repostOf.profile',
            ])
            ->withCount(['likes', 'reposts', 'replies'])
            ->latest()
            ->get();

        return view('profiles.show', compact('profile', 'posts'));
    }

    public function replies(Profile $profile): View
    {
        $profile->loadCount(['following', 'followers']);

        $posts = Post::query()
            ->where(
                fn ($q) => $q
                    ->whereBelongsTo($profile, 'profile')
                    ->whereNull('parent_id')
            )
            ->orWhereHas(
                'replies',
                fn ($q) => $q
                    ->whereBelongsTo($profile, 'profile')
            )
            ->with([
                'profile',
                'repostOf' => fn ($q) => $q->withCount(['likes', 'reposts', 'replies']),
                'repostOf.profile',
                'parent.profile',
                'replies' => fn ($q) => $q
                    ->whereBelongsTo($profile, 'profile')
                    ->with('profile')
                    ->withCount(['likes', 'reposts', 'replies'])
                    ->oldest(),
            ])
            ->withCount(['likes', 'reposts', 'replies'])
            ->latest()
            ->get();

        return view('profiles.replies', compact('profile', 'posts'));
    }

    public function follow(Profile $profile)
    {
        $currentProfile = Auth::user()->profile;

        $follow = Follow::createFollow($currentProfile, $profile);

        return response()->json(compact('follow'));
    }
}
