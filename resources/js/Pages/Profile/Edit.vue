<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'
import BackLink from '@/Components/BackLink.vue'
import { update } from '@/actions/App/Http/Controllers/ProfileController'
import { show as profileShow } from '@/actions/App/Http/Controllers/ProfileController'

const props = defineProps({
    profile: {
        type: Object,
        required: true,
    },
})

// Bind form state with existing profile values, plus empty password field
const form = useForm({
    name: props.profile.display_name,
    handle: props.profile.handle,
    bio: props.profile.bio || '',
    password: '',
})

const submit = () => {
    form.put(update.url(), {
        onSuccess: () => {
            form.reset('password')
        },
        onFinish: () => {
            form.reset('password')
        },
    })
}
</script>

<template>
    <Layout title="PIXL - Edit Profile">
        <main class="-mx-4 flex grow flex-col min-h-0 gap-4 overflow-y-auto px-4 py-4 font-pixl">
            <div class="mx-auto w-full max-w-lg mt-4 flex flex-col gap-4">
                <!-- Back to profile link -->
                <BackLink :href="profileShow.url(profile)" />

                <div class="w-full border border-pixl/30 bg-pixl-dark/80 p-6 backdrop-blur-sm sm:p-8">
                    <h1 class="text-2xl text-pixl uppercase tracking-wider mb-6">
                        Edit Profile
                    </h1>

                <form @submit.prevent="submit" class="flex flex-col gap-5">
                    <!-- Name -->
                    <div class="flex flex-col gap-1.5">
                        <label for="name" class="text-xs text-pixl uppercase font-semibold">Name</label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            placeholder="e.g. Satoshi Nakamoto"
                            class="w-full bg-pixl-dark/60 border border-pixl-light/20 px-3 py-2 text-pixl-light placeholder-pixl-light/30 focus:border-pixl focus:outline-none transition-colors duration-200"
                        />
                        <span v-if="form.errors.name" class="text-red-400 text-xs mt-1">
                            {{ form.errors.name }}
                        </span>
                    </div>

                    <!-- Handle -->
                    <div class="flex flex-col gap-1.5">
                        <label for="handle" class="text-xs text-pixl uppercase font-semibold">Handle</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3 text-pixl-light/40">@</span>
                            <input
                                id="handle"
                                v-model="form.handle"
                                type="text"
                                required
                                placeholder="username"
                                class="w-full bg-pixl-dark/60 border border-pixl-light/20 pl-8 pr-3 py-2 text-pixl-light placeholder-pixl-light/30 focus:border-pixl focus:outline-none transition-colors duration-200"
                            />
                        </div>
                        <span v-if="form.errors.handle" class="text-red-400 text-xs mt-1">
                            {{ form.errors.handle }}
                        </span>
                    </div>

                    <!-- Bio -->
                    <div class="flex flex-col gap-1.5">
                        <label for="bio" class="text-xs text-pixl uppercase font-semibold">Bio</label>
                        <textarea
                            id="bio"
                            v-model="form.bio"
                            rows="4"
                            placeholder="Tell us about yourself..."
                            class="w-full bg-pixl-dark/60 border border-pixl-light/20 px-3 py-2 text-pixl-light placeholder-pixl-light/30 focus:border-pixl focus:outline-none transition-colors duration-200 resize-y"
                        ></textarea>
                        <span v-if="form.errors.bio" class="text-red-400 text-xs mt-1">
                            {{ form.errors.bio }}
                        </span>
                    </div>

                    <!-- Security Divider & Current Password -->
                    <div class="border-t border-pixl-light/10 pt-4 mt-2">
                        <h2 class="text-sm text-pixl uppercase tracking-wider mb-3">
                            Confirm Password to Save
                        </h2>
                        <div class="flex flex-col gap-1.5">
                            <label for="password" class="text-xs text-pixl-light/60 uppercase font-semibold">Current Password</label>
                            <input
                                id="password"
                                v-model="form.password"
                                type="password"
                                required
                                placeholder="••••••••"
                                class="w-full bg-pixl-dark/60 border border-pixl-light/20 px-3 py-2 text-pixl-light placeholder-pixl-light/30 focus:border-pixl focus:outline-none transition-colors duration-200"
                            />
                            <span v-if="form.errors.password" class="text-red-400 text-xs mt-1">
                                {{ form.errors.password }}
                            </span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="mt-4 border border-transparent bg-pixl px-4 py-2.5 text-pixl-dark font-bold uppercase tracking-wider transition-colors duration-200 hover:bg-pixl/90 active:bg-pixl/95 disabled:opacity-50 cursor-pointer text-center"
                    >
                        {{ form.processing ? 'Saving...' : 'Save Changes' }}
                    </button>
                </form>
            </div>
        </div>
    </main>
</Layout>
</template>
