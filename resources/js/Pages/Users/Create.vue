<script setup lang="ts">
import { Head, router, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import Card from "@/Components/Card/Card.vue";
import CardHeader from "@/Components/Card/CardHeader.vue";
import CardBody from "@/Components/Card/CardBody.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import FormGroup from "@/Components/Form/FormGroup.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import InputError from "@/Components/Form/InputError.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";
import { SelectOption } from "@/types";
import { computed } from "vue";

const props = defineProps<{
    roles: Array<{ id: string; name: string }>;
}>();

const form = useForm<{
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
    role: { value: number; label: string } | null;
}>({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: null,
});

const roles = computed(() =>
    props.roles.map(
        (item): SelectOption => ({ value: item.id, label: item.name })
    )
);

const searchRoles = async (
    search: string,
    loading: (loading: boolean) => void
) => {
    loading(true);

    router.get(
        route("users.create"),
        { search_role: search },
        { preserveState: true, preserveScroll: true }
    );

    loading(false);
};

const submit = () => {
    form.transform((data) => ({
        ...data,
        role_id: data.role?.value,
    })).post(route("users.store"));
};
</script>

<template>
    <Head title="Add New User" />

    <AuthenticatedLayout>
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Add New User
        </h1>
        <Breadcrumb
            :links="[
                {
                    name: 'Home',
                    href: route('dashboard'),
                },
                {
                    name: 'Users',
                    href: route('users.index'),
                },
                {
                    name: 'Add New User',
                    href: route('users.create'),
                },
            ]"
            class="mt-2"
        />
        <Card class="mt-6 lg:mt-8">
            <CardHeader>
                <h2 class="text-lg font-semibold">Add New User</h2>
            </CardHeader>
            <CardBody>
                <form @submit.prevent="submit">
                    <FormGroup>
                        <template #label>
                            <InputLabel for="name" value="User Name" />
                        </template>
                        <template #input>
                            <TextInput
                                id="name"
                                v-model="form.name"
                                placeholder="Input user name"
                                class="w-full"
                            />
                            <InputError :message="form.errors.name" />
                        </template>
                    </FormGroup>
                    <FormGroup class="mt-6">
                        <template #label>
                            <InputLabel for="email" value="User Email" />
                        </template>
                        <template #input>
                            <TextInput
                                id="email"
                                v-model="form.email"
                                type="email"
                                placeholder="Input user email"
                                class="w-full"
                            />
                            <InputError :message="form.errors.email" />
                        </template>
                    </FormGroup>
                    <FormGroup class="mt-6">
                        <template #label>
                            <InputLabel for="password" value="User Password" />
                        </template>
                        <template #input>
                            <TextInput
                                id="password"
                                v-model="form.password"
                                type="password"
                                placeholder="Input user password"
                                class="w-full"
                            />
                            <InputError :message="form.errors.password" />
                        </template>
                    </FormGroup>
                    <FormGroup class="mt-6">
                        <template #label>
                            <InputLabel
                                for="repassword"
                                value="Password Confirmation"
                            />
                        </template>
                        <template #input>
                            <TextInput
                                id="repassword"
                                v-model="form.password_confirmation"
                                type="password"
                                placeholder="Input as same as user password"
                                class="w-full"
                            />
                            <InputError
                                :message="form.errors.password_confirmation"
                            />
                        </template>
                    </FormGroup>
                    <FormGroup class="mt-6">
                        <template #label>
                            <InputLabel for="role" value="User Role" />
                        </template>
                        <template #input>
                            <SelectInput
                                id="role"
                                v-model="form.role"
                                :filterable="false"
                                :options="roles"
                                placeholder="Choose user role"
                                class="w-full"
                                @search="searchRoles"
                            />
                            <InputError
                                :message="form.errors.password_confirmation"
                            />
                        </template>
                    </FormGroup>
                    <SecondaryButton
                        :href="route('users.index')"
                        class="mt-6 mr-4"
                    >
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton class="mt-6"> Save New User </PrimaryButton>
                </form>
            </CardBody>
        </Card>
    </AuthenticatedLayout>
</template>
