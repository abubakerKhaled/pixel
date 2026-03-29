<script setup>
import Layout from '@/Components/Layout.vue'
import PostForm from '@/Components/PostForm.vue'
import Post from '@/Components/Post.vue'
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
            <div class="w-full">
                <nav class="overflow-x-auto [scrollbar-width:none]">
                    <ul class="flex min-w-max justify-end gap-8 text-sm">
                        <li><a href="#">For you</a></li>
                        <li>
                            <a class="text-pixl-light/60 hover:text-pixl-light/80" href="#">Idea streams</a>
                        </li>
                        <li>
                            <a class="text-pixl-light/60 hover:text-pixl-light/80" href="#">Following</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Post prompt -->
            <PostForm />

            <!-- Feed -->
            <ol class="mt-4">
                <Post v-for="item in posts" :key="item.id" :post="item" />
            </ol>

            <Footer />
        </main>
    </Layout>
</template>
