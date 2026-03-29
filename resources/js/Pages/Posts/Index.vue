<script setup>
import Layout from '@/Components/Layout.vue'
import PostForm from '@/Components/PostForm.vue'
import Tabs from '@/Components/Tabs.vue'
import PostList from '@/Components/PostList.vue'
import Footer from '../../Components/Footer.vue';

defineProps({
    posts: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <Layout title="PIXL - Home">
        <main class="-mx-4 flex grow flex-col min-h-0 gap-4 overflow-y-auto px-4 py-4">
            <Tabs>
                <li><a href="#">For you</a></li>
                <li>
                    <a class="text-pixl-light/60 hover:text-pixl-light/80" href="#">Idea streams</a>
                </li>
                <li>
                    <a class="text-pixl-light/60 hover:text-pixl-light/80" href="#">Following</a>
                </li>
            </Tabs>

            <!-- Post prompt -->
            <PostForm />

            <!-- Feed -->
            <PostList :posts="posts" class="mt-4" />

            <Footer />
        </main>
    </Layout>
</template>
