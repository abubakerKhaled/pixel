<script setup>
import { Link, usePage, useForm } from '@inertiajs/vue3'
import ImageIcon from '@/Components/Icons/ImageIcon.vue'
import VideoIcon from '@/Components/Icons/VideoIcon.vue'
import { store } from '@/actions/App/Http/Controllers/PostController'
import { show as profileShow } from '@/actions/App/Http/Controllers/ProfileController'

// Get auth user's profile from shared Inertia data
const profile = usePage().props.auth?.user?.profile

// Inertia form — replaces <form method="POST"> + @csrf
const form = useForm({
    content: '',
})

// Submit handler — replaces traditional form action
const submit = () => {
    form.post(store.url(), {
        onSuccess: () => form.reset(),
    })
}
</script>

<template>
    <div v-if="profile" class="border-pixl-light/10 mt-8 flex items-start gap-4 border-b pb-4">
        <Link :href="profileShow.url(profile)" class="shrink-0">
            <img :src="profile.avatar_url" :alt="'Avatar for ' + profile.display_name"
                class="size-10 object-cover" />
        </Link>

        <form class="grow" @submit.prevent="submit">
            <label class="sr-only" for="post">Post body</label>

            <textarea
                v-model="form.content"
                class="w-full resize-none text-lg"
                name="content"
                id="post"
                :placeholder="'What\'s up ' + profile.display_name + '?'"
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
                    class="bg-pixl hover:bg-pixl/90 active:bg-pixl/95 text-pixl-dark border border-transparent px-4 py-1 text-sm">
                    Post
                </button>
            </div>
        </form>
    </div>
</template>
