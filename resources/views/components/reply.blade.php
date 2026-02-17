<li class="group/li relative flex items-start gap-4 pt-4">
    <!-- Line-through -->
    <div aria-hidden="true" class="bg-pixl-light/10 absolute top-0 left-5 h-full w-px group-last/li:h-4">
    </div>
    <a href="{{ route('profiles.show', $post->profile) }}" class="isolate shrink-0">
        <img src="{{ $post->profile->avatar_url }}" alt="Avatar for {{ $post->profile->display_name }}"
            class="size-10 object-cover" />
    </a>
    <div class="border-pixl-light/10 grow border-b pt-1.5 pb-5">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <p>
                    <a class="hover:underline"
                        href="{{ route('profiles.show', $post->profile) }}">{{ $post->profile->display_name }}</a>
                </p>
                <a href="{{ route('posts.show', [$post->profile, $post]) }}"
                    class="text-pixl-light/40 hover:text-pixl-light/60 text-xs">{{ $post->created_at->diffForHumans() }}</a>
                <p>
                    <a class="text-pixl-light/40 hover:text-pixl-light/60 text-xs"
                        href="{{ route('profiles.show', $post->profile) }}">{{ '@' . $post->profile->handle }}</a>
                </p>
            </div>
            <div x-data="{ open: false }" class="relative">
                <button x-on:click="open = !open" class="group flex gap-[3px] py-2" aria-label="Post options">
                    <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                    <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                    <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                </button>
                <div x-show="open" @click.outside="open = false" x-cloak
                    class="bg-pixl-dark border-pixl-light/20 absolute right-0 top-full z-10 mt-1 flex flex-col border p-1 text-xs">
                    @if (Auth::id() && Auth::user()?->profile?->id === $post->profile->id)
                        <button x-on:click="
                                        if (confirm('Delete this reply?')) {
                                            axios.post('{{ route('posts.destroy', $post) }}').then(() => {
                                                $root.closest('li').remove();
                                            });
                                        }
                                        open = false;
                                    "
                            class="hover:bg-pixl-light/10 w-full px-3 py-1.5 text-left whitespace-nowrap text-red-400 hover:text-red-300">
                            Delete
                        </button>
                    @endif
                    <button x-on:click="open = false"
                        class="hover:bg-pixl-light/10 w-full px-3 py-1.5 text-left whitespace-nowrap">
                        Copy link
                    </button>
                </div>
            </div>
        </div>
        <div class="mt-4 flex flex-col gap-3 text-sm">
            {!! $post->content !!}
        </div>
        <!-- Action buttons -->
        @if ($showEngagement)
            <div class="mt-6 flex items-center justify-between gap-4">
                <div class="flex items-center gap-8">
                    <x-like-button :active="$post->has_liked" :count="$post->likes_count" :id="$post->id" />
                    <x-reply-button :count="$post->replies_count" :id="$post->id" />
                    <x-repost-button :active="$post->has_reposted" :count="$post->reposts_count" :id="$post->id" />
                </div>
                <div class="flex items-center gap-3">
                    <x-save-button :id="$post->id" />
                    <x-share-button :id="$post->id" />
                </div>
            </div>
        @endif
        {{-- Nested Replies --}}
        @if ($showReplies && $post->relationLoaded('replies') && $post->replies->isNotEmpty())
            <ol class="mt-4">
                @foreach ($post->replies as $nestedReply)
                    <x-reply :post="$nestedReply" :showEngagement="$showEngagement ?? true" :showReplies="$showReplies ?? false" />
                @endforeach
            </ol>
        @endif
    </div>
</li>