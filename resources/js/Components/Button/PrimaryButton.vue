<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

defineProps<{
    href?: string;
}>();
</script>

<template>
    <component
        :is="href ? Link : 'button'"
        :href="href"
        class="inline-flex items-center px-4 py-3 font-medium text-white transition duration-150 ease-in-out bg-indigo-500 rounded-lg whitespace-nowrap hover:bg-indigo-600 focus:outline-none disabled:opacity-25"
    >
        <slot />
    </component>
</template>
