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
import Switch from "@/Components/Form/Switch.vue";
import { Module, ModuleAttribute } from "@/types";
import { getError } from "@/helper";
import SelectInput from "@/Components/Form/SelectInput.vue";

const props = defineProps<{
    module: Module;
}>();

const form = useForm({
    attribute_values: props.module.attributes?.map((attr: ModuleAttribute) => ({
        attribute_id: attr.id,
        type: attr.type,
        additional_info: attr.additional_info,
        label: attr.name,
        value: attr.default_value,
        referenced_module_rows: attr.referenced_module_rows || [],
    })),
});

const submit = () => {
    form.post(route("crud.modules.store", props.module.id));
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
                {
                    name: 'Create',
                    href: route('users.create', module.id),
                },
            ]"
            class="mt-2"
        />
        <Card class="mt-6 lg:mt-8">
            <CardHeader>
                <h2 class="text-lg font-semibold">Add New Row</h2>
            </CardHeader>
            <CardBody>
                <form @submit.prevent="submit">
                    <FormGroup
                        v-for="(attr, index) in form.attribute_values"
                        :class="{ 'mt-6': index > 0 }"
                    >
                        <template #label>
                            <InputLabel
                                :for="attr.attribute_id"
                                :value="attr.label"
                            />
                        </template>
                        <template #input>
                            <TextInput
                                v-if="attr.type === 'text'"
                                :id="attr.attribute_id"
                                v-model="attr.value"
                                :placeholder="attr.label"
                                class="w-full"
                            />
                            <Switch
                                v-else-if="attr.type === 'switch'"
                                :id="`${attr.attribute_id}`"
                                v-model="attr.value"
                                class="py-2"
                            />
                            <SelectInput
                                v-else-if="attr.type === 'select'"
                                :id="`${attr.attribute_id}`"
                                v-model="attr.value"
                                :options="
                                    attr.additional_info?.options?.map(
                                        (option) => ({
                                            label: option.name,
                                            value: option.id,
                                        })
                                    )
                                "
                                :reduce="(option) => option?.value"
                                :placeholder="attr.label"
                                class="py-2"
                            />
                            <SelectInput
                                v-else-if="attr.type === 'reference'"
                                :id="`${attr.attribute_id}`"
                                v-model="attr.value"
                                :options="
                                    attr.referenced_module_rows.map(
                                        (row: any) => {
                                            return {
                                                label: row[row['display_attribute_id']],
                                                value: row,
                                            }
                                        }
                                    )
                                "
                                :reduce="(option) => option?.value"
                                :placeholder="attr.label"
                                class="py-2"
                            />
                            <InputError
                                :message="
                                    getError(
                                        form.errors,
                                        `attribute_values.${index}.value`
                                    )
                                "
                            />
                        </template>
                    </FormGroup>
                    <SecondaryButton
                        :href="route('crud.modules.index', module.id)"
                        class="mt-6 mr-4"
                    >
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton class="mt-6"> Save New Row </PrimaryButton>
                </form>
            </CardBody>
        </Card>
    </AuthenticatedLayout>
</template>
