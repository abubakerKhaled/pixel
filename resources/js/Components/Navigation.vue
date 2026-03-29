<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { index } from '@/actions/App/Http/Controllers/PostController'
import { show as profileShow } from '@/actions/App/Http/Controllers/ProfileController'
import PixlLogoIcon from '@/Components/Icons/PixlLogoIcon.vue'

// Access the shared auth data from HandleInertiaRequests
const page = usePage()
const profile = computed(() => page.props.auth?.user?.profile)

// Check if current page is the feed (to hide/show Post button)
const isHomePage = computed(() => usePage().url === '/home')
</script>

<template>
    <header class="my-4 hidden w-48 shrink-0 flex-col justify-between gap-8 pl-4 sm:flex xl:ml-32">
        <div class="overflow-y-auto">
            <!-- Logo -->
            <Link href="/">
                <PixlLogoIcon class="h-8" />
            </Link>

            <!-- Navigation links -->
            <nav class="mt-10">
                <ul class="flex flex-col gap-3.5">
                    <li>
                        <Link :class="usePage().url.startsWith('/home') ? 'text-pixl' : 'hover:underline'" :href="index.url()">Home</Link>
                    </li>
                    <li><a class="hover:underline" href="#">Explore</a></li>
                    <!-- Active item -->
                    <li class="-ml-4 flex items-center gap-2">
                        <div class="bg-pixl size-2 shrink-0"></div>
                        <a class="hover:underline" href="#">Notifications</a>
                    </li>
                    <li><a class="hover:underline" href="#">Lists</a></li>
                    <li><a class="hover:underline" href="#">Bookmarks</a></li>
                    <li><a class="hover:underline" href="#">Jobs</a></li>
                    <li><a class="hover:underline" href="#">Communities</a></li>
                    <li><a class="hover:underline" href="#">Premium</a></li>
                    <li v-if="profile">
                        <Link class="hover:underline" :href="profileShow.url(profile)">Profile</Link>
                    </li>
                    <li><a class="hover:underline" href="#">More</a></li>
                </ul>
            </nav>
        </div>

        <!-- Bottom section: Post button & User controls -->
        <div class="flex flex-col gap-6">
            <Link v-if="!isHomePage" :href="index.url()"
                class="bg-pixl hover:bg-pixl/90 active:bg-pixl/95 block text-pixl-dark border border-transparent px-4 py-3 text-center text-sm">
                Post
            </Link>

            <!-- User controls -->
            <div v-if="profile" class="flex gap-3.5">
                <Link :href="profileShow.url(profile)" class="shrink-0">
                    <img :src="profile.avatar_url" :alt="'Avatar for ' + profile.display_name"
                        class="size-11 object-cover" />
                </Link>
                <div class="flex flex-col gap-1 text-sm">
                    <p>{{ profile.display_name }}</p>
                    <p class="text-pixl-light/60">@{{ profile.handle }}</p>
                </div>
                <button class="group flex gap-[3px] py-2" aria-label="Post options">
                    <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                    <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                    <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                </button>
            </div>
        </div>
    </header>
</template>
