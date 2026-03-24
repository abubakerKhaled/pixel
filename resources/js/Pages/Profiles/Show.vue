<script setup>
import { Link } from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'
import ProfileHeader from '@/Components/ProfileHeader.vue'
import Post from '@/Components/Post.vue'
import BackArrowIcon from '@/Components/Icons/BackArrowIcon.vue'
import { index } from '@/actions/App/Http/Controllers/PostController'

defineProps({
    profile: {
        type: Object,
        required: true,
    },
    posts: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <Layout title="PIXL - Profile">
        <main class="-mx-4 flex grow flex-col gap-4 overflow-y-auto px-4 py-4">
            <Link :href="index.url()" class="group flex items-baseline gap-1.5">
                <BackArrowIcon />
                <span>back</span>
            </Link>

            <ProfileHeader :profile="profile" active-tab="posts" />

            <!-- Feed -->
            <ol class="border-pixl-light/10 border-t pt-4">
                <Post v-for="post in posts" :key="post.id" :post="post" />
            </ol>

            <footer class="mt-30 ml-14">
                <p class="text-center">That's all, folks!</p>
                <hr class="border-pixl-light/10 my-4" />
                <div class="h-20 bg-[url(/images/white-noise.gif)]"></div>
            </footer>
        </main>
    </Layout>
</template>
