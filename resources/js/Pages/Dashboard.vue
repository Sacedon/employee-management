<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router, usePage} from '@inertiajs/vue3';
import { reactive } from 'vue';
defineProps({
    employees: {
        type: Array,
        required: true
    },
    message: {
        type: String
    }
});

function search(ev) {
router.visit('/employees/search/' + ev.target.value)}
</script>

<template>
    <Head title="Employee" />

    <AppLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employee Management</h2>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">

              <!-- Search Input -->
              <div class="relative mt-4">
                <input
                  type="text"
                  @keydown.enter="search($event)"
                  class="w-[300px] px-4 py-2 border border-gray-400 rounded-full"
                  placeholder="Search Employee"
                >
              </div>

              <!-- Add Employee Button -->
              <Link
                :href="route('employee.create')"
                class="absolute top-4 right-4 px-4 py-2 text-white bg-blue-500 rounded-full hover:bg-blue-700"
              >
                Add Employee
              </Link>

              <!-- Success Message -->
              <div v-if="message" class="mt-4 px-4 py-2 text-sm text-center text-white bg-green-500 rounded-full">
                {{ message }}
              </div>

              <!-- Employee Table -->
              <table class="w-full mt-8 text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Profile Pic</th>
                    <th class="px-6 py-3">Department</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Phone</th>
                    <th class="px-6 py-3">Address</th>
                    <th class="px-6 py-3">Action</th>
                    <th class="px-6 py-3">Email</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(employee, index) in employees"
                    :key="index"
                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                  >
                    <td class="px-6 py-4">{{ index + 1 }}</td>
                    <td class="px-6 py-4">
                      <img :src="employee.picUrl" alt="Employee photo" class="w-12 h-12 rounded-full object-cover">
                    </td>
                    <td class="px-6 py-4">{{ employee.department.name }}</td>
                    <td class="px-6 py-4">{{ employee.name }}</td>
                    <td class="px-6 py-4">{{ employee.email }}</td>
                    <td class="px-6 py-4">{{ employee.phone }}</td>
                    <td class="px-6 py-4">{{ employee.address }}</td>
                    <td class="px-6 py-4 space-x-2">
                      <Link :href="route('employee.edit', employee.uuid)" class="text-blue-600 hover:underline">Edit</Link>
                      <Link :href="route('employee.delete', employee.uuid)" class="text-red-600 hover:underline">Delete</Link>
                    </td>
                    <td class="px-6 py-4 space-x-2">
                      <Link :href="'/employees/email/' + employee.id" class="text-green-600 hover:underline">Send Email</Link>
                      <a :href="'/employees/pdf/' + employee.id" target="_blank" class="text-red-600 hover:underline">Export Pdf</a>
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
