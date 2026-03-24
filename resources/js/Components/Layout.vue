<script setup>
import { Head } from '@inertiajs/vue3'
import Navigation from '@/Components/Navigation.vue'
import Aside from '@/Components/Aside.vue'

defineProps({
    title: {
        type: String,
        default: 'PIXL',
    },
    artistsToFollow: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <Head :title="title" />

    <div class="bg-pixl-dark text-pixl-light flex gap-8 px-4 sm:h-dvh sm:overflow-clip xl:gap-16">
        <Navigation />

        <!-- Page content injected here via slot -->
        <slot />

        <Aside :artists-to-follow="artistsToFollow" />
    </div>
</template>
