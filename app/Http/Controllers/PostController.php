<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use App\Querys\PostThreadQuery;
use App\Querys\TimelineQuery;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(): Response
    {
        $profile = Auth::user()->profile;

        $posts = TimelineQuery::forViewer($profile)->get();

        return Inertia::render('Posts/Index', [
            'posts' => PostResource::collection($posts),
        ]);
    }

    public function show(Profile $profile, Post $post): Response
    {
        $post = PostThreadQuery::for($post, Auth::user()?->profile)->load();

        return Inertia::render('Posts/Show', [
            'post' => new PostResource($post),
        ]);
    }

    public function store(CreatePostRequest $createPostRequest): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $profile = Auth::user()->profile;

        Post::publish($profile, $createPostRequest->validated()['content']);

        return redirect(route('posts.index'));
    }

    public function reply(CreatePostRequest $createPostRequest, Profile $profile, Post $post): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $currentProfile = Auth::user()->profile;

        Post::reply($currentProfile, $post, $createPostRequest->validated()['content']);

        return redirect(route('posts.index'));
    }

    public function repost(Profile $profile, Post $post): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $currentProfile = Auth::user()->profile;

        Post::repost($currentProfile, $post);

        return redirect(route('posts.index'));
    }

    public function quote(CreatePostRequest $createPostRequest, Profile $profile, Post $post): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $currentProfile = Auth::user()->profile;

        Post::repost($currentProfile, $post, $createPostRequest->validated()['content']);

        return redirect(route('posts.index'));
    }

    public function like(Profile $profile, Post $post)
    {
        $currentProfile = Auth::user()->profile;

        $like = Like::createLike($currentProfile, $post);

        return response()->json(['like' => $like]);
    }

    public function unlike(Profile $profile, Post $post)
    {
        $currentProfile = Auth::user()->profile;

        $success = Like::removeLike($currentProfile, $post);

        return response()->json(['success' => $success]);
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
