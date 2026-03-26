<script setup>
import CommentIcon from '@/Components/Icons/CommentIcon.vue'

defineProps({
    count: {
        type: Number,
        default: 0,
    },
})

const emit = defineEmits(['click'])
</script>

<template>
    <div class="flex items-center gap-1">
        <button aria-label="Comment" class="hover:text-pixl" @click="emit('click')">
            <CommentIcon />
        </button>
        <span class="text-sm">{{ count }}</span>
    </div>
</template>
