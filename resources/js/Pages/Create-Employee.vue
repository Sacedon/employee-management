<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
defineProps({
    departments: {
        type: Array
    }
})
const form = useForm({
    name: '',
    email: '',
    phone: '',
    address: '',
    department: '',
    pic: null,
});
const submit = () => {
    form.post(route('employee.store'))
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Employees</h2>
        </template>
        <div class="py-12">
            <div class="max-w-3xl  py-12 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="relative py-12 overflow-x-auto shadow-md sm:rounded-lg">
                        <form @submit.prevent="submit" class="max-w-md mx-auto">
                            <h2 class="text-center py-4 text-lg">Add Employee</h2>
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
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="department">
                                    Department
                                </label>
                                <select
                                    class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="department" v-model="form.department">
                                    <option value="">Select a department</option>
                                    <option v-for="department in departments" :key="department.id" :value="department.id">
                                        {{ department.name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.department" />

                            </div>

                            <div class="mb-4">
            <label for="pic">Profile Picture</label>
            <input type="file" @input="form.pic = $event.target.files[0]" class="input" accept="image/jpeg" />
            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
              {{ form.progress.percentage }}%
            </progress>
          </div>
                            <div class="flex items-center justify-center">
                                <Link :href="route('departments')"
                                    class="font-medium  text-blue-600 dark:text-blue-500 hover:underline mx-1">Cancel
                                </Link>
                                <PrimaryButton class="w-42 ml-4 my-3" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Submit
                                </PrimaryButton>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
