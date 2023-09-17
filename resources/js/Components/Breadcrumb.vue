<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

defineProps<{
    links: { name: string; href: string }[];
}>();
</script>
<template>
    <ul class="text-sm font-semibold text-gray-400">
        <li v-for="(link, index) in links" class="inline-block mr-2">
            <Link
                :href="link.href"
                class="transition hover:text-indigo-500"
                :class="{ 'text-indigo-500': index === links.length - 1 }"
                >{{ link.name }}</Link
            >
            <span v-if="index !== links.length - 1" class="ml-2"> / </span>
        </li>
    </ul>
</template>
