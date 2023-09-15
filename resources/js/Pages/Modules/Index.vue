<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Add New Module" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Manage Modules
                </h2>
                <div class="mt-6 overflow-hidden bg-white shadow-sm rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
