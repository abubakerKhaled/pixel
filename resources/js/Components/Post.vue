<script setup>
import { ref, computed } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'
import axios from 'axios'
import RepostIcon from '@/Components/Icons/RepostIcon.vue'
import LikeButton from '@/Components/LikeButton.vue'
import ReplyButton from '@/Components/ReplyButton.vue'
import RepostButton from '@/Components/RepostButton.vue'
import SaveButton from '@/Components/SaveButton.vue'
import ShareButton from '@/Components/ShareButton.vue'
import ReplyForm from '@/Components/ReplyForm.vue'
import { show as postShow } from '@/actions/App/Http/Controllers/PostController'
import { destroy } from '@/actions/App/Http/Controllers/PostController'
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

// Get auth user for ownership checks (replaces @if(Auth::id() && Auth::user()->profile->id === ...))
const authProfile = usePage().props.auth?.user?.profile

// Pure repost detection — replaces @php block
const isPureRepost = computed(() => props.post.is_repost && props.post.content === null)
const displayPost = computed(() => isPureRepost.value ? props.post.repost_of : props.post)

// Is this a quote post? (has content AND is a repost)
const isQuotePost = computed(() => displayPost.value.is_repost && displayPost.value.content !== null)

// Can the current user delete this post?
const canDelete = computed(() => authProfile && authProfile.id === displayPost.value.profile?.id)

// Options dropdown — replaces x-data="{ open: false }"
const showOptions = ref(false)

// Reply form toggle
const showReplyForm = ref(false)

// Delete post — replaces Alpine's axios.post + DOM removal
const deletePost = () => {
    if (confirm('Delete this post?')) {
        showOptions.value = false
        axios.post(destroy.url(displayPost.value)).then(() => {
            router.reload()
        })
    }
}

// Format timestamp — replaces $post->created_at->diffForHumans()
// For now, use the server-provided value (created_at_human or created_at)
const timeAgo = computed(() => {
    return displayPost.value.created_at_human ?? displayPost.value.created_at
})
</script>

<template>
    <li class="flex flex-col not-first:pt-2.5">
        <!-- Pure repost indicator -->
        <div v-if="isPureRepost && post.profile" class="flex items-center gap-2 mb-2 ml-14 text-pixl-light/50 text-xs">
            <RepostIcon class="h-3!" />
            <span>
                <Link :href="profileShow.url(post.profile)" class="hover:underline">
                    {{ post.profile.display_name }}
                </Link>
                reposted
            </span>
        </div>

        <div v-if="displayPost?.profile" class="flex items-start gap-4">
            <!-- Avatar -->
            <Link :href="profileShow.url(displayPost.profile)" class="shrink-0">
                <img :src="displayPost.profile.avatar_url"
                    :alt="'Avatar for ' + displayPost.profile.display_name" class="size-10 object-cover" />
            </Link>

            <div class="grow pt-1.5">
                <div class="border-pixl-light/10 border-b pb-5">
                    <!-- User meta + options -->
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-2.5">
                            <p>
                                <Link class="hover:underline" :href="profileShow.url(displayPost.profile)">
                                    {{ displayPost.profile.display_name }}
                                </Link>
                            </p>
                            <Link :href="postShow.url({ profile: displayPost.profile, post: displayPost })"
                                class="text-pixl-light/40 hover:text-pixl-light/60 text-xs">
                                {{ timeAgo }}
                            </Link>
                            <p>
                                <Link class="text-pixl-light/40 hover:text-pixl-light/60 text-xs"
                                    :href="profileShow.url(displayPost.profile)">
                                    @{{ displayPost.profile.handle }}
                                </Link>
                            </p>
                        </div>

                        <!-- Options dropdown — replaces x-data="{ open: false }" -->
                        <div class="relative">
                            <button @click="showOptions = !showOptions" class="group flex gap-[3px] py-2"
                                aria-label="Post options">
                                <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                                <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                                <span class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"></span>
                            </button>
                            <div v-show="showOptions" @click.outside="showOptions = false"
                                class="bg-pixl-dark border-pixl-light/20 absolute right-0 top-full z-10 mt-1 flex flex-col border p-1 text-xs">
                                <button v-if="canDelete" @click="deletePost"
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

                    <!-- Post content — replaces {!! $displayPost->content !!} -->
                    <div class="[&_a]:text-pixl mt-4 flex flex-col gap-3 text-sm [&_a]:hover:underline"
                        v-html="displayPost.content"></div>

                    <!-- Quoted post — RECURSIVE: renders Post inside Post -->
                    <ol v-if="isQuotePost && displayPost.repost_of" class="mt-4 border-l-2 border-pixl-light/20 pl-4">
                        <Post :post="displayPost.repost_of" :show-engagement="false" :show-replies="false" />
                    </ol>

                    <!-- Engagement buttons -->
                    <div v-if="showEngagement" class="mt-6 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-8">
                            <LikeButton :post="displayPost" :active="displayPost.has_liked ?? false"
                                :count="displayPost.likes_count ?? 0" />
                            <ReplyButton :count="displayPost.replies_count ?? 0" @click="showReplyForm = !showReplyForm" />
                            <RepostButton :post="displayPost" :active="displayPost.has_reposted ?? false"
                                :count="displayPost.reposts_count ?? 0" />
                        </div>
                        <div class="flex items-center gap-3">
                            <SaveButton />
                            <ShareButton />
                        </div>
                    </div>

                    <!-- Reply form -->
                    <ReplyForm v-if="showReplyForm" :post="displayPost" @submitted="showReplyForm = false" />

                    <!-- Replies list -->
                    <ol v-if="showReplies && displayPost.replies?.length" class="mt-4">
                        <template v-for="replyPost in displayPost.replies" :key="replyPost.id">
                            <!-- Reply component will be created in Step 14 -->
                            <Post :post="replyPost" :show-engagement="showEngagement" :show-replies="false" />
                        </template>
                    </ol>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
// Required for recursive component — Vue needs a name to reference itself
export default {
    name: 'Post',
}
</script>
