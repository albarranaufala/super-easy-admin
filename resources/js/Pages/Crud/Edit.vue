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
import { Module, ModuleAttribute } from "@/types";
import { getError } from "@/helper";

const props = defineProps<{
    module: Module;
    attributes: Array<ModuleAttribute>;
    row: { [key: string]: any };
}>();

const form = useForm({
    row: props.attributes
        .filter((attr) => attr.type !== "primary")
        .map((attr: ModuleAttribute) => ({
            attribute_id: attr.id,
            label: attr.name,
            value: props.row[attr.id],
        })),
});

const submit = () => {
    form.patch(
        route("crud.modules.update", [props.module.id, props.row["primary"]])
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
                {
                    name: 'Edit',
                    href: route('crud.modules.edit', [
                        module.id,
                        row['primary'],
                    ]),
                },
            ]"
            class="mt-2"
        />
        <Card class="mt-6 lg:mt-8">
            <CardHeader>
                <h2 class="text-lg font-semibold">Edit Row</h2>
            </CardHeader>
            <CardBody>
                <form @submit.prevent="submit">
                    <FormGroup
                        v-for="(attr, index) in form.row"
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
                                :id="attr.attribute_id"
                                v-model="attr.value"
                                :placeholder="attr.label"
                                class="w-full"
                            />
                            <InputError
                                :message="
                                    getError(form.errors, `row.${index}.value`)
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
                    <PrimaryButton class="mt-6"> Save Changes </PrimaryButton>
                </form>
            </CardBody>
        </Card>
    </AuthenticatedLayout>
</template>
