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
        class="px-4 py-3 transition bg-gray-100 border-0 rounded-lg focus:bg-gray-200 focus:ring-0 placeholder:font-medium"
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
