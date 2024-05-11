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
import Modal from "@/Components/Modal.vue";
import { SelectOption } from "@/types";
import DangerButton from "@/Components/Button/DangerButton.vue";
import { getDefaultOptions, getError } from "@/helper";
import { Module } from "@/types";
import { nextTick, ref } from "vue";
import IconTrash from "@/Components/Icon/IconTrash.vue";
import IconPlus from "@/Components/Icon/IconPlus.vue";

const props = defineProps<{
    module: Module;
    modules: Array<Module>;
    availableTypes: Array<string>;
}>();

interface Attribute {
    id: number | null;
    type: string;
    name: string;
    options: Array<{
        name: string;
    }>;
    reference_module_id: number | null;
}

const defaultOptions = getDefaultOptions();

const form = useForm<{
    name: string;
    attributes: Array<Attribute>;
}>({
    name: props.module.name,
    attributes:
        props.module.attributes?.map((attribute) => ({
            id: attribute.id,
            type: attribute.type,
            name: attribute.name,
            options: attribute.additional_info?.options || defaultOptions,
            reference_module_id:
                attribute.additional_info?.reference_module_id || null,
        })) || [],
});

const availableTypesOptions: Array<SelectOption> = props.availableTypes.map(
    (type) => ({
        value: type,
        label: type,
    })
);

const modulesOptions: Array<SelectOption> = props.modules.map((module) => ({
    value: module.id,
    label: module.name,
}));

const addNewAttribute = () => {
    form.attributes.push({
        id: null,
        type: "text",
        name: `Attribute ${form.attributes.length + 1}`,
        options: defaultOptions,
        reference_module_id: null,
    });
};

const deleteAttribute = (index: number) => {
    form.attributes.splice(index, 1);
};

const addOption = (attribute: Attribute) => {
    attribute.options.push({
        name: `Option ${attribute.options.length + 1}`,
    });
};

const deleteOption = (attribute: Attribute, optionIndex: number) => {
    attribute.options.splice(optionIndex, 1);
};

const submit = () => {
    form.put(route("modules.update", props.module.id));
};

const confirmingModuleDeletion = ref(false);
const passwordInput = ref<HTMLInputElement | null>(null);
const moduleDeletionForm = useForm({
    password: "",
});

const confirmModuleDeletion = () => {
    confirmingModuleDeletion.value = true;

    nextTick(() => passwordInput.value?.focus());
};

const deleteModule = () => {
    moduleDeletionForm.delete(route("modules.destroy", props.module.id));
};

const closeDeleteModuleModal = () => {
    confirmingModuleDeletion.value = false;

    moduleDeletionForm.reset();
};
</script>

<template>
    <Head title="Edit Module" />

    <AuthenticatedLayout>
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Module
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
                    name: 'Edit Module',
                    href: route('modules.edit', module.id),
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
                                    :options="availableTypesOptions"
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
                                <div v-if="attribute.type === 'select'">
                                    <div
                                        v-for="(
                                            option, optionIndex
                                        ) in attribute.options"
                                        class="flex mt-6"
                                    >
                                        <TextInput
                                            id="name"
                                            v-model="option.name"
                                            placeholder="Option 1"
                                            class="w-full"
                                        />
                                        <DangerButton
                                            class="ml-6"
                                            type="button"
                                            :disabled="
                                                attribute.options.length === 1
                                            "
                                            @click="
                                                deleteOption(
                                                    attribute,
                                                    optionIndex
                                                )
                                            "
                                        >
                                            <IconTrash class="w-6 h-6" />
                                        </DangerButton>
                                    </div>
                                    <div class="flex justify-end">
                                        <PrimaryButton
                                            type="button"
                                            class="mt-6"
                                            @click="addOption(attribute)"
                                        >
                                            <IconPlus class="w-6 h-6" />
                                        </PrimaryButton>
                                    </div>
                                </div>
                                <div v-else-if="attribute.type === 'reference'">
                                    <SelectInput
                                        v-model="attribute.reference_module_id"
                                        :options="modulesOptions"
                                        :reduce="(option) => option?.value"
                                        placeholder="Input reference module name"
                                        class="mt-6"
                                    />
                                </div>
                            </div>
                        </div>
                        <div>
                            <DangerButton
                                class="col-span-2 ml-6"
                                type="button"
                                :disabled="form.attributes.length === 1"
                                @click="deleteAttribute(index)"
                            >
                                <IconTrash class="w-6 h-6" />
                            </DangerButton>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <PrimaryButton
                            type="button"
                            class="mt-6"
                            @click="addNewAttribute"
                        >
                            <IconPlus class="w-6 h-6" />
                        </PrimaryButton>
                    </div>
                </CardBody>
            </Card>
        </form>
        <SecondaryButton :href="route('modules.index')" class="mt-6 mr-4">
            Cancel
        </SecondaryButton>
        <PrimaryButton class="mt-6 mr-4" @click="submit">
            Save Changes
        </PrimaryButton>
        <DangerButton class="mt-6" @click="confirmModuleDeletion">
            Delete
        </DangerButton>
        <Modal :show="confirmingModuleDeletion" @close="closeDeleteModuleModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this module?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once this module is deleted, all of its resources and data
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
                        v-model="moduleDeletionForm.password"
                        type="password"
                        class="block w-3/4 mt-1"
                        placeholder="Password"
                        @keyup.enter="deleteModule"
                    />

                    <InputError
                        :message="moduleDeletionForm.errors.password"
                        class="mt-2"
                    />
                </div>

                <div class="flex justify-end mt-6">
                    <SecondaryButton @click="closeDeleteModuleModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': moduleDeletionForm.processing }"
                        :disabled="moduleDeletionForm.processing"
                        @click="deleteModule"
                    >
                        Delete Module
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
