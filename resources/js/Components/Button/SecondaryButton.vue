<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

withDefaults(
    defineProps<{
        type?: "button" | "submit" | "reset";
        href?: string;
    }>(),
    {
        type: "button",
    }
);
</script>

<template>
    <component
        :is="href ? Link : 'button'"
        :href="href"
        :type="type"
        class="inline-flex items-center px-4 py-3 font-medium text-gray-500 transition duration-150 ease-in-out bg-gray-100 rounded-lg whitespace-nowrap hover:bg-gray-200 focus:outline-none disabled:opacity-25"
    >
        <slot />
    </component>
</template>
