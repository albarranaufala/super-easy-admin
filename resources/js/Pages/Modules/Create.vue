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
import SelectInput from "@/Components/Form/SelectInput.vue";
import { SelectOption } from "@/types";
import DangerButton from "@/Components/Button/DangerButton.vue";
import { getError } from "@/helper";

const form = useForm<{
    name: string;
    attributes: Array<{
        type: string;
        name: string;
    }>;
}>({
    name: "",
    attributes: [
        {
            type: "text",
            name: "Attribute 1",
        },
        {
            type: "text",
            name: "Attribute 2",
        },
        {
            type: "text",
            name: "Attribute 3",
        },
    ],
});

const attributeTypes: Array<SelectOption> = [
    {
        value: "text",
        label: "Text",
    },
    {
        value: "switch",
        label: "Switch",
    },
];

const addNewAttribute = () => {
    form.attributes.push({
        type: "text",
        name: `Attribute ${form.attributes.length + 1}`,
    });
};

const deleteAttribute = (index: number) => {
    form.attributes.splice(index, 1);
};

const submit = () => {
    form.post(route("modules.store"));
};
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
                    name: 'Modules',
                    href: route('modules.index'),
                },
                {
                    name: 'Add New Module',
                    href: route('modules.create'),
                },
            ]"
            class="mt-2"
        />
        <form @submit.prevent="submit">
            <Card class="mt-6 lg:mt-8">
                <CardHeader>
                    <h2 class="text-lg font-semibold">Module Information</h2>
                </CardHeader>
                <CardBody>
                    <FormGroup>
                        <template #label>
                            <InputLabel for="name" value="Module Name" />
                        </template>
                        <template #input>
                            <TextInput
                                id="name"
                                v-model="form.name"
                                placeholder="Input module name"
                                class="w-full"
                            />
                            <InputError :message="form.errors.name" />
                        </template>
                    </FormGroup>
                </CardBody>
            </Card>
            <Card class="mt-6 lg:mt-8">
                <CardHeader>
                    <h2 class="text-lg font-semibold">Module Attributes</h2>
                </CardHeader>
                <CardBody>
                    <div
                        v-for="(attribute, index) in form.attributes"
                        class="flex"
                        :class="[index === 0 ? 'mt-0' : 'mt-6']"
                    >
                        <div class="grid flex-1 grid-cols-2 gap-6">
                            <div>
                                <SelectInput
                                    id="name"
                                    v-model="attribute.type"
                                    :options="attributeTypes"
                                    :reduce="(option) => option?.value"
                                    placeholder="Input module name"
                                />
                                <InputError
                                    :message="
                                        getError(
                                            form.errors,
                                            `attributes.${index}.type`
                                        )
                                    "
                                />
                            </div>
                            <div>
                                <TextInput
                                    id="name"
                                    v-model="attribute.name"
                                    placeholder="Input module name"
                                    class="w-full"
                                />
                                <InputError
                                    :message="
                                        getError(
                                            form.errors,
                                            `attributes.${index}.name`
                                        )
                                    "
                                />
                            </div>
                        </div>
                        <div>
                            <DangerButton
                                class="col-span-2 ml-6"
                                type="button"
                                :disabled="form.attributes.length === 1"
                                @click="deleteAttribute(index)"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                                    />
                                </svg>
                            </DangerButton>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <PrimaryButton
                            type="button"
                            class="mt-6"
                            @click="addNewAttribute"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 4.5v15m7.5-7.5h-15"
                                />
                            </svg>
                        </PrimaryButton>
                    </div>
                </CardBody>
            </Card>
            <SecondaryButton :href="route('modules.index')" class="mt-6 mr-4">
                Cancel
            </SecondaryButton>
            <PrimaryButton class="mt-6"> Save New Module </PrimaryButton>
        </form>
    </AuthenticatedLayout>
</template>
