<script setup>
import { ref, computed } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'
import axios from 'axios'
import LikeButton from '@/Components/LikeButton.vue'
import ReplyButton from '@/Components/ReplyButton.vue'
import RepostButton from '@/Components/RepostButton.vue'
import SaveButton from '@/Components/SaveButton.vue'
import ShareButton from '@/Components/ShareButton.vue'
import { show as postShow, destroy } from '@/actions/App/Http/Controllers/PostController'
import { show as profileShow } from '@/actions/App/Http/Controllers/ProfileController'

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
    showEngagement: {
        type: Boolean,
        default: true,
    },
    showReplies: {
        type: Boolean,
        default: false,
    },
})

// Auth user for ownership checks
const authProfile = usePage().props.auth?.user?.profile
const canDelete = computed(() => authProfile && authProfile.id === props.post.profile?.id)

// Options dropdown — replaces x-data="{ open: false }"
const showOptions = ref(false)

// Delete reply — replaces Alpine's axios.post + $root.closest('li').remove()
const deleteReply = () => {
    if (confirm('Delete this reply?')) {
        showOptions.value = false
        axios.post(destroy.url(props.post)).then(() => {
            router.reload()
        })
    }
}

// Timestamp
const timeAgo = computed(() => props.post.created_at_human ?? props.post.created_at)
</script>

<template>
    <li class="group/li relative flex items-start gap-4 pt-4">
        <!-- Thread line — visual connector between replies -->
        <div aria-hidden="true" class="bg-pixl-light/10 absolute top-0 left-5 h-full w-px group-last/li:h-4">
        </div>

        <!-- Avatar -->
        <Link :href="profileShow.url(post.profile)" class="isolate shrink-0">
            <img :src="post.profile.avatar_url" :alt="'Avatar for ' + post.profile.display_name"
                class="size-10 object-cover" />
        </Link>

        <div class="border-pixl-light/10 grow border-b pt-1.5 pb-5">
            <!-- User meta + options -->
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <p>
                        <Link class="hover:underline" :href="profileShow.url(post.profile)">
                            {{ post.profile.display_name }}
                        </Link>
                    </p>
                    <Link :href="postShow.url({ profile: post.profile, post: post })"
                        class="text-pixl-light/40 hover:text-pixl-light/60 text-xs">
                        {{ timeAgo }}
                    </Link>
                    <p>
                        <Link class="text-pixl-light/40 hover:text-pixl-light/60 text-xs"
                            :href="profileShow.url(post.profile)">
                            @{{ post.profile.handle }}
                        </Link>
                    </p>
                </div>

                <!-- Options dropdown -->
                <div class="relative">
                    <button @click="showOptions = !showOptions" class="group flex gap-[3px] py-2"
                        aria-label="Post options">
                        <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                        <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                        <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                    </button>
                    <div v-show="showOptions" @click.outside="showOptions = false"
                        class="bg-pixl-dark border-pixl-light/20 absolute right-0 top-full z-10 mt-1 flex flex-col border p-1 text-xs">
                        <button v-if="canDelete" @click="deleteReply"
                            class="hover:bg-pixl-light/10 w-full px-3 py-1.5 text-left whitespace-nowrap text-red-400 hover:text-red-300">
                            Delete
                        </button>
                        <button @click="showOptions = false"
                            class="hover:bg-pixl-light/10 w-full px-3 py-1.5 text-left whitespace-nowrap">
                            Copy link
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reply content -->
            <div class="mt-4 flex flex-col gap-3 text-sm" v-html="post.content"></div>

            <!-- Engagement buttons -->
            <div v-if="showEngagement" class="mt-6 flex items-center justify-between gap-4">
                <div class="flex items-center gap-8">
                    <LikeButton :post="post" :active="post.has_liked ?? false" :count="post.likes_count ?? 0" />
                    <ReplyButton :count="post.replies_count ?? 0" />
                    <RepostButton :post="post" :active="post.has_reposted ?? false"
                        :count="post.reposts_count ?? 0" />
                </div>
                <div class="flex items-center gap-3">
                    <SaveButton />
                    <ShareButton />
                </div>
            </div>

            <!-- Nested replies (recursive) -->
            <ol v-if="showReplies && post.replies?.length" class="mt-4">
                <Reply v-for="nestedReply in post.replies" :key="nestedReply.id" :post="nestedReply"
                    :show-engagement="showEngagement" :show-replies="false" />
            </ol>
        </div>
    </li>
</template>

<script>
// Required for recursive component self-reference
export default {
    name: 'Reply',
}
</script>
