<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    department: {
        type: Array,
    }
});
const form = useForm({
    name: props.department.name,
});

const submit = () => {
    form.patch(route('department.update', props.department.uuid))
};

</script>

<template>
    <Head title="Edit Employee" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Employee Category</h2>
        </template>
        <div class="py-12">
            <div class="max-w-2xl py-12 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <h3 class="text-center my-3 text-bold text-lg">Edit Employee Category</h3>
                        <form @submit.prevent="submit" class="max-w-md mx-auto">
                            <div>
                                <InputLabel for="name" value="Employee Department Name" />

                                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus />

                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>
                            <div class="flex items-center justify-center">
                                <Link :href="route('departments')"
                                    class="font-medium  text-blue-600 dark:text-blue-500 hover:underline mx-1">Cancel
                                </Link>
                                <PrimaryButton class="w-42 ml-4 my-3" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Update
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
