<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { faker } from "@faker-js/faker";
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

const search = ref("");
const page = ref(1);
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="px-6 max-w-7xl lg:px-8">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Users
                </h2>
                <div class="flex items-center justify-between mt-6">
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
                <Table class="mt-6">
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
                        <TableRow v-for="i in 10">
                            <TableCell>
                                {{ faker.person.fullName() }}
                            </TableCell>
                            <TableCell>
                                {{ faker.internet.email() }}
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
                    v-model="page"
                    :per-page="10"
                    :total="25"
                    class="mt-6"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
