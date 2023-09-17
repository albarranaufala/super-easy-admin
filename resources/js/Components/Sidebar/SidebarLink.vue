<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

defineProps<{
    href?: string;
    active?: boolean;
}>();
</script>

<template>
    <component
        :is="href ? Link : 'button'"
        :href="href"
        class="inline-flex items-center p-4 font-semibold leading-5 text-gray-500 transition duration-150 ease-in-out rounded-lg hover:bg-gray-800 hover:text-white focus:outline-none"
        :class="{ 'bg-gray-800 text-white': active }"
    >
        <slot />
    </component>
</template>
