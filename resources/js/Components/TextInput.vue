<script setup lang="ts">
import { onMounted, ref } from "vue";

defineProps<{
    modelValue: string;
}>();

defineEmits(["update:modelValue"]);

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute("autofocus")) {
        input.value?.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
    <input
        class="px-4 py-3 border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500"
        :value="modelValue"
        @input="
            $emit(
                'update:modelValue',
                ($event.target as HTMLInputElement).value
            )
        "
        ref="input"
    />
</template>
