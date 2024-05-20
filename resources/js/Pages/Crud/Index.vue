<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Table from "@/Components/Table/Table.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableCell from "@/Components/Table/TableCell.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import Pagination from "@/Components/Pagination.vue";
import Card from "@/Components/Card/Card.vue";
import CardHeader from "@/Components/Card/CardHeader.vue";
import CardBody from "@/Components/Card/CardBody.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { Module, ModuleAttribute, PaginatedData } from "@/types";
import Empty from "@/Components/Empty.vue";
import Modal from "@/Components/Modal.vue";
import { Ref } from "vue";
import { computed } from "vue";

const props = defineProps<{
    module: Module;
    rows: PaginatedData<{ [key: string]: any }>;
}>();

const search = ref("");

const deleteForm = useForm({});

const deletingRow: Ref<{ [key: string]: any } | null> = ref(null);

const closeDeletingRowModal = () => {
    deletingRow.value = null;
};

const confirmingRowDeletion = computed(() => !!deletingRow.value);

const deleteRow = () => {
    if (!deletingRow.value) {
        return;
    }

    deleteForm.delete(
        route("crud.modules.destroy", [
            props.module.id,
            deletingRow.value["primary"],
        ]),
        {
            preserveScroll: true,
            onSuccess: () => closeDeletingRowModal(),
        }
    );
};
</script>

<template>
    <Head :title="module.name" />

    <AuthenticatedLayout>
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            {{ module.name }}
        </h1>
        <Breadcrumb
            :links="[
                {
                    name: 'Home',
                    href: route('dashboard'),
                },
                {
                    name: module.name,
                    href: route('crud.modules.index', module.id),
                },
            ]"
            class="mt-2"
        />
        <Card class="mt-6 lg:mt-8">
            <CardHeader>
                <div class="flex items-center justify-between">
                    <div>
                        <TextInput v-model="search" placeholder="Search rows" />
                    </div>
                    <div>
                        <PrimaryButton
                            :href="route('crud.modules.create', module.id)"
                        >
                            Add New Row
                        </PrimaryButton>
                    </div>
                </div>
            </CardHeader>
            <CardBody>
                <Table>
                    <TableHead>
                        <TableRow>
                            <TableCell> No. </TableCell>
                            <TableCell v-for="attr in module.attributes">{{
                                attr.name
                            }}</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        <TableRow v-if="rows.data.length === 0">
                            <TableCell colspan="100%">
                                <Empty />
                            </TableCell>
                        </TableRow>
                        <TableRow v-else v-for="(row, index) in rows.data">
                            <TableCell>{{ rows.from + index }}</TableCell>
                            <TableCell v-for="attr in module.attributes">
                                <template v-if="attr.type === 'text'">
                                    {{ row[attr.id] ?? "-" }}
                                </template>
                                <template v-else-if="attr.type === 'switch'">
                                    {{ row[attr.id] === "1" ? "Yes" : "No" }}
                                </template>
                                <template v-else-if="attr.type === 'select'">
                                    {{
                                        attr.additional_info?.options?.find(
                                            (option) =>
                                                option.id === row[attr.id]
                                        )?.name || "-"
                                    }}
                                </template>
                                <template v-else-if="attr.type === 'reference'">
                                    {{
                                        row[attr.id][
                                            row[attr.id]["display_attribute_id"]
                                        ]
                                    }}
                                </template>
                            </TableCell>
                            <TableCell class="text-right">
                                <SecondaryButton
                                    :href="
                                        route('crud.modules.edit', {
                                            module: module.id,
                                            row: row['primary'],
                                        })
                                    "
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-5 h-5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"
                                        />
                                    </svg>
                                </SecondaryButton>
                                <DangerButton
                                    class="ml-4"
                                    @click="deletingRow = row"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-5 h-5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                                        />
                                    </svg>
                                </DangerButton>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <Pagination
                    :from="rows.from"
                    :to="rows.to"
                    :total="rows.total"
                    :links="rows.links"
                    class="mt-6"
                />
            </CardBody>
        </Card>
        <Modal
            :show="confirmingRowDeletion"
            max-width="md"
            @close="closeDeletingRowModal"
        >
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this row?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once the row is deleted, all of its resources and data will
                    be permanently deleted.
                </p>

                <div class="flex justify-end mt-6">
                    <SecondaryButton @click="closeDeletingRowModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton
                        :disabled="deleteForm.processing"
                        :class="{ 'opacity-25': deleteForm.processing }"
                        class="ml-3"
                        @click="deleteRow"
                    >
                        Delete Row
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
