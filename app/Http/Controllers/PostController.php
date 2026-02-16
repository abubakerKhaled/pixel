<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use App\Models\Like;
use App\Models\Profile;
use App\Querys\TimelineQuery;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $profile = Auth::user()->profile;

        $posts = TimelineQuery::forViewer($profile)->get();

        return view('posts.index', compact('profile', 'posts'));
    }

    public function show(Profile $profile, Post $post)
    {
        $post->load([
            'replies' => fn($q) => $q
                ->withCount(['likes', 'replies', 'reposts'])
                ->with([
                    'profile',
                    'parent.profile',
                    'replies' => fn($q) => $q
                        ->withCount(['likes', 'replies', 'reposts'])
                        ->with(['profile', 'parent.profile'])
                        ->oldest(),
                ])
                ->oldest(),
        ])->loadCount(['likes', 'replies', 'reposts']);

        return view('posts.show', compact('post'));
    }

    public function store(CreatePostRequest $request)
    {
        $profile = Auth::user()->profile;

        $post = Post::publish($profile, $request->validated()['content']);

        return redirect(route('posts.index'));
    }

    public function reply(CreatePostRequest $request, Profile $profile, Post $post)
    {
        $currentProfile = Auth::user()->profile;

        $post = Post::reply($currentProfile, $post, $request->validated()['content']);

        return redirect(route('posts.index'));
    }

    public function repost(Profile $profile, Post $post)
    {
        $currentProfile = Auth::user()->profile;

        $post = Post::repost($currentProfile, $post);

        return redirect(route('posts.index'));
    }

    public function quote(CreatePostRequest $request, Profile $profile, Post $post)
    {
        $currentProfile = Auth::user()->profile;

        $post = Post::repost($currentProfile, $post, $request->validated()['content']);

        return redirect(route('posts.index'));
    }

    public function like(Profile $profile, Post $post)
    {
        $currentProfile = Auth::user()->profile;

        $like = Like::createLike($currentProfile, $post);

        return response()->json(compact('like'));
    }

    public function unlike(Profile $profile, Post $post)
    {
        $currentProfile = Auth::user()->profile;

        $success = Like::removeLike($currentProfile, $post);

        return response()->json(compact('success'));
    }

    public function destroy(Post $post)
    {
        $currentProfile = Auth::user()->profile;

        if ($post->profile->id !== $currentProfile->id) {
            abort(403, 'Unauthorized');
        }

        $post->delete();
        return response()->json(['success' => true]);
    }
}
