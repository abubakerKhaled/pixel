<!-- Artists to follow -->
<div class="border-pixl-light/10 mt-10 border p-4">
    <h2 class="text-pixl-light/60 text-sm">Artists to follow</h2>
    <ol class="mt-4 flex flex-col gap-4">
        @foreach ($profiles as $profile)
            <li class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <img src="{{ $profile->avatar_url }}" alt="Avatar of {{ $profile->display_name }}"
                        class="size-8 object-cover" />
                    <p class="truncate text-sm">{{ $profile->handle }}</p>
                </div>
                @auth
                    @if (Auth::user()?->profile?->id !== $profile->id)
                        <div x-data="{
                                                following: {{ Auth::user()?->profile?->isFollowing($profile) ? 'true' : 'false' }},
                                                toggle() {
                                                    const url = this.following
                                                        ? '{{ route('profiles.unfollow', $profile) }}'
                                                        : '{{ route('profiles.follow', $profile) }}';
                                                    this.following = !this.following;
                                                    axios.post(url);
                                                }
                                            }">
                            <button type="button" x-on:click="toggle()" x-text="following ? 'Unfollow' : 'Follow'"
                                class="bg-pixl-dark/50 hover:bg-pixl-dark/60 active:bg-pixl-dark/75 border-pixl/50 hover:border-pixl/60 active:border-pixl/75 text-pixl border px-2 py-1 text-sm">
                            </button>
                        </div>
                    @endif
                @endauth
            </li>
        @endforeach
    </ol>
    <a href="#" class="text-pixl-light/60 mt-4 inline-block text-sm">Show more</a>
</div>