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
import { PaginatedData, Role } from "@/types";

const search = ref("");

defineProps<{
    roles: PaginatedData<Role>;
}>();
</script>

<template>
    <Head title="Roles" />

    <AuthenticatedLayout>
        <h1 class="text-xl font-semibold leading-tight text-gray-800">Roles</h1>
        <Breadcrumb
            :links="[
                {
                    name: 'Home',
                    href: route('dashboard'),
                },
                {
                    name: 'Roles',
                    href: route('roles.index'),
                },
            ]"
            class="mt-2"
        />
        <div class="flex items-center justify-between mt-6 lg:mt-8">
            <div>
                <TextInput v-model="search" placeholder="Search roles" />
            </div>
            <div>
                <PrimaryButton :href="route('roles.create')">
                    Add New Role
                </PrimaryButton>
            </div>
        </div>
        <div
            class="grid grid-cols-1 gap-6 mt-6 lg:gap-8 lg:mt-8 md:grid-cols-2 lg:grid-cols-3"
        >
            <Card v-for="role in roles.data">
                <CardBody>
                    <h2 class="text-lg font-semibold">
                        {{ role.name }}
                    </h2>
                    <p class="mt-6 text-sm font-semibold text-gray-500">
                        Total users with this role:
                        {{ role.users_count }}
                    </p>
                    <ul class="pl-4 mt-6 text-sm text-gray-500 list-disc">
                        <li>User: View All, Write All</li>
                        <li class="mt-4">Roles: View All, Write All</li>
                        <li class="mt-4">Events: View All, Write All</li>
                        <li class="mt-4">Categories: View All, Write All</li>
                        <li class="mt-4">Articles: View All, Write All</li>
                    </ul>
                    <div class="mt-6">
                        <SecondaryButton :href="route('roles.show', role.id)">
                            View Role
                        </SecondaryButton>
                    </div>
                </CardBody>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
