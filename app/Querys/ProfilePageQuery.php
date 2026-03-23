<?php

declare(strict_types=1);

namespace App\Querys;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProfilePageQuery
{
    public function __construct(private Profile $owner, private ?Profile $visitor) {}

    public static function for(Profile $owner, ?Profile $visitor): self
    {
        return new self($owner, $visitor);
    }

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return $this->baseQuery()->paginate($perPage)->through(fn (\App\Models\Post $post) => $this->normalize($post));
    }

    public function get(): Collection
    {
        return $this->baseQuery()->get()->map(fn (\App\Models\Post $post) => $this->normalize($post));
    }

    private function baseQuery(): Builder
    {
        $viewerId = $this->visitor?->id ?? 0;

        return Post::query()
            ->where('profile_id', $this->owner->id)
            ->whereNull('parent_id')
            ->with([
                'repostOf' => fn ($q) => $q
                    ->withCount(['likes', 'reposts', 'replies'])
                    ->with('profile'),
            ])
            ->withCount(['likes', 'reposts', 'replies'])
            ->withExists([
                'likes as has_liked' => fn ($q) => $q->where('profile_id', $viewerId),
                'reposts as has_reposted' => fn ($q) => $q->where('profile_id', $viewerId),
                'repostOf as like_original' => fn ($q) => $q->whereHas('likes', fn ($q) => $q->where('profile_id', $viewerId)),
                'repostOf as repost_original' => fn ($q) => $q->whereHas('reposts', fn ($q) => $q->where('profile_id', $viewerId)),
            ])
            ->latest();
    }

    private function normalize(Post $post): Post
    {
        if ($post->isRepost() && is_null($post->content)) {
            $post->repostOf->has_liked = (bool) $post->like_original;
            $post->repostOf->has_reposted = (bool) $post->repost_original;
        }

        return $post;
    }
}
