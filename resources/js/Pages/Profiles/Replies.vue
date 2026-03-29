<script setup>
import { Link } from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'
import ProfileHeader from '@/Components/ProfileHeader.vue'
import Post from '@/Components/Post.vue'
import BackArrowIcon from '@/Components/Icons/BackArrowIcon.vue'
import { index } from '@/actions/App/Http/Controllers/PostController'
import Footer from '../../Components/Footer.vue'

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
        <main class="-mx-4 flex grow flex-col min-h-0 gap-4 overflow-y-auto px-4 py-4">
            <Link :href="index.url()" class="group flex items-baseline gap-1.5">
                <BackArrowIcon />
                <span>back</span>
            </Link>

            <ProfileHeader :profile="profile" active-tab="replies" />

            <!-- Feed -->
            <ol class="border-pixl-light/10 border-t pt-4">
                <Post v-for="post in posts" :key="post.id" :post="post" :show-replies="true" />
            </ol>

            <Footer />
        </main>
    </Layout>
</template>
