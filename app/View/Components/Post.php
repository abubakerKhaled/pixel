<?php

namespace App\View\Components;

use App\Models\Post as PostModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Post extends Component
{
    private PostModel $original;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public PostModel $post,
        public bool $showEngagement = true,
        public bool $showReplies = false,
    ) {
        $this->original = $post;

        // For pure reposts (no content), display the reposted post
        if ($post->isRepost() && is_null($post->content)) {
            $this->post = $post->repostOf;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post');
    }
}
