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
import Checkbox from "@/Components/Checkbox.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import { faker } from "@faker-js/faker";

const form = useForm({
    name: "",
    permissions: [],
});
</script>

<template>
    <Head title="Add New Role" />

    <AuthenticatedLayout>
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Add New Role
        </h1>
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
                {
                    name: 'Add New Role',
                    href: route('roles.create'),
                },
            ]"
            class="mt-2"
        />
        <Card class="mt-6 lg:mt-8">
            <CardHeader>
                <h2 class="text-lg font-semibold">Add New Role</h2>
            </CardHeader>
            <CardBody>
                <FormGroup>
                    <template #label>
                        <InputLabel for="name" value="Role Name" />
                    </template>
                    <template #input>
                        <TextInput
                            id="name"
                            placeholder="Input role name"
                            class="w-full"
                        />
                    </template>
                </FormGroup>
                <FormGroup class="mt-6">
                    <template #label>
                        <InputLabel value="Role Permissions" />
                    </template>
                    <template #input>
                        <div v-for="i in 10">
                            <div class="py-3">
                                <Checkbox :id="`check${i}`" />
                                <InputLabel
                                    :for="`check${i}`"
                                    :value="faker.person.jobTitle()"
                                    class="inline-block ml-3 align-middle"
                                />
                            </div>
                        </div>
                    </template>
                </FormGroup>
                <SecondaryButton class="mt-6 mr-4"> Cancel </SecondaryButton>
                <PrimaryButton class="mt-6"> Save New Role </PrimaryButton>
            </CardBody>
        </Card>
    </AuthenticatedLayout>
</template>
