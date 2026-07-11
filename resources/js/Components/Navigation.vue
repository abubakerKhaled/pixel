<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed, ref, onMounted, onUnmounted } from 'vue'
import { index } from '@/actions/App/Http/Controllers/PostController'
import { show as profileShow } from '@/actions/App/Http/Controllers/ProfileController'
import PixlLogoIcon from '@/Components/Icons/PixlLogoIcon.vue'

// Access the shared auth data from HandleInertiaRequests
const page = usePage()
const profile = computed(() => page.props.auth?.user?.profile)

// Check if current page is the feed (to hide/show Post button)
const isHomePage = computed(() => usePage().url === '/home')

// Dropdown menu state and outside click detection
const showMenu = ref(false)
const menuRef = ref(null)

const toggleMenu = () => {
    showMenu.value = !showMenu.value
}

const handleClickOutside = (event) => {
    if (menuRef.value && !menuRef.value.contains(event.target)) {
        showMenu.value = false
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
})
</script>

<template>
    <header class="my-4 hidden w-48 shrink-0 flex-col justify-between gap-8 pl-4 sm:flex xl:ml-32">
        <div class="overflow-y-auto">
            <!-- Logo -->
            <Link :href="index.url()">
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
            <div v-if="profile" ref="menuRef" class="relative">
                <div class="flex items-center justify-between gap-3.5">
                    <div class="flex gap-3.5">
                        <Link :href="profileShow.url(profile)" class="shrink-0">
                            <img :src="profile.avatar_url" :alt="'Avatar for ' + profile.display_name"
                                class="size-11 object-cover" />
                        </Link>
                        <div class="flex flex-col gap-1 text-sm">
                            <p>{{ profile.display_name }}</p>
                            <p class="text-pixl-light/60">@{{ profile.handle }}</p>
                        </div>
                    </div>
                    <button @click.stop="toggleMenu" class="group flex gap-[3px] py-2 px-1 focus:outline-none" aria-label="User options">
                        <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                        <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                        <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                    </button>
                </div>

                <!-- Absolutely positioned popup menu -->
                <div v-if="showMenu"
                    class="absolute bottom-full left-0 mb-3 w-48 border border-pixl/30 bg-pixl-dark/95 p-1 backdrop-blur-sm shadow-xl z-50">
                    <a href="#" class="block w-full text-left px-3 py-2 text-sm text-pixl-light hover:bg-pixl-light/10 font-pixl">
                        Edit Profile
                    </a>
                    <Link href="/logout" method="delete" as="button"
                        class="block w-full text-left px-3 py-2 text-sm text-red-400 hover:bg-red-500/10 font-pixl font-semibold">
                        Log out @{{ profile.handle }}
                    </Link>
                </div>
            </div>
        </div>
    </header>
</template>
