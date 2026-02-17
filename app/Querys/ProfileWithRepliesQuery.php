<?php

namespace App\Querys;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProfileWithRepliesQuery
{
    public function __construct(private Profile $owner, private ?Profile $visitor) {}

    public static function for(Profile $owner, ?Profile $visitor): self
    {
        return new self($owner, $visitor);
    }

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return $this->baseQuery()->paginate($perPage)->through(fn ($p) => $this->normalize($p));
    }

    public function get(): Collection
    {
        return $this->baseQuery()->get()->map(fn ($p) => $this->normalize($p));
    }

    private function baseQuery(): Builder
    {
        $viewerId = $this->visitor?->id ?? 0;

        $posts = Post::query()
            ->where(fn ($q) => $q
                ->whereBelongsTo($this->owner, 'profile')
                ->whereNull('parent_id')
            )
            ->orWhereHas('replies', fn ($q) => $q
                ->whereBelongsTo($this->owner, 'profile')
            )
            ->with([
                'profile',
                'repostOf' => fn ($q) => $q
                    ->withCount(['likes', 'reposts', 'replies'])
                    ->with('profile'),
                'repostOf.profile',
                'parent.profile',
                'replies' => fn ($q) => $q
                    ->whereBelongsTo($this->owner, 'profile')
                    ->with('profile')
                    ->oldest(),
            ])
            ->withCount(['likes', 'reposts', 'replies'])
            ->withExists([
                'likes as has_liked' => fn ($q) => $q->where('profile_id', $viewerId),
                'reposts as has_reposted' => fn ($q) => $q->where('profile_id', $viewerId),
                'repostOf as like_original' => fn ($q) => $q->whereHas('likes', fn ($q) => $q->where('profile_id', $viewerId)),
                'repostOf as repost_original' => fn ($q) => $q->whereHas('reposts', fn ($q) => $q->where('profile_id', $viewerId)),
            ])
            ->latest();

        return $posts;
    }

    private function normalize(Post $post)
    {
        if ($post->isRepost() && is_null($post->content)) {
            $post->repostOf->has_liked = (bool) $post->like_original;
            $post->repostOf->has_reposted = (bool) $post->repost_original;
        }

        return $post;
    }
}
