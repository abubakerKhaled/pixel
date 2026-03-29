<script setup>
import Post from '@/Components/Post.vue'

defineProps({
    posts: {
        type: Array,
        required: true,
    },
    showReplies: {
        type: Boolean,
        default: false,
    },
})
</script>

<template>
    <ol>
        <Post v-for="post in posts" :key="post.id" :post="post" :show-replies="showReplies" />
    </ol>
</template>
