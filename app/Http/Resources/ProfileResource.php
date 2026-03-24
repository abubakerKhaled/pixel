<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'handle' => $this->handle,
            'display_name' => $this->display_name,
            'bio' => $this->bio,
            'avatar_url' => $this->avatar_url,
            'cover_url' => $this->cover_url,
            'user_id' => $this->user_id,

            // Only included when withCount() was used in the query
            'followers_count' => $this->whenCounted('followers'),
            'following_count' => $this->whenCounted('following'),
            'posts_count' => $this->whenCounted('posts'),

            // Only included when appended by the controller
            'is_following' => $this->when(
                $this->resource->relationLoaded('followers') || isset($this->resource->getAttributes()['is_following']),
                fn () => $this->is_following ?? false
            ),
        ];
    }
}
