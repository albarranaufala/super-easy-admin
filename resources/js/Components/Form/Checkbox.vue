<script setup lang="ts">
import { computed } from "vue";

const emit = defineEmits(["update:checked"]);

const props = defineProps<{
    checked: boolean;
    value?: any;
}>();

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit("update:checked", val);
    },
});
</script>

<template>
    <input
        type="checkbox"
        :value="value"
        v-model="proxyChecked"
        class="w-5 h-5 text-indigo-500 bg-gray-100 border-0 rounded-md"
    />
</template>
