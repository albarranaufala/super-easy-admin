<script setup lang="ts">
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import { Link } from "@inertiajs/vue3";

const showingSideNav = ref(false);
</script>

<template>
    <div>
        <div class="flex min-h-screen bg-gray-100">
            <aside
                class="w-full h-screen max-w-[300px] overflow-auto bg-white border-r sm:block sm:sticky sm:top-0"
                :class="{
                    'fixed inset-y-0 left-0 z-20': showingSideNav,
                    hidden: !showingSideNav,
                }"
            >
                <nav class="p-6">
                    <div class="flex justify-center">
                        <Link :href="route('dashboard')">
                            <ApplicationLogo />
                        </Link>
                    </div>
                    <NavLink
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                        class="w-full mt-6"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6 mr-2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                            />
                        </svg>
                        Dashboard
                    </NavLink>
                    <NavLink
                        :href="route('dashboard')"
                        :active="false"
                        class="w-full mt-2"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6 mr-2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
                            />
                        </svg>

                        Users
                    </NavLink>
                    <NavLink
                        :href="route('dashboard')"
                        :active="false"
                        class="w-full mt-2"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6 mr-2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"
                            />
                        </svg>

                        Roles
                    </NavLink>
                    <NavLink
                        :href="route('dashboard')"
                        :active="false"
                        class="w-full mt-2"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6 mr-2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"
                            />
                        </svg>

                        Data
                    </NavLink>
                </nav>
            </aside>
            <div class="flex-1">
                <header class="sticky top-0 bg-white border-b">
                    <!-- Primary Navigation Menu -->
                    <div class="px-4">
                        <div class="flex justify-between h-16">
                            <!-- Left -->
                            <div class="flex items-center">
                                <!-- Hamburger -->
                                <div class="flex items-center sm:hidden">
                                    <button
                                        @click="
                                            showingSideNav = !showingSideNav
                                        "
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
                                                    'inline-flex':
                                                        !showingSideNav,
                                                }"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M4 6h16M4 12h16M4 18h16"
                                            />
                                            <path
                                                :class="{
                                                    hidden: !showingSideNav,
                                                    'inline-flex':
                                                        showingSideNav,
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
                                    class="w-[1px] h-[20px] bg-gray-300 mx-4"
                                ></div>

                                <!-- Settings Dropdown -->
                                <div class="relative">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <span
                                                class="inline-flex rounded-md"
                                            >
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-2 text-gray-700 transition duration-150 ease-in-out bg-white rounded-md focus:outline-none"
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
                                                                $page.props.auth
                                                                    .user.name
                                                            }}
                                                        </p>
                                                        <p
                                                            class="text-xs text-gray-400"
                                                        >
                                                            Superadmin
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

                <button
                    v-if="showingSideNav"
                    class="fixed inset-0 z-10 bg-black/50"
                    @click="showingSideNav = false"
                ></button>

                <!-- Page Heading -->
                <header class="bg-white border-b" v-if="$slots.header">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page Content -->
                <main>
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
