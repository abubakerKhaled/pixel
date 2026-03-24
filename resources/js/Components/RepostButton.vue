<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useForm } from '@inertiajs/vue3'
import RepostIcon from '@/Components/Icons/RepostIcon.vue'
import { repost, quote } from '@/actions/App/Http/Controllers/PostController'

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    },
    count: {
        type: Number,
        default: 0,
    },
})

// Reactive state — replaces Alpine's x-data
const reposted = ref(props.active)
const repostCount = ref(props.count)
const showDropdown = ref(false)       // replaces nested x-data { open: false }
const showQuoteForm = ref(false)      // replaces x-data { showQuoteForm: false }

// Inertia form for quote submission — replaces the <form> with @csrf
const quoteForm = useForm({
    content: '',
})

// Repost toggle — replaces Alpine's repost() method
const doRepost = () => {
    reposted.value = !reposted.value
    repostCount.value += reposted.value ? 1 : -1
    showDropdown.value = false
    axios.post(repost.url({ profile: props.post.profile, post: props.post }))
}

// Open quote modal — replaces Alpine's showQuoteForm toggle
const openQuoteForm = () => {
    showQuoteForm.value = true
    showDropdown.value = false
}

// Submit quote — replaces the traditional form POST
const submitQuote = () => {
    quoteForm.post(quote.url({ profile: props.post.profile, post: props.post }), {
        onSuccess: () => {
            showQuoteForm.value = false
            quoteForm.reset()
        },
    })
}
</script>

<template>
    <div class="flex items-center gap-1">
        <!-- Dropdown trigger -->
        <div class="relative">
            <button type="button" aria-label="Re-post" class="hover:text-pixl"
                :class="{ 'text-pixl': reposted }" @click="showDropdown = !showDropdown">
                <RepostIcon />
            </button>

            <!-- Dropdown menu — replaces Alpine x-show="open" -->
            <div v-show="showDropdown" @click.self="showDropdown = false"
                class="bg-pixl-dark border-pixl-light/20 absolute top-full left-0 z-10 mt-1 flex flex-col border p-1 text-xs">
                <button @click="doRepost"
                    class="hover:bg-pixl-light/10 w-full px-3 py-1.5 text-left whitespace-nowrap">
                    Repost
                </button>
                <button @click="openQuoteForm"
                    class="hover:bg-pixl-light/10 w-full px-3 py-1.5 text-left whitespace-nowrap">
                    Quote
                </button>
            </div>
        </div>

        <span class="hover:text-pixl text-sm" :class="{ 'text-pixl': reposted }">{{ repostCount }}</span>

        <!-- Quote Modal — replaces Alpine x-if="showQuoteForm" + traditional form -->
        <Teleport to="body">
            <div v-if="showQuoteForm" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                @click.self="showQuoteForm = false">
                <div class="bg-pixl-dark border-pixl-light/20 w-full max-w-lg border p-6">
                    <h3 class="mb-4 text-lg font-bold">Quote Post</h3>
                    <form @submit.prevent="submitQuote">
                        <textarea v-model="quoteForm.content" rows="3"
                            class="bg-pixl-dark border-pixl-light/20 focus:border-pixl w-full border p-2 text-sm outline-none"
                            placeholder="Add a comment..."></textarea>
                        <div v-if="quoteForm.errors.content" class="text-red-400 text-xs mt-1">
                            {{ quoteForm.errors.content }}
                        </div>
                        <div class="mt-4 flex justify-end gap-2">
                            <button type="button" @click="showQuoteForm = false"
                                class="text-pixl-light/60 hover:text-pixl-light/80 text-sm">Cancel</button>
                            <button type="submit" :disabled="quoteForm.processing"
                                class="bg-pixl text-pixl-dark hover:bg-pixl/90 px-4 py-1.5 text-sm font-bold">
                                Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Teleport>
    </div>
</template>
