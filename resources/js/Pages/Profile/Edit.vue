<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head } from "@inertiajs/vue3";

defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
}>();
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="px-6 mx-auto space-y-6 max-w-7xl lg:px-8">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Profile
                </h2>
                <div class="p-4 mt-6 bg-white rounded-lg shadow sm:p-8">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="p-4 bg-white rounded-lg shadow sm:p-8">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="p-4 bg-white rounded-lg shadow sm:p-8">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
