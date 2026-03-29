<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import Tabs from '@/Components/Tabs.vue'
import { show as profileShow, replies as profileReplies } from '@/actions/App/Http/Controllers/ProfileController'
import FollowButton from './FollowButton.vue'

const props = defineProps({
    profile: {
        type: Object,
        required: true,
    },
    activeTab: {
        type: String,
        default: 'posts',
    },
})

// Auth user for ownership and follow checks
const auth = usePage().props.auth
const authUser = auth?.user
const isOwnProfile = computed(() => authUser && authUser.id === props.profile.user_id)


</script>

<template>
    <!-- Profile header -->
    <header>
        <img :src="profile.cover_url" alt="" />
        <div class="-mt-10 flex flex-wrap items-end justify-between gap-4 md:-mt-16">
            <div class="flex items-end gap-4">
                <img :src="profile.avatar_url" :alt="'Avatar for ' + profile.display_name"
                    class="size-20 object-cover md:size-32" />
                <div class="flex flex-col text-sm md:gap-1">
                    <p class="text-lg md:text-xl">{{ profile.display_name }}</p>
                    <p class="text-pixl-light/60 text-sm">@{{ profile.handle }}</p>
                </div>
            </div>

            <!-- Edit/Follow button — replaces @auth + @if(Auth::id() === ...) -->
            <template v-if="authUser">
                <a v-if="isOwnProfile" href="#"
                    class="bg-pixl-dark/50 hover:bg-pixl-dark/60 active:bg-pixl-dark/75 border-pixl/50 hover:border-pixl/60 active:border-pixl/75 text-pixl border px-2 py-1 text-sm">
                    Edit Profile
                </a>
                <FollowButton v-else :profile="profile" :initial-following="profile.is_following" />
            </template>
        </div>

        <div class="[&_a]:text-pixl mt-8 [&_a]:hover:underline">
            <p>{{ profile.bio }}</p>
        </div>

        <dl class="mt-6 flex gap-6">
            <div class="flex gap-1.5">
                <dd>{{ profile.following_count ?? 0 }}</dd>
                <dt class="text-pixl-light/60">Following</dt>
            </div>
            <div class="flex gap-1.5">
                <dd>{{ profile.followers_count ?? 0 }}</dd>
                <dt class="text-pixl-light/60">Followers</dt>
            </div>
        </dl>
    </header>

    <!-- Navigation tabs -->
    <Tabs class="mt-6">
        <li>
            <Link :href="profileShow.url(profile)"
                :class="activeTab !== 'posts' ? 'text-pixl-light/60 hover:text-pixl-light/80' : ''">
                Posts
            </Link>
        </li>
        <li>
            <Link :href="profileReplies.url(profile)"
                :class="activeTab !== 'replies' ? 'text-pixl-light/60 hover:text-pixl-light/80' : ''">
                Replies
            </Link>
        </li>
        <li>
            <a class="text-pixl-light/60 hover:text-pixl-light/80" href="#">Highlights</a>
        </li>
        <li>
            <a class="text-pixl-light/60 hover:text-pixl-light/80" href="#">Inspiration Streams</a>
        </li>
    </Tabs>
</template>
