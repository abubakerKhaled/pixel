<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\View\View;

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
}
