<script setup>
import { Link } from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'
import Post from '@/Components/Post.vue'
import BackArrowIcon from '@/Components/Icons/BackArrowIcon.vue'
import { index } from '@/actions/App/Http/Controllers/PostController'

defineProps({
    post: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <Layout title="PIXL - Post">
        <main class="-mx-4 flex grow flex-col gap-4 overflow-y-auto px-4 py-4">
            <Link :href="index.url()" class="group flex items-baseline gap-1.5">
                <BackArrowIcon />
                <span>back</span>
            </Link>

            <ol class="border-pixl-light/10 border-t pt-4">
                <Post :post="post" :show-replies="true" />
            </ol>
        </main>
    </Layout>
</template>
