@php
    // For pure reposts (no content), display the original post instead
    $isPureRepost = $post->isRepost() && $post->content === null;
    $displayPost = $isPureRepost ? $post->repostOf : $post;
@endphp
<li class="flex flex-col not-first:pt-2.5">
    @if ($isPureRepost)
        <div class="flex items-center gap-2 mb-2 ml-14 text-pixl-light/50 text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="h-3" viewBox="0 0 20 17">
                <path fill="currentColor" d="M1.429 3.857H0v1.429h1.429V3.857Z" />
                <path fill="currentColor" d="M2.854 3.857H1.426v1.429h1.428V3.857Z" />
                <path fill="currentColor" d="M2.854 2.429H1.426v1.429h1.428V2.429Zm1.432 0H2.858v1.429h1.428v-1.43Z" />
                <path fill="currentColor" d="M4.286 1H2.858v1.429h1.428V1Z" />
                <path fill="currentColor" d="M5.712 1H4.284v1.429h1.428V1Zm1.432 0H5.716v1.429h1.428V1Z" />
                <path fill="currentColor" d="M7.144 2.429H5.716v1.429h1.428v-1.43Z" />
                <path fill="currentColor" d="M8.57 2.429H7.142v1.429H8.57V2.429Z" />
                <path fill="currentColor"
                    d="M8.57 3.857H7.142v1.429H8.57V3.857Zm1.43 0H8.572v1.429H10V3.857ZM5.712 2.429H4.284v1.429h1.428V2.429Z" />
                <path fill="currentColor" d="M5.712 3.857H4.284v1.429h1.428V3.857Z" />
                <path fill="currentColor" d="M5.712 5.286H4.284v1.429h1.428V5.286Z" />
                <path fill="currentColor"
                    d="M5.712 6.714H4.284v1.429h1.428V6.714Zm0 1.429H4.284v1.429h1.428V8.143Zm1.432 1.429H5.716V11h1.428V9.57Z" />
                <path fill="currentColor"
                    d="M8.57 9.572H7.142V11H8.57V9.572ZM11.428 11H10v1.428h1.428V11Zm1.428 0h-1.428v1.428h1.428V11Zm0 1.429h-1.428v1.428h1.428V12.43Zm1.43 0h-1.428v1.428h1.428V12.43Zm1.428 1.428h-1.428v1.429h1.428v-1.429Z" />
                <path fill="currentColor"
                    d="M17.142 13.857h-1.428v1.429h1.428v-1.429Zm-2.856 0h-1.428v1.429h1.428v-1.429Zm2.856-1.428h-1.428v1.428h1.428V12.43Zm1.43 0h-1.428v1.428h1.428V12.43Zm0-1.429h-1.428v1.428h1.428V11Z" />
                <path fill="currentColor"
                    d="M20 11h-1.429v1.428H20V11Zm-4.286 1.429h-1.428v1.428h1.428V12.43Zm0-1.429h-1.428v1.428h1.428V11Zm0-1.428h-1.428V11h1.428V9.572Z" />
                <path fill="currentColor" d="M15.714 8.143h-1.428v1.429h1.428V8.143Zm0-1.429h-1.428v1.429h1.428V6.714Z" />
                <path fill="currentColor"
                    d="M15.714 5.286h-1.428v1.429h1.428V5.286Zm-1.428 0h-1.428v1.429h1.428V5.286Zm-1.43 0h-1.428v1.429h1.428V5.286Z" />
            </svg>
            <span><a href="{{ route('profiles.show', $post->profile) }}"
                    class="hover:underline">{{ $post->profile->display_name }}</a>
                reposted</span>
        </div>
    @endif
    <div class="flex items-start gap-4">
        <a href="{{ route('profiles.show', $displayPost->profile) }}" class="shrink-0">
            <img src="{{ $displayPost->profile->avatar_url }}"
                alt="Avatar for {{ $displayPost->profile->display_name }}" class="size-10 object-cover" />
        </a>
        <div class="grow pt-1.5">
            <div class="border-pixl-light/10 border-b pb-5">
                <!-- User meta -->
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2.5">
                        <p><a class="hover:underline"
                                href="{{ route('profiles.show', $displayPost->profile) }}">{{ $displayPost->profile->display_name }}</a>
                        </p>
                        <a href="{{ route('posts.show', [$displayPost->profile, $displayPost]) }}"
                            class="text-pixl-light/40 hover:text-pixl-light/60 text-xs">{{ $displayPost->created_at->diffForHumans() }}</a>
                        <p>
                            <a class="text-pixl-light/40 hover:text-pixl-light/60 text-xs"
                                href="{{ route('profiles.show', $displayPost->profile) }}">{{ '@' . $displayPost->profile->handle }}</a>
                        </p>
                    </div>
                    <div x-data="{ open: false, deleted: false }" class="relative">
                        <button x-on:click="open = !open" class="group flex gap-[3px] py-2" aria-label="Post options">
                            <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                            <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                            <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-cloak
                            class="bg-pixl-dark border-pixl-light/20 absolute right-0 top-full z-10 mt-1 flex flex-col border p-1 text-xs">
                            @if (Auth::id() && Auth::user()->profile->id === $displayPost->profile->id)
                                <button x-on:click="
                                            if (confirm('Delete this post?')) {
                                                axios.post('{{ route('posts.destroy', $displayPost) }}').then(() => {
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
                <!-- Post content -->
                <div class="[&_a]:text-pixl mt-4 flex flex-col gap-3 text-sm [&_a]:hover:underline">
                    {!! $displayPost->content !!}
                </div>
                <!-- Quote post -->
                @if ($displayPost->isRepost() && $displayPost->content !== null)
                    <ol class="mt-4 border-l-2 border-pixl-light/20 pl-4">
                        <x-post :post="$displayPost->repostOf" :show-engagement="false" :show-replies="false" />
                    </ol>
                @endif
                <!-- Action buttons -->
                @if ($showEngagement)
                    <div class="mt-6 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-8">
                            <x-like-button :active="$displayPost->has_liked" :count="$displayPost->likes_count"
                                :id="$displayPost->id" />
                            <x-reply-button :count="$displayPost->replies_count" :id="$displayPost->id" />
                            <x-repost-button :active="$displayPost->has_reposted" :count="$displayPost->reposts_count"
                                :id="$displayPost->id" />
                        </div>
                        <div class="flex items-center gap-3">
                            <x-save-button :id="$displayPost->id" />
                            <x-share-button :id="$displayPost->id" />
                        </div>
                    </div>
                @endif

                <!-- Reply Form -->
                <x-reply-form :post="$displayPost" />

                <!-- Replies -->
                @if ($showReplies && $displayPost->relationLoaded('replies') && $displayPost->replies->isNotEmpty())
                    <ol class="mt-4">
                        @foreach ($displayPost->replies as $reply)
                            <x-reply :post="$reply" :showEngagement="$showEngagement ?? true" :showReplies="$showReplies ?? false" />
                        @endforeach
                    </ol>
                @endif
            </div>
        </div>
    </div>
</li>