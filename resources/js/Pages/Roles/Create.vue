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
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import InputError from "@/Components/Form/InputError.vue";
import { Module, PermissionAction, PermissionQuery } from "@/types";
import Table from "@/Components/Table/Table.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableCell from "@/Components/Table/TableCell.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";
import { getError } from "@/helper";

const props = defineProps<{
    modules: Array<Module>;
}>();

const form = useForm<{
    name: string;
    permissions: Array<{
        module_id: number;
        actions: Array<{ action: PermissionAction; query: PermissionQuery }>;
    }>;
}>({
    name: "",
    permissions: props.modules.map((module) => ({
        module_id: module.id,
        actions: [
            {
                action: "view",
                query: "any",
            },
            {
                action: "create",
                query: "any",
            },
            {
                action: "update",
                query: "any",
            },
            {
                action: "delete",
                query: "any",
            },
        ],
    })),
});

const availableQueries: Array<PermissionQuery> = ["any", "own", "restricted"];

function getModule(id: number): Module {
    const module = props.modules.find((module) => module.id === id);

    if (!module) {
        throw new Error("Invalid module ID");
    }

    return module;
}

function submit() {
    form.post(route("roles.store"));
}
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
        <form @submit.prevent="submit">
            <Card class="mt-6 lg:mt-8">
                <CardHeader>
                    <h2 class="text-lg font-semibold">Role Information</h2>
                </CardHeader>
                <CardBody>
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
                </CardBody>
            </Card>
            <Card class="mt-6 lg:mt-8">
                <CardHeader>
                    <h2 class="text-lg font-semibold">Role Permissions</h2>
                </CardHeader>
                <CardBody>
                    <Table>
                        <TableHead>
                            <TableRow>
                                <TableCell> Module </TableCell>
                                <TableCell> View </TableCell>
                                <TableCell> Create </TableCell>
                                <TableCell> Update </TableCell>
                                <TableCell> Delete </TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            <TableRow
                                v-for="(permission, i) in form.permissions"
                                :key="permission.module_id"
                            >
                                <TableCell>
                                    {{ getModule(permission.module_id).name }}
                                </TableCell>
                                <TableCell
                                    v-for="(action, j) in permission.actions"
                                >
                                    <SelectInput
                                        v-model="action.query"
                                        :options="
                                            availableQueries.map((q) => ({
                                                label: q,
                                                value: q,
                                            }))
                                        "
                                        :reduce="(option) => option.value"
                                    />
                                    <InputError
                                        :message="
                                            getError(
                                                form.errors,
                                                `permissions.${i}.actions.${j}.query`
                                            )
                                        "
                                    />
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </CardBody>
            </Card>
            <SecondaryButton :href="route('roles.index')" class="mt-6 mr-4">
                Cancel
            </SecondaryButton>
            <PrimaryButton class="mt-6"> Save New Role </PrimaryButton>
        </form>
    </AuthenticatedLayout>
</template>
