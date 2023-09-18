<script lang="ts" setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps<{
    from: number;
    to: number;
    total: number;
    links: Array<{
        url?: string;
        label: string;
        active: boolean;
    }>;
}>();
</script>

<template>
    <div class="flex items-center justify-between text-sm">
        <span class="text-gray-500">
            Showing {{ from }} to {{ to }} of {{ total }} results
        </span>
        <div class="flex items-center">
            <template v-for="(link, i) in links">
                <component
                    :is="link.url ? Link : 'div'"
                    :href="link.url"
                    class="inline-block p-2 ml-2 min-w-[36px] font-medium text-center rounded-md"
                    :class="[
                        link.active ? 'bg-indigo-500 text-white' : 'bg-white',
                        link.url && !link.active
                            ? 'transition hover:bg-indigo-50 hover:text-indigo-500'
                            : 'text-gray-300',
                    ]"
                >
                    <svg
                        v-if="i === 0"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="w-5 h-5"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    <template v-else-if="i < links.length - 1">
                        {{ link.label }}
                    </template>
                    <svg
                        v-else
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="w-5 h-5"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </component>
            </template>
        </div>
    </div>
</template>
