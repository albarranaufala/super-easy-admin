<script setup lang="ts">
import { SelectOption } from "@/types";
import { computed } from "vue";
import vSelect from "vue-select";

const props = withDefaults(
    defineProps<{
        modelValue: string | number;
        options?: Array<SelectOption>;
        filterable?: boolean;
    }>(),
    {
        filterable: true,
    }
);

const emit = defineEmits<{
    (e: "update:modelValue", value: string | number): void;
    (e: "search", search: string, loading: (loading: boolean) => void): void;
}>();

const value = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit("update:modelValue", value);
    },
});

const search = (search: string, loading: (loading: boolean) => void) => {
    emit("search", search, loading);
};
</script>

<template>
    <vSelect
        v-model="value"
        :options="options"
        :filterable="filterable"
        :reduce="(option: SelectOption) => option.value"
        @search="search"
        class="vue-select"
    />
</template>

<style src="vue-select/dist/vue-select.css"></style>

<style>
.vue-select .vs__dropdown-toggle {
    @apply bg-gray-100 border-0 rounded-lg p-0;
}

.vue-select .vs__selected-options {
    @apply relative p-0;
}

.vue-select .vs__search {
    @apply pl-4 pr-0 py-3 text-base mt-0 placeholder:font-medium placeholder:text-gray-400;
}

.vue-select .vs__selected {
    @apply m-0 pl-4 pr-0 py-3 absolute inset-0 whitespace-nowrap truncate;
}

.vue-select .vs__actions {
    @apply py-0 pl-4;
}

.vue-select .vs__actions > * {
    @apply mr-4;
}

.vue-select .vs__clear,
.vue-select .vs__open-indicator {
    @apply fill-gray-400;
}

.vue-select .vs__dropdown-menu {
    @apply border-0 rounded-lg;
}

.vue-select .vs__dropdown-option,
.vue-select .vs__no-options {
    @apply px-4 py-3;
}
</style>
