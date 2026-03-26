<script setup>
import { Link, usePage, useForm } from '@inertiajs/vue3'
import ImageIcon from '@/Components/Icons/ImageIcon.vue'
import VideoIcon from '@/Components/Icons/VideoIcon.vue'
import { reply } from '@/actions/App/Http/Controllers/PostController'
import { show as profileShow } from '@/actions/App/Http/Controllers/ProfileController'

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
})

// Get auth user's profile from shared Inertia data
const auth = usePage().props.auth
const profile = auth?.user?.profile

// Inertia form — replaces <form method="POST" action="{{ route('posts.reply', ...) }}"> + @csrf
const form = useForm({
    content: '',
})

const emit = defineEmits(['submitted'])

// Submit reply — posts to the reply endpoint for this specific post
const submit = () => {
    form.post(reply.url({ profile: props.post.profile, post: props.post }), {
        onSuccess: () => {
            form.reset()
            emit('submitted')
        },
    })
}
</script>

<template>
    <!-- Only show for authenticated users with a profile (replaces @auth + @if($profile)) -->
    <div v-if="profile" class="border-pixl-light/10 bg-pixl-light/3 mt-8 flex items-start gap-4 border-t p-4">
        <Link :href="profileShow.url(profile)" class="shrink-0">
            <img :src="profile.avatar_url" :alt="'Avatar for ' + profile.display_name"
                class="size-10 object-cover" />
        </Link>

        <form class="grow" @submit.prevent="submit">
            <label class="sr-only" for="reply">Reply body</label>

            <textarea
                v-model="form.content"
                class="w-full resize-none text-sm"
                rows="5"
                name="content"
                id="reply"
                :placeholder="'Reply to ' + post.profile.display_name"
            ></textarea>

            <div v-if="form.errors.content" class="text-red-400 text-xs mt-1">
                {{ form.errors.content }}
            </div>

            <div class="flex items-center justify-between gap-4">
                <div class="flex gap-4">
                    <button type="button">
                        <ImageIcon />
                    </button>
                    <button type="button">
                        <VideoIcon />
                    </button>
                </div>
                <button type="submit" :disabled="form.processing"
                    class="bg-pixl/10 hover:bg-pixl/15 active:bg-pixl/20 text-pixl border border-transparent px-4 py-1 text-sm">
                    Post
                </button>
            </div>
        </form>
    </div>
</template>
