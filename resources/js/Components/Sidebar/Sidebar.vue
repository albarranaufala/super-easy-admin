<script setup lang="ts">
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import SidebarLink from "@/Components/Sidebar/SidebarLink.vue";
import { Link } from "@inertiajs/vue3";
import Accordion from "@/Components/Accordion.vue";
</script>

<template>
    <aside class="overflow-auto bg-gray-900 border-r">
        <div
            class="flex items-center h-20 px-6 border-b border-gray-600 border-dashed"
        >
            <Link :href="route('dashboard')">
                <ApplicationLogo class="text-white" />
            </Link>
        </div>
        <nav class="p-6">
            <SidebarLink
                :href="route('dashboard')"
                :active="route().current('dashboard')"
                class="w-full"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 mr-3"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                    />
                </svg>
                Dashboard
            </SidebarLink>
            <SidebarLink
                :href="route('users.index')"
                :active="route().current('users.index')"
                class="w-full mt-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 mr-3"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
                    />
                </svg>

                Users
            </SidebarLink>
            <SidebarLink
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
                    class="w-6 h-6 mr-3"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"
                    />
                </svg>

                Roles
            </SidebarLink>
            <Accordion :open="route().current('modules.index')" class="mt-2">
                <template #trigger="{ open }">
                    <SidebarLink
                        class="inline-flex items-center justify-between w-full p-4 font-medium leading-5 text-gray-500 transition duration-150 ease-in-out rounded-lg hover:bg-gray-800 hover:text-white focus:outline-none"
                    >
                        <div class="flex items-center">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6 mr-3"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"
                                />
                            </svg>

                            Module
                        </div>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6 ml-3"
                            :class="{ 'rotate-180': open }"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                            />
                        </svg>
                    </SidebarLink>
                </template>

                <template #content>
                    <SidebarLink
                        :href="route('modules.index')"
                        :active="route().current('modules.index')"
                        class="w-full mt-2"
                    >
                        <span class="w-6 mr-3 text-center"> &#x2022; </span>
                        Manage Modules
                    </SidebarLink>
                    <SidebarLink
                        :href="route('dashboard')"
                        :active="false"
                        class="w-full mt-2"
                    >
                        <span class="w-6 mr-3 text-center"> &#x2022; </span>
                        Events
                    </SidebarLink>
                    <SidebarLink
                        :href="route('dashboard')"
                        :active="false"
                        class="w-full mt-2"
                    >
                        <span class="w-6 mr-3 text-center"> &#x2022; </span>
                        Categories
                    </SidebarLink>
                    <SidebarLink
                        :href="route('dashboard')"
                        :active="false"
                        class="w-full mt-2"
                    >
                        <span class="w-6 mr-3 text-center"> &#x2022; </span>
                        Articles
                    </SidebarLink>
                </template>
            </Accordion>
        </nav>
    </aside>
</template>
