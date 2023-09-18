<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Table from "@/Components/Table/Table.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableCell from "@/Components/Table/TableCell.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import TextInput from "@/Components/TextInput.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import Pagination from "@/Components/Pagination.vue";
import Card from "@/Components/Card/Card.vue";
import CardHeader from "@/Components/Card/CardHeader.vue";
import CardBody from "@/Components/Card/CardBody.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { PaginatedData, User } from "@/types";

defineProps<{
    users: PaginatedData<User>;
}>();

const search = ref("");
const page = ref(1);
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <h1 class="text-xl font-semibold leading-tight text-gray-800">Users</h1>
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
            ]"
            class="mt-2"
        />
        <Card class="mt-6 lg:mt-8">
            <CardHeader>
                <div class="flex items-center justify-between">
                    <div>
                        <TextInput
                            v-model="search"
                            placeholder="Search users"
                        />
                    </div>
                    <div>
                        <PrimaryButton> Add New User </PrimaryButton>
                    </div>
                </div>
            </CardHeader>
            <CardBody>
                <Table>
                    <TableHead>
                        <TableRow>
                            <TableCell>Name</TableCell>
                            <TableCell>Email</TableCell>
                            <TableCell>Role</TableCell>

                            <TableCell>Status</TableCell>

                            <TableCell>Action</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        <TableRow v-for="user in users.data">
                            <TableCell>
                                {{ user.name }}
                            </TableCell>
                            <TableCell>
                                {{ user.email }}
                            </TableCell>
                            <TableCell>Superadmin</TableCell>
                            <TableCell>
                                <span>Active</span>
                            </TableCell>
                            <TableCell>
                                <SecondaryButton>View Details</SecondaryButton>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <Pagination
                    :from="users.from"
                    :to="users.to"
                    :total="users.total"
                    :links="users.links"
                    class="mt-6"
                />
            </CardBody>
        </Card>
    </AuthenticatedLayout>
</template>
