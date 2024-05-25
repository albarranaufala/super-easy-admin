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
import DangerButton from "@/Components/Button/DangerButton.vue";
import InputError from "@/Components/Form/InputError.vue";
import { Module, Role, PermissionAction, PermissionQuery } from "@/types";
import Table from "@/Components/Table/Table.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableCell from "@/Components/Table/TableCell.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";
import Modal from "@/Components/Modal.vue";
import { getError } from "@/helper";
import { nextTick, ref } from "vue";

const props = defineProps<{
    role: Role;
    modules: Array<Module>;
}>();

const form = useForm<{
    name: string;
    permissions: Array<{
        module_id: number;
        actions: Array<{ action: PermissionAction; query: PermissionQuery }>;
    }>;
}>({
    name: props.role.name,
    permissions: props.modules.map((module) => {
        const modulePermissions = props.role.permissions.filter(
            (permission) => permission.module_id === module.id
        );
        if (modulePermissions.length > 0) {
            return {
                module_id: module.id,
                actions: modulePermissions.map((action) => ({
                    action: action.action,
                    query: action.query,
                })),
            };
        }
        return {
            module_id: module.id,
            actions: [
                {
                    action: "view",
                    query: "restricted",
                },
                {
                    action: "create",
                    query: "restricted",
                },
                {
                    action: "update",
                    query: "restricted",
                },
                {
                    action: "delete",
                    query: "restricted",
                },
            ],
        };
    }),
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
    form.patch(route("roles.update", props.role.id));
}

const confirmingRoleDeletion = ref(false);
const passwordInput = ref<HTMLInputElement | null>(null);
const roleDeletionForm = useForm({
    password: "",
});

const confirmRoleDeletion = () => {
    confirmingRoleDeletion.value = true;

    nextTick(() => passwordInput.value?.focus());
};

const deleteRole = () => {
    roleDeletionForm.delete(route("roles.destroy", props.role.id));
};

const closeDeleteRoleModal = () => {
    confirmingRoleDeletion.value = false;

    roleDeletionForm.reset();
};
</script>

<template>
    <Head title="Edit Role" />

    <AuthenticatedLayout>
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Role
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
                    name: 'Edit Role',
                    href: route('roles.edit', role.id),
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
        </form>
        <SecondaryButton :href="route('roles.index')" class="mt-6 mr-4">
            Cancel
        </SecondaryButton>
        <PrimaryButton class="mt-6 mr-4" @click="submit">
            Save Changes
        </PrimaryButton>
        <DangerButton class="mt-6" @click="confirmRoleDeletion">
            Delete
        </DangerButton>
        <Modal :show="confirmingRoleDeletion" @close="closeDeleteRoleModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this role?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once this role is deleted, all of its resources and data
                    will be deleted. Please enter your password to confirm you
                    would like to permanently delete your account.
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="password"
                        value="Password"
                        class="sr-only"
                    />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="roleDeletionForm.password"
                        type="password"
                        class="block w-3/4 mt-1"
                        placeholder="Password"
                        @keyup.enter="deleteRole"
                    />

                    <InputError
                        :message="roleDeletionForm.errors.password"
                        class="mt-2"
                    />
                </div>

                <div class="flex justify-end mt-6">
                    <SecondaryButton @click="closeDeleteRoleModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': roleDeletionForm.processing }"
                        :disabled="roleDeletionForm.processing"
                        @click="deleteRole"
                    >
                        Delete Role
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
