<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'content' => $this->content,
            'created_at' => $this->created_at,
            'created_at_human' => $this->created_at?->diffForHumans(),

            // Repost info
            'is_repost' => $this->repost_of_id !== null,
            'repost_of_id' => $this->repost_of_id,

            // Counts — only included when withCount() was used
            'likes_count' => $this->whenCounted('likes'),
            'replies_count' => $this->whenCounted('replies'),
            'reposts_count' => $this->whenCounted('reposts'),

            // Computed engagement state — set by the controller
            'has_liked' => $this->when(isset($this->resource->getAttributes()['has_liked']), fn () => (bool) $this->has_liked),
            'has_reposted' => $this->when(isset($this->resource->getAttributes()['has_reposted']), fn () => (bool) $this->has_reposted),

            // Relationships — only included when eager-loaded
            'profile' => new ProfileResource($this->whenLoaded('profile')),
            'repost_of' => new PostResource($this->whenLoaded('repostOf')),
            'replies' => PostResource::collection($this->whenLoaded('replies')),
        ];
    }
}
