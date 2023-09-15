<script setup lang="ts">
import Card from "@/Components/Card.vue";
import CardBody from "@/Components/CardBody.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { faker } from "@faker-js/faker";
import TextInput from "@/Components/TextInput.vue";
import { ref } from "vue";
import Table from "@/Components/Table/Table.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableCell from "@/Components/Table/TableCell.vue";

const searchTable = ref("");
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="px-6 mx-auto max-w-7xl lg:px-8">
                <h1 class="text-xl font-semibold leading-tight">Dashboard</h1>
                <div class="grid gap-6 mt-6 md:grid-cols-3">
                    <Card class="text-white bg-indigo-500">
                        <CardBody>
                            <span
                                class="inline-flex p-3 text-indigo-500 bg-white rounded-full"
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
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
                                    />
                                </svg>
                            </span>
                            <p class="mt-4 text-xs">Total Users</p>
                            <p class="mt-2 text-2xl font-medium">182</p>
                        </CardBody>
                    </Card>
                    <Card class="text-white bg-pink-600">
                        <CardBody>
                            <span
                                class="inline-flex p-3 text-pink-600 bg-white rounded-full"
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
                                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"
                                    />
                                </svg>
                            </span>
                            <p class="mt-4 text-xs">Total Roles</p>
                            <p class="mt-2 text-2xl font-medium">3</p>
                        </CardBody>
                    </Card>
                    <Card class="text-white bg-orange-500">
                        <CardBody>
                            <span
                                class="inline-flex p-3 text-orange-500 bg-white rounded-full"
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
                                        d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"
                                    />
                                </svg>
                            </span>
                            <p class="mt-4 text-xs">Total Modules</p>
                            <p class="mt-2 text-2xl font-medium">5</p>
                        </CardBody>
                    </Card>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <TextInput
                        v-model="searchTable"
                        placeholder="Search User"
                    />
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
            </div>
        </div>
    </AuthenticatedLayout>
</template>
