<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    departments: {
        type: Array,
    },
    message: {
        type: String,
    }
});

</script>

<template>
    <Head title="Departments" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employee Department</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                        <Link :href="route('department.create')"
                            class="bg-blue-500 hover:bg-blue-700 text-white mb-2 w-42 font-bold py-2 px-4 rounded-full float-right">
                        Create Department
                        </Link>
                        <br>
                        <div v-if="message"
                            class="flex text-lg items-center justify-center w-full bg-blue-200 p-3 font-medium text-sm text-green-600">
                            {{ message }}
                        </div>
                        <br>
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Department Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total Employee
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(department, index) in departments" :key="index"
                                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ index + 1 }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ department.name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ department.employees_count }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <Link :href="route('department.edit', department.uuid)"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1">Edit
                                        </Link>
                                        <Link :href="route('department.delete', department.uuid)"
                                            class="font-medium text-red-600 dark:text-red-500 hover:underline mx-1">Delete
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
