<script setup>
import Layout from '@/Components/Layout.vue'
import ProfileHeader from '@/Components/ProfileHeader.vue'
import PostList from '@/Components/PostList.vue'
import BackLink from '@/Components/BackLink.vue'
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
            <BackLink :href="index.url()" />

            <ProfileHeader :profile="profile" active-tab="replies" />

            <!-- Feed -->
            <PostList :posts="posts" :show-replies="true" class="border-pixl-light/10 border-t pt-4" />

            <Footer />
        </main>
    </Layout>
</template>
