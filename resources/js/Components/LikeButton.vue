<script setup>
import { ref } from 'vue'
import axios from 'axios'
import HeartIcon from '@/Components/Icons/HeartIcon.vue'
import { like, unlike } from '@/actions/App/Http/Controllers/PostController'

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
const liked = ref(props.active)
const likeCount = ref(props.count)

// Toggle like/unlike — replaces Alpine's toggle() method
const toggle = () => {
    const action = liked.value ? unlike : like
    liked.value = !liked.value
    likeCount.value += liked.value ? 1 : -1
    axios.post(action.url({ profile: props.post.profile, post: props.post }))
}
</script>

<template>
    <div class="flex items-center gap-1">
        <button type="button" aria-label="Like" class="hover:text-pixl" :class="{ 'text-pixl': liked }"
            @click="toggle">
            <HeartIcon />
        </button>
        <span class="hover:text-pixl text-sm" :class="{ 'text-pixl': liked }">{{ likeCount }}</span>
    </div>
</template>
