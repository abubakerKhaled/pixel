<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import axios from 'axios'
import { follow, unfollow } from '@/actions/App/Http/Controllers/ProfileController'

defineProps({
    profiles: {
        type: Array,
        default: () => [],
    },
})

// Get the current user's profile ID to hide follow button on own profile
const authProfile = usePage().props.auth?.user?.profile
</script>

<template>
    <!-- Artists to follow -->
    <div class="border-pixl-light/10 mt-10 border p-4">
        <h2 class="text-pixl-light/60 text-sm">Artists to follow</h2>
        <ol class="mt-4 flex flex-col gap-4">
            <li v-for="profile in profiles" :key="profile.id" class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <img :src="profile.avatar_url" :alt="'Avatar of ' + profile.display_name"
                        class="size-8 object-cover" />
                    <p class="truncate text-sm">{{ profile.handle }}</p>
                </div>
                <!-- Follow/Unfollow button (only for logged-in users, not on own profile) -->
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

<script>
// Inline FollowButton sub-component
// Handles the reactive follow/unfollow toggle (replaces Alpine x-data)
import { ref as vueRef } from 'vue'
import axiosLib from 'axios'
import { follow as followAction, unfollow as unfollowAction } from '@/actions/App/Http/Controllers/ProfileController'

const FollowButton = {
    props: {
        profile: { type: Object, required: true },
        initialFollowing: { type: Boolean, default: false },
    },
    setup(props) {
        const following = vueRef(props.initialFollowing)

        const toggle = () => {
            const action = following.value ? unfollowAction : followAction
            following.value = !following.value
            axiosLib.post(action.url(props.profile))
        }

        return { following, toggle }
    },
    template: `
        <button type="button" @click="toggle"
            class="bg-pixl-dark/50 hover:bg-pixl-dark/60 active:bg-pixl-dark/75 border-pixl/50 hover:border-pixl/60 active:border-pixl/75 text-pixl border px-2 py-1 text-sm">
            {{ following ? 'Unfollow' : 'Follow' }}
        </button>
    `,
}

export default {
    components: { FollowButton },
}
</script>
