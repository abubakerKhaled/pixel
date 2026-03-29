<script setup>
import { computed } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'
import Navigation from '@/Components/Navigation.vue'
import Aside from '@/Components/Aside.vue'
import FlashMessage from './FlashMessage.vue'

defineProps({
    title: {
        type: String,
        default: 'PIXL',
    },
})

const artistsToFollow = computed(() => usePage().props.artistsToFollow ?? [])
</script>

<template>
    <Head :title="title" />

    <div class="bg-pixl-dark text-pixl-light flex gap-8 px-4 sm:h-screen sm:overflow-hidden xl:gap-16">
        <Navigation />

        <!-- Page content injected here via slot -->
        <slot />

        <Aside :artists-to-follow="artistsToFollow" />

        <FlashMessage />
    </div>
</template>
