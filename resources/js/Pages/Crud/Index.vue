<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Table from "@/Components/Table/Table.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableCell from "@/Components/Table/TableCell.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import Pagination from "@/Components/Pagination.vue";
import Card from "@/Components/Card/Card.vue";
import CardHeader from "@/Components/Card/CardHeader.vue";
import CardBody from "@/Components/Card/CardBody.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { Module, ModuleAttribute, PaginatedData } from "@/types";

defineProps<{
    module: Module;
    attributes: Array<ModuleAttribute>;
    rows: PaginatedData<any>;
}>();

const search = ref("");
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
                            <TableCell v-for="attr in attributes">{{
                                attr.name
                            }}</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        <TableRow v-for="(row, index) in rows.data">
                            <TableCell>{{ rows.from + index }}</TableCell>
                            <TableCell v-for="value in row">
                                {{ value }}
                            </TableCell>
                            <TableCell>
                                <SecondaryButton>View Details</SecondaryButton>
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
    </AuthenticatedLayout>
</template>
