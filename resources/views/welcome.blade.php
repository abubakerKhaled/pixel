<!-- index.html -->
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="color-scheme" content="dark" />
    <meta name="description"
        content="Pixel - The premier platform for creative professionals. Join the community of coders, artists, writers, and designers." />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://pixel.media/" />
    <meta property="og:title" content="Pixel | A place for the cool squares." />
    <meta property="og:description"
        content="The premier platform for creative professionals. Join the community of coders, artists, writers, and designers." />
    <meta property="og:image" content="/images/og-image.png" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://pixel.media/" />
    <meta property="twitter:title" content="Pixel | A place for the cool squares." />
    <meta property="twitter:description"
        content="The premier platform for creative professionals. Join the community of coders, artists, writers, and designers." />
    <meta property="twitter:image" content="/images/og-image.png" />

    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Pixel | A place for the cool squares.</title>
</head>

<body class="relative flex h-dvh w-full flex-col bg-pixl-dark text-pixl-light md:block md:overflow-clip">
    <!-- Background image -->
    <div class="fixed inset-0 overflow-clip">
        <img src="/images/Official-Login-BG.png" alt="" role="presentation"
            class="absolute inset-y-0 left-[15%] h-full w-full mask-l-from-80% object-cover opacity-30" />
    </div>

    <main class="isolate mx-auto grid max-w-[1000px] grow place-items-center max-md:pt-16 md:h-full xl:max-w-6xl">
        <div class="gap:8 flex w-full flex-col items-center justify-between md:flex-row md:gap-16">
            <!-- Logo + Word Stack -->
            <div>
                <div class="flex items-baseline gap-3">
                    <svg class="w-36" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 182 61" fill="none">
                        <path fill="#EEE" d="M10.083 0H0v10.083h10.083V0Zm10.084 0H10.084v10.083h10.083V0Z"></path>
                        <path fill="#EEE"
                            d="M30.25 0H20.165v10.083h10.083V0ZM10.083 10.083H0v10.084h10.083V10.083Zm30.25 0H30.25v10.084h10.083V10.083Zm-30.25 10.084H0V30.25h10.083V20.167Zm30.25 0H30.25V30.25h10.083V20.167ZM10.083 30.25H0v10.083h10.083V30.25Zm10.084 0H10.084v10.083h10.083V30.25Z">
                        </path>
                        <path fill="#EEE"
                            d="M30.25 30.25H20.165v10.083h10.083V30.25ZM10.083 40.333H0v10.084h10.083V40.333Zm0 10.084H0V60.5h10.083V50.417ZM60.5 0H50.415v10.083h10.083V0Zm10.083 0H60.5v10.083h10.083V0Zm10.084 0H70.584v10.083h10.083V0ZM70.583 10.083H60.5v10.084h10.083V10.083Zm0 10.084H60.5V30.25h10.083V20.167Zm0 10.083H60.5v10.083h10.083V30.25Zm0 10.083H60.5v10.084h10.083V40.333Zm0 10.084H60.5V60.5h10.083V50.417ZM60.5 50.416H50.415V60.5h10.083V50.416Zm20.167 0H70.584V60.5h10.083V50.416Z">
                        </path>
                        <path fill="#ECA749"
                            d="M100.833 0H90.75v10.083h10.083V0Zm0 10.083H90.75v10.084h10.083V10.083ZM131.083 0H121v10.083h10.083V0Zm0 10.083H121v10.084h10.083V10.083Zm-30.25 30.25H90.75v10.084h10.083V40.333Zm0 10.084H90.75V60.5h10.083V50.417Zm30.25-10.084H121v10.084h10.083V40.333Zm0 10.084H121V60.5h10.083V50.417ZM110.917 30.25h-10.083v10.083h10.083V30.25Zm10.082-10.084h-10.083V30.25h10.083V20.166Z">
                        </path>
                        <path fill="#ECA749"
                            d="M110.917 20.166h-10.083V30.25h10.083V20.166Zm10.082 10.084h-10.083v10.083h10.083V30.25Z">
                        </path>
                        <path fill="#EEE"
                            d="M151.249 0h-10.083v10.083h10.083V0Zm0 10.084h-10.083v10.083h10.083V10.083Z"></path>
                        <path fill="#EEE"
                            d="M151.249 20.166h-10.083V30.25h10.083V20.166Zm0 10.084h-10.083v10.083h10.083V30.25Zm0 10.084h-10.083v10.083h10.083V40.333Z">
                        </path>
                        <path fill="#EEE"
                            d="M151.249 50.416h-10.083V60.5h10.083V50.416Zm10.084.001H151.25V60.5h10.083V50.417Zm10.084-.001h-10.083V60.5h10.083V50.416Z">
                        </path>
                        <path fill="#EEE" d="M181.499 50.416h-10.083V60.5h10.083V50.416Z"></path>
                    </svg>
                    <div aria-hidden="true" class="relative hidden text-4xl text-pixl uppercase md:block">
                        <div class="absolute bottom-full my-2 flex flex-col gap-2 opacity-20">
                            <div class="flex flex-col gap-2 opacity-50">
                                <p>Coder</p>
                                <p>Art</p>
                                <p>Writer</p>
                                <p>Media</p>
                                <p>Designer</p>
                                <p>Coder</p>
                                <p>Designer</p>
                                <p>Art</p>
                                <p>Writer</p>
                                <p>Coder</p>
                                <p>Art</p>
                                <p>Coder</p>
                                <p>Art</p>
                                <p>Writer</p>
                            </div>
                            <p>Media</p>
                        </div>
                        <p>Everyone</p>
                        <div class="absolute my-2 flex flex-col gap-2 opacity-20">
                            <p>Coder</p>
                            <p>Art</p>
                            <div class="flex flex-col gap-2 opacity-50">
                                <p>Coder</p>
                                <p>Art</p>
                                <p>Writer</p>
                                <p>Media</p>
                                <p>Designer</p>
                                <p>Coder</p>
                                <p>Designer</p>
                                <p>Art</p>
                                <p>Writer</p>
                                <p>Coder</p>
                                <p>Art</p>
                                <p>Coder</p>
                                <p>Art</p>
                                <p>Writer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="max-w-full pb-16 min-[360px]:w-72 sm:w-80">
                <div class="text-center text-2xl text-pixl sm:text-3xl md:text-left">
                    A place for the cool squares.
                </div>
                <div class="mt-8 flex flex-col gap-3 text-center sm:mt-12 md:mt-16 md:w-68">
                    <a class="border border-pixl/50 bg-pixl-dark/50 px-4 py-1.5 text-pixl transition-all duration-200 hover:border-pixl/60 hover:bg-pixl-dark/60 active:border-pixl/75 active:bg-pixl-dark/75"
                        href="/feed" role="button">Sign in with Google</a>
                    <a class="border border-pixl/50 bg-pixl-dark/50 px-4 py-1.5 text-pixl transition-all duration-200 hover:border-pixl/60 hover:bg-pixl-dark/60 active:border-pixl/75 active:bg-pixl-dark/75"
                        href="/feed" role="button">Sign in with Apple</a>
                    <p>or</p>
                    <a class="border border-transparent bg-pixl px-4 py-1.5 text-pixl-dark transition-all duration-200 hover:bg-pixl/90 active:bg-pixl/95"
                        href="/feed" role="button">Create an Account</a>
                    <p class="mt-12 text-left text-sm sm:mt-16 md:mt-20">
                        Already have an account?
                    </p>
                    <a class="border border-transparent bg-pixl px-4 py-1.5 text-pixl-dark transition-all duration-200 hover:bg-pixl/90 active:bg-pixl/95"
                        href="/feed" role="button">Sign in</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-30 pb-3 md:fixed md:inset-x-0 md:bottom-0">
        <div class="flex flex-col items-center gap-1.5 p-4 text-center text-pixl">
            <p>All Rights Reserved. Pixl Media For Everyone*</p>
            <p class="text-xs opacity-50">
                *except for badgers, they’re $&@*holes.
            </p>

            <!-- White noise -->
            <div class="absolute inset-x-0 bottom-0 h-4 bg-[url(/images/white-noise.gif)]"></div>
            <!-- Pictogram -->
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
</body>

</html>
