<script setup>
import { Link } from '@inertiajs/vue3'
import BackArrowIcon from '@/Components/Icons/BackArrowIcon.vue'

defineProps({
    href: {
        type: String,
        required: true,
    },
})
</script>

<template>
    <Link :href="href" class="group flex items-baseline gap-1.5">
        <BackArrowIcon />
        <span><slot>back</slot></span>
    </Link>
</template>
