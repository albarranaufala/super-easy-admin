<script lang="ts" setup>
import { computed } from "vue";

const props = defineProps({
    perPage: {
        type: Number,
        required: true,
    },
    total: {
        type: Number,
        required: true,
    },
    modelValue: {
        type: Number,
        default: () => 1,
    },
});

const emit = defineEmits(["update:modelValue"]);

const currentPage = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit("update:modelValue", value);
    },
});

const pagesCount = computed(() => {
    if (!props.perPage) {
        return 0;
    }
    return Math.ceil(props.total / props.perPage);
});

const firstDataNumber = computed(() => {
    return (currentPage.value - 1) * props.perPage + 1;
});

const lastDataNumber = computed(() => {
    const lastDataNumber = firstDataNumber.value + props.perPage - 1;
    return lastDataNumber > props.total ? props.total : lastDataNumber;
});

const changePage = (newPage: number) => {
    if (newPage < 1 || newPage > pagesCount.value) {
        return;
    }
    currentPage.value = newPage;
};

const visiblePages = computed(() => {
    const visiblePages = [];
    let start = 1;
    let end = pagesCount.value;

    if (pagesCount.value <= 9) {
        for (let i = 1; i <= pagesCount.value; i++) {
            visiblePages.push(i);
        }
    } else if (currentPage.value <= 5) {
        for (let i = 1; i <= 7; i++) {
            visiblePages.push(i);
        }
        visiblePages.push("...");
        visiblePages.push(pagesCount.value);
    } else if (currentPage.value >= pagesCount.value - 4) {
        visiblePages.push(1);
        visiblePages.push("...");
        for (let i = pagesCount.value - 6; i <= pagesCount.value; i++) {
            visiblePages.push(i);
        }
    } else {
        visiblePages.push(1);
        visiblePages.push("...");
        start = currentPage.value - 2;
        end = currentPage.value + 2;
        for (let i = start; i <= end; i++) {
            visiblePages.push(i);
        }
        visiblePages.push("...");
        visiblePages.push(pagesCount.value);
    }

    return visiblePages;
});
</script>

<template>
    <div
        v-if="pagesCount > 1"
        class="flex items-center justify-between text-sm"
    >
        <span class="text-gray-500">
            Showing {{ firstDataNumber }} to {{ lastDataNumber }} of
            {{ total }} results
        </span>
        <div>
            <button
                class="w-8 h-8 p-1 mr-2 rounded-md"
                @click="changePage(currentPage - 1)"
            >
                &lt;
            </button>
            <template v-for="page in visiblePages">
                <template v-if="typeof page === 'number'">
                    <button
                        class="w-8 h-8 p-1 mr-2 rounded-md"
                        :class="[
                            page === currentPage
                                ? 'bg-indigo-500 text-white'
                                : 'bg-white',
                        ]"
                        @click="changePage(page)"
                    >
                        {{ page }}
                    </button>
                </template>
                <template v-else>
                    <span
                        class="inline-block w-8 h-8 p-1 mr-2 text-center rounded-md"
                    >
                        {{ page }}
                    </span>
                </template>
            </template>
            <button
                class="w-8 h-8 p-1 rounded-md"
                @click="changePage(currentPage + 1)"
            >
                &gt;
            </button>
        </div>
    </div>
</template>
