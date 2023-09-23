<script setup lang="ts">
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Sidebar from "@/Components/Sidebar/Sidebar.vue";

const page = usePage();

const showingSideNav = ref(false);
</script>

<template>
    <div class="flex min-h-screen bg-gray-50">
        <Sidebar
            class="w-full transform transition duration-200 inset-y-0 left-0 z-20 h-screen max-w-[300px] fixed lg:block lg:sticky lg:top-0 lg:translate-x-0"
            :class="{
                '': showingSideNav,
                '-translate-x-full': !showingSideNav,
            }"
        />
        <div class="flex-1 min-w-0">
            <header class="sticky top-0 z-10 bg-white border-b">
                <!-- Primary Navigation Menu -->
                <div class="px-4">
                    <div class="flex justify-between h-20">
                        <!-- Left -->
                        <div class="flex items-center">
                            <!-- Hamburger -->
                            <div class="flex items-center lg:hidden">
                                <button
                                    @click="showingSideNav = !showingSideNav"
                                    class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        stroke="currentColor"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            :class="{
                                                hidden: showingSideNav,
                                                'inline-flex': !showingSideNav,
                                            }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"
                                        />
                                        <path
                                            :class="{
                                                hidden: !showingSideNav,
                                                'inline-flex': showingSideNav,
                                            }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Right -->
                        <div class="flex items-center ml-6">
                            <!-- Notifications -->
                            <button class="px-3 py-2 text-gray-700">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"
                                    />
                                </svg>
                            </button>

                            <div
                                class="w-[1px] h-[20px] bg-gray-300 mx-1"
                            ></div>

                            <!-- Settings Dropdown -->
                            <div class="relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 text-gray-700 transition duration-150 ease-in-out focus:outline-none"
                                            >
                                                <img
                                                    src="https://i.pravatar.cc/300"
                                                    alt="Avatar"
                                                    class="w-8 h-8 rounded-full"
                                                />
                                                <div class="ml-4 text-left">
                                                    <p
                                                        class="text-sm font-medium"
                                                    >
                                                        {{
                                                            page.props.auth.user
                                                                .name
                                                        }}
                                                    </p>
                                                    <p
                                                        class="text-xs text-gray-400"
                                                    >
                                                        {{
                                                            page.props.auth.user
                                                                .role.name
                                                        }}
                                                    </p>
                                                </div>

                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.5"
                                                    stroke="currentColor"
                                                    class="w-5 h-5 ml-4"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <Transition
                enter-active-class="transition"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <button
                    v-if="showingSideNav"
                    class="fixed inset-0 z-10 bg-black/50"
                    @click="showingSideNav = false"
                ></button>
            </Transition>

            <!-- Page Content -->
            <main class="container w-full p-6 mx-auto lg:p-8">
                <slot />
            </main>

            <!-- Footer -->
            <footer class="container px-6 pb-6 mx-auto lg:px-8 lg:pb-8">
                <p class="text-sm">
                    <span class="font-semibold text-gray-400"
                        >{{ new Date().getFullYear() }}©</span
                    >&nbsp;
                    <a
                        href="https://albarranaufala.github.io"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="hover:text-indigo-500"
                        >Albarra Naufala</a
                    >
                </p>
            </footer>
        </div>
    </div>
</template>
