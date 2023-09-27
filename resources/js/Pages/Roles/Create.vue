<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import Card from "@/Components/Card/Card.vue";
import CardHeader from "@/Components/Card/CardHeader.vue";
import CardBody from "@/Components/Card/CardBody.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import FormGroup from "@/Components/Form/FormGroup.vue";
import Checkbox from "@/Components/Form/Checkbox.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import InputError from "@/Components/Form/InputError.vue";
import { Module } from "@/types";

defineProps<{
    modules: Array<Module>;
}>();

const form = useForm({
    name: "",
    permissions: [],
});

const availablePermissions = [
    {
        name: "View",
        types: [
            {
                name: "All",
            },
            {
                name: "Owned",
            },
        ],
    },
    {
        name: "Create",
    },
    {
        name: "Update",
        types: [
            {
                name: "All",
            },
            {
                name: "Owned",
            },
        ],
    },
    {
        name: "Delete",
        types: [
            {
                name: "All",
            },
            {
                name: "Owned",
            },
        ],
    },
];
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
                <h2 class="text-lg font-semibold">Role Information</h2>
            </CardHeader>
            <CardBody>
                <form @submit.prevent="form.post(route('roles.store'))">
                    <FormGroup>
                        <template #label>
                            <InputLabel for="name" value="Role Name" />
                        </template>
                        <template #input>
                            <TextInput
                                id="name"
                                v-model="form.name"
                                placeholder="Input role name"
                                class="w-full"
                            />
                            <InputError :message="form.errors.name" />
                        </template>
                    </FormGroup>
                </form>
            </CardBody>
        </Card>
        <Card class="mt-6 lg:mt-8">
            <CardHeader>
                <h2 class="text-lg font-semibold">Role Permissions</h2>
            </CardHeader>
            <CardBody>
                <FormGroup
                    v-for="(module, index) in modules"
                    :class="{ 'mt-6': index !== 0 }"
                >
                    <template #label>
                        <InputLabel :value="module.name" />
                    </template>
                    <template #input>
                        <div
                            v-for="(permission, i) in availablePermissions"
                            class="py-3"
                        >
                            <p class="font-medium">{{ permission.name }}</p>
                            <div class="flex mt-6">
                                <div
                                    v-for="(type, j) in permission.types"
                                    class="mr-6"
                                >
                                    <Checkbox
                                        :id="`check${i}-${j}`"
                                        :checked="false"
                                    />
                                    <InputLabel
                                        :for="`check${i}-${j}`"
                                        :value="type.name"
                                        class="inline-block ml-3 align-middle"
                                    />
                                </div>
                                <div
                                    v-for="(
                                        attr, j
                                    ) in module.fillable_attributes"
                                    class="mr-6"
                                >
                                    <Checkbox
                                        :id="`check${i}-${j}`"
                                        :checked="false"
                                    />
                                    <InputLabel
                                        :for="`check${i}-${j}`"
                                        :value="attr.name"
                                        class="inline-block ml-3 align-middle"
                                    />
                                </div>
                            </div>
                        </div>
                    </template>
                </FormGroup>
            </CardBody>
        </Card>
        <SecondaryButton :href="route('roles.index')" class="mt-6 mr-4">
            Cancel
        </SecondaryButton>
        <PrimaryButton class="mt-6"> Save New Role </PrimaryButton>
    </AuthenticatedLayout>
</template>
