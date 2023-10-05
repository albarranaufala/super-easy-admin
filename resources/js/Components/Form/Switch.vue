<script setup lang="ts">
import { computed } from "vue";

const props = withDefaults(
    defineProps<{
        modelValue: string | boolean | number;
        id: string;
    }>(),
    {
        id: (Math.random() + 1).toString(36).substring(7),
    }
);

const emit = defineEmits(["update:modelValue"]);

const value = computed({
    get() {
        if (typeof props.modelValue === "string") {
            return ["1", "true", "yes", "y"].includes(props.modelValue);
        }

        if (typeof props.modelValue === "number") {
            return Boolean(props.modelValue);
        }

        return props.modelValue;
    },

    set(val) {
        emit("update:modelValue", val);
    },
});
</script>

<template>
    <label :for="id" class="inline-flex items-center cursor-pointer">
        <!-- toggle -->
        <div class="relative">
            <!-- input -->
            <input type="checkbox" :id="id" v-model="value" class="sr-only" />
            <!-- line -->
            <div
                class="block h-8 bg-gray-300 rounded-full background w-14"
            ></div>
            <!-- dot -->
            <div
                class="absolute w-6 h-6 transition bg-white rounded-full dot left-1 top-1"
            ></div>
        </div>
    </label>
</template>

<style scoped>
input:checked ~ .dot {
    @apply translate-x-full;
}

input:checked ~ .background {
    @apply bg-indigo-500;
}
</style>
