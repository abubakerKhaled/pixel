@props(['active' => false, 'count' => 0, 'id'])

@php
    $post = \App\Models\Post::with('profile')->find($id);
@endphp

<div class="flex items-center gap-1" x-data="{
    reposted: {{ $active ? 'true' : 'false' }},
    count: {{ $count }},
    showQuoteForm: false,
    repost() {
        this.reposted = !this.reposted;
        this.count += this.reposted ? 1 : -1;
        axios.post('{{ route('posts.repost', [$post->profile, $post]) }}');
    }
}">
    <div class="relative" x-data="{ open: false }">
        <button type="button" aria-label="Re-post" x-on:click="open = !open" class="hover:text-pixl"
            :class="{ 'text-pixl': reposted }">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="h-[17px]" viewBox="0 0 20 17">
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
                <path fill="currentColor"
                    d="M15.714 8.143h-1.428v1.429h1.428V8.143Zm0-1.429h-1.428v1.429h1.428V6.714Z" />
                <path fill="currentColor"
                    d="M15.714 5.286h-1.428v1.429h1.428V5.286Zm-1.428 0h-1.428v1.429h1.428V5.286Zm-1.43 0h-1.428v1.429h1.428V5.286Z" />
            </svg>
        </button>
        <!-- Dropdown for Repost/Quote -->
        <div x-show="open" @click.outside="open = false" style="display: none;"
            class="bg-pixl-dark border-pixl-light/20 absolute top-full left-0 z-10 mt-1 flex flex-col border p-1 text-xs">
            <button x-on:click="repost(); open = false"
                class="hover:bg-pixl-light/10 w-full px-3 py-1.5 text-left whitespace-nowrap">
                Repost
            </button>
            <button x-on:click="showQuoteForm = !showQuoteForm; open = false"
                class="hover:bg-pixl-light/10 w-full px-3 py-1.5 text-left whitespace-nowrap">
                Quote
            </button>
        </div>
    </div>
    <span class="hover:text-pixl text-sm" :class="{ 'text-pixl': reposted }" x-text="count"></span>

    <!-- Quote Form -->
    <template x-if="showQuoteForm">
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
            x-on:click.self="showQuoteForm = false">
            <div class="bg-pixl-dark border-pixl-light/20 w-full max-w-lg border p-6">
                <h3 class="mb-4 text-lg font-bold">Quote Post</h3>
                <form action="{{ route('posts.quote', [$post->profile, $post]) }}" method="POST">
                    @csrf
                    <textarea name="content" rows="3"
                        class="bg-pixl-dark border-pixl-light/20 focus:border-pixl w-full border p-2 text-sm outline-none"
                        placeholder="Add a comment..."></textarea>
                    <div class="mt-4 flex justify-end gap-2">
                        <button type="button" x-on:click="showQuoteForm = false"
                            class="text-pixl-light/60 hover:text-pixl-light/80 text-sm">Cancel</button>
                        <button type="submit"
                            class="bg-pixl text-pixl-dark hover:bg-pixl/90 px-4 py-1.5 text-sm font-bold">Post</button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>