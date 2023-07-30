<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    departments: {
        type: Array,
    },
    employee: {
        type: Object,
    },
});
const form = useForm({
    name: props.employee.name,
    email: props.employee.email,
    phone: props.employee.phone,
    address: props.employee.address,
    department: props.employee.department_id,
});

const submit = () => {
    form.patch(route('employee.update', props.employee.uuid))
};

</script>

<template>
    <Head title="Edit Department" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Employee</h2>
        </template>
        <div class="py-12">
            <div class="max-w-2xl py-12 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <h3 class="text-center my-3 text-bold text-lg">Edit Employee</h3>
                        <form @submit.prevent="submit" class="max-w-md mx-auto">
                            <div>
                                <InputLabel for="name" value="Employee Name" />

                                <TextInput id="name" type="text" class="mb-4 block w-full" v-model="form.name" autofocus />

                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>
                            <div>
                                <InputLabel for="email" value="Employee email" />

                                <TextInput id="email" type="email" class="mb-4 block w-full" v-model="form.email" />

                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>
                            <div>
                                <InputLabel for="phone" value="Employee phone" />

                                <TextInput id="phone" type="tel" class="mb-4 block w-full" v-model="form.phone" />

                                <InputError class="mt-2" :message="form.errors.phone" />
                            </div>
                            <div>
                                <InputLabel for="address" value="Employee address" />

                                <TextInput id="address" type="text" class="mb-4 block w-full" v-model="form.address" />

                                <InputError class="mt-2" :message="form.errors.address" />
                            </div>
                            <div class="mb-4">

                                <InputLabel for="address" value="Employee Department" />

                                <select
                                    class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="department" v-model="form.department">
                                    <option value="">Select a department</option>
                                    <option v-for="department in categories" :key="department.id" :value="department.id">
                                        {{ department.name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.department" />

                            </div>
                            <div class="flex items-center justify-center">
                                <Link :href="route('employees')"
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
