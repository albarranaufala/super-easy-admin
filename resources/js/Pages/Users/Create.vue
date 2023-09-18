<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Card from "@/Components/Card/Card.vue";
import CardHeader from "@/Components/Card/CardHeader.vue";
import CardBody from "@/Components/Card/CardBody.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import FormGroup from "@/Components/Form/FormGroup.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});
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
                <form @submit.prevent="form.post(route('users.store'))">
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
