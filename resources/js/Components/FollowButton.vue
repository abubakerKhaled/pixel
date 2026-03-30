<script setup>
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { follow as followAction, unfollow as unfollowAction } from '@/actions/App/Http/Controllers/ProfileController'

const props = defineProps({
    profile: { type: Object, required: true },
    initialFollowing: { type: Boolean, default: false },
})

const following = ref(props.initialFollowing)

const toggle = () => {
    const action = following.value ? unfollowAction : followAction
    following.value = !following.value
    

    router.post(action.url(props.profile), {}, {
        preserveScroll: true,
        onError: () => {
            following.value = !following.value;
        }
    })
}
</script>

<template>
    <button data-test="follow-button" type="button" @click="toggle"
        class="bg-pixl-dark/50 hover:bg-pixl-dark/60 active:bg-pixl-dark/75 border-pixl/50 hover:border-pixl/60 active:border-pixl/75 text-pixl border px-2 py-1 text-sm">
        {{ following ? 'Unfollow' : 'Follow' }}
    </button>
</template>
