<script setup lang="ts">
withDefaults(
    defineProps<{
        type?: "button" | "submit" | "reset";
    }>(),
    {
        type: "button",
    }
);
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-3 font-semibold text-gray-500 transition duration-150 ease-in-out bg-gray-100 rounded-lg whitespace-nowrap hover:bg-gray-200 focus:outline-none disabled:opacity-25"
    >
        <slot />
    </button>
</template>
