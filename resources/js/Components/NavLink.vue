<script setup lang="ts">
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps<{
    href: string;
    active?: boolean;
}>();

const classes = computed(() =>
    props.active
        ? "inline-flex items-center p-4 rounded-lg bg-gray-100 text-indigo-500 font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out"
        : "inline-flex items-center p-4 rounded-lg font-medium leading-5 text-gray-500 hover:bg-gray-100 hover:text-indigo-500 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out"
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
