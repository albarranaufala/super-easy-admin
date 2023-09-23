<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import Card from "@/Components/Card/Card.vue";
import CardBody from "@/Components/Card/CardBody.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { PaginatedData, Module } from "@/types";
import Empty from "@/Components/Empty.vue";

const search = ref("");

defineProps<{
    modules: PaginatedData<Module>;
}>();
</script>

<template>
    <Head title="Modules" />

    <AuthenticatedLayout>
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Modules
        </h1>
        <Breadcrumb
            :links="[
                {
                    name: 'Home',
                    href: route('dashboard'),
                },
                {
                    name: 'Modules',
                    href: route('modules.index'),
                },
            ]"
            class="mt-2"
        />
        <div class="flex items-center justify-between mt-6 lg:mt-8">
            <div>
                <TextInput v-model="search" placeholder="Search modules" />
            </div>
            <div>
                <PrimaryButton :href="route('modules.create')">
                    Add New Module
                </PrimaryButton>
            </div>
        </div>
        <div
            class="grid grid-cols-1 gap-6 mt-6 lg:gap-8 lg:mt-8 md:grid-cols-2 lg:grid-cols-3"
        >
            <Empty v-if="modules.data.length === 0" class="col-span-full" />
            <Card v-else v-for="mod in modules.data">
                <CardBody>
                    <h2 class="text-lg font-semibold">
                        {{ mod.name }}
                    </h2>
                    <p class="mt-6 text-sm font-semibold text-gray-500">
                        Total users with this role: 2
                    </p>
                    <ul class="pl-4 mt-6 text-sm text-gray-500 list-disc">
                        <li>User: View All, Write All</li>
                        <li class="mt-4">Roles: View All, Write All</li>
                        <li class="mt-4">Events: View All, Write All</li>
                        <li class="mt-4">Categories: View All, Write All</li>
                        <li class="mt-4">Articles: View All, Write All</li>
                    </ul>
                    <div class="mt-6">
                        <SecondaryButton :href="route('roles.show', mod.id)">
                            View Module
                        </SecondaryButton>
                    </div>
                </CardBody>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
