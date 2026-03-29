<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import FollowButton from '@/Components/FollowButton.vue'
import { show as profileShow } from '@/actions/App/Http/Controllers/ProfileController'

defineProps({
    profiles: {
        type: Array,
        default: () => [],
    },
})

const authProfile = usePage().props.auth?.user?.profile
</script>

<template>
    <!-- Artists to follow -->
    <div class="border-pixl-light/10 mt-10 border p-4">
        <h2 class="text-pixl-light/60 text-sm">Artists to follow</h2>
        <ol class="mt-4 flex flex-col gap-4">
            <li v-for="profile in profiles" :key="profile.id" class="flex items-center justify-between gap-4">
                <Link :href="profileShow.url(profile)">
                    <div class="flex items-center gap-2.5">
                        <img :src="profile.avatar_url" :alt="'Avatar of ' + profile.display_name"
                            class="size-8 object-cover" />
                        <p class="truncate text-sm">{{ profile.handle }}</p>
                    </div>
                </Link>
                <FollowButton
                    v-if="authProfile && authProfile.id !== profile.id"
                    :profile="profile"
                    :initial-following="profile.is_following ?? false"
                />
            </li>
        </ol>
        <a href="#" class="text-pixl-light/60 mt-4 inline-block text-sm">Show more</a>
    </div>
</template>
