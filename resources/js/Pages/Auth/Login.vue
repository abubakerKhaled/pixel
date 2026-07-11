<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3'
import { store } from '@/actions/App/Http/Controllers/Auth/SessionsController'
import BackLink from '@/Components/BackLink.vue'
import PixlLogoIcon from '@/Components/Icons/PixlLogoIcon.vue'

// Inertia form state & helper
const form = useForm({
    email: '',
    password: '',
})

// Submit form using Wayfinder action
const submit = () => {
    form.post(store.url(), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>
    <Head title="PIXL | Login" />

    <div class="relative flex min-h-dvh w-full flex-col items-center justify-center bg-pixl-dark text-pixl-light p-4 font-pixl md:overflow-clip">
        <!-- Background image -->
        <div class="fixed inset-0 pointer-events-none overflow-clip">
            <img src="/images/Official-Login-BG.png" alt="" role="presentation"
                class="absolute inset-y-0 left-[15%] h-full w-full mask-l-from-80% object-cover opacity-30" />
            <div class="absolute inset-0 bg-[url(/images/white-noise.gif)] opacity-[0.01]"></div>
        </div>

        <main class="isolate mx-auto w-full max-w-[1000px] xl:max-w-6xl">
            <div class="flex w-full flex-col items-center justify-between gap-8 md:flex-row md:gap-16">
                <!-- Left: Logo + Word Stack -->
                <div class="max-md:mt-4">
                    <div class="flex items-baseline gap-3">
                        <PixlLogoIcon class="w-36" />
                        <div aria-hidden="true" class="relative hidden text-4xl text-pixl uppercase md:block">
                            <div class="absolute bottom-full my-2 flex flex-col gap-2 opacity-20">
                                <div class="flex flex-col gap-2 opacity-50">
                                    <p>Coder</p><p>Art</p><p>Writer</p><p>Media</p><p>Designer</p>
                                    <p>Coder</p><p>Designer</p><p>Art</p><p>Writer</p><p>Coder</p>
                                    <p>Art</p><p>Coder</p><p>Art</p><p>Writer</p>
                                </div>
                                <p>Media</p>
                            </div>
                            <p>Everyone</p>
                            <div class="absolute my-2 flex flex-col gap-2 opacity-20">
                                <p>Coder</p><p>Art</p>
                                <div class="flex flex-col gap-2 opacity-50">
                                    <p>Coder</p><p>Art</p><p>Writer</p><p>Media</p><p>Designer</p>
                                    <p>Coder</p><p>Designer</p><p>Art</p><p>Writer</p><p>Coder</p>
                                    <p>Art</p><p>Coder</p><p>Art</p><p>Writer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Login Form Container -->
                <div class="z-10 w-full max-w-md border border-pixl/30 bg-pixl-dark/80 p-6 backdrop-blur-sm sm:p-8 max-md:mb-16">
                    <!-- Header with Back link and Logo for small devices -->
                    <div class="flex items-center justify-between mb-6">
                        <BackLink href="/">welcome</BackLink>
                        <PixlLogoIcon class="h-5 md:hidden" />
                    </div>

                    <h1 class="text-2xl text-pixl uppercase tracking-wider mb-6 text-center sm:text-left">
                        Sign In
                    </h1>

                    <form @submit.prevent="submit" class="flex flex-col gap-4">
                        <!-- Email -->
                        <div class="flex flex-col gap-1">
                            <label for="email" class="text-xs text-pixl uppercase font-semibold">Email Address</label>
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                autocomplete="username"
                                required
                                placeholder="satoshi@bitcoin.org"
                                class="w-full bg-pixl-dark/60 border border-pixl-light/20 px-3 py-1.5 text-pixl-light placeholder-pixl-light/30 focus:border-pixl focus:outline-none transition-colors duration-200"
                            />
                            <span v-if="form.errors.email" class="text-red-400 text-xs mt-1">
                                {{ form.errors.email }}
                            </span>
                        </div>

                        <!-- Password -->
                        <div class="flex flex-col gap-1">
                            <label for="password" class="text-xs text-pixl uppercase font-semibold">Password</label>
                            <input
                                id="password"
                                v-model="form.password"
                                type="password"
                                autocomplete="current-password"
                                required
                                placeholder="••••••••"
                                class="w-full bg-pixl-dark/60 border border-pixl-light/20 px-3 py-1.5 text-pixl-light placeholder-pixl-light/30 focus:border-pixl focus:outline-none transition-colors duration-200"
                            />
                            <span v-if="form.errors.password" class="text-red-400 text-xs mt-1">
                                {{ form.errors.password }}
                            </span>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="mt-2 border border-transparent bg-pixl px-4 py-2 text-pixl-dark font-semibold uppercase tracking-wider transition-colors duration-200 hover:bg-pixl/90 active:bg-pixl/95 disabled:opacity-50 cursor-pointer text-center font-bold"
                        >
                            {{ form.processing ? 'Signing In...' : 'Sign In' }}
                        </button>
                    </form>

                    <div class="mt-6 text-center text-sm">
                        <span class="text-pixl-light/60">Don't have an account? </span>
                        <Link href="/register" class="text-pixl hover:underline transition-all duration-200">Register</Link>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="relative z-30 pb-3 md:fixed md:inset-x-0 md:bottom-0">
            <div class="flex flex-col items-center gap-1.5 p-4 text-center text-pixl">
                <p>All Rights Reserved. Pixl Media For Everyone*</p>
                <p class="text-xs opacity-50">
                    *except for badgers, they're $&amp;@*holes.
                </p>
                <div class="absolute inset-x-0 bottom-0 h-4 bg-[url(/images/white-noise.gif)] pointer-events-none"></div>
                <svg class="absolute right-4 bottom-8 w-7 grayscale max-sm:hidden" viewBox="0 0 29 43"
                    xmlns="http://www.w3.org/2000/svg" fill="none">
                    <g fill="#ECA749" opacity=".5" style="mix-blend-mode: luminosity">
                        <path
                            d="M7.058 0H0v7.058h7.058V0Zm0 7.058H0v7.059h7.058V7.058ZM28.234 0h-7.058v7.058h7.058V0Zm0 7.059h-7.058v7.058h7.058V7.059ZM7.058 28.233H0v7.059h7.058v-7.059Z">
                        </path>
                        <path d="M7.058 35.291H0v7.059h7.058v-7.06Zm21.176-7.058h-7.058v7.059h7.058v-7.059Z"></path>
                        <path
                            d="M28.234 35.291h-7.058v7.059h7.058v-7.06ZM14.117 21.175H7.059v7.058h7.058v-7.058Zm7.058-7.058h-7.058v7.058h7.058v-7.058Zm-7.058 0H7.059v7.058h7.058v-7.059Zm7.058 7.058h-7.058v7.058h7.058v-7.058Z">
                        </path>
                    </g>
                </svg>
            </div>
        </footer>
    </div>
</template>
