<script setup>
import { ref, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'

const show = ref(false)
const message = ref('')

watch(
    () => usePage().props.flash.success,
    (newMessage) => {
        if (newMessage) {
            message.value = newMessage
            show.value = true

            setTimeout(() => {
                show.value = false
            }, 3000)
        }
    },
    { immediate: true }
)
</script>


<template>
    <Transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0 translate-x-12"
        enter-to-class="opacity-100 translate-x-0" leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100 translate-x-0" leave-to-class="opacity-0 translate-x-12">
        <div v-if="show" class="fixed bottom-4 right-4 bg-pixl text-pixl-light px-6 py-3 rounded-lg shadow-lg">
            {{ message }}
        </div>
    </Transition>
</template>