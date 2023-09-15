<script setup lang="ts">
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps<{
    href: string;
    active?: boolean;
}>();
</script>

<template>
    <Link
        :href="href"
        class="inline-flex items-center p-4 font-medium leading-5 text-gray-500 transition duration-150 ease-in-out rounded-lg hover:bg-gray-100 hover:text-indigo-500 focus:outline-none"
        :class="{ 'bg-gray-100 text-indigo-500': active }"
    >
        <slot />
    </Link>
</template>
