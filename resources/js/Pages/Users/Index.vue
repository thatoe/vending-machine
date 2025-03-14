<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { Inertia } from "@inertiajs/inertia";

const { users } = usePage().props;

const deleteUser = async (userId) => {
    if (confirm("Are you sure you want to delete this user?")) {
        await Inertia.delete(`/users/${userId}`);
    }
};

const assignAdmin = async (userId) => {
    await Inertia.post(`/users/${userId}/assign-admin`);
};

const revokeAdmin = async (userId) => {
    await Inertia.post(`/users/${userId}/revoke-admin`);
};
</script>

<template>
    <AppLayout title="users">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Users
            </h2>
        </template>
        <div>

            <table class="mt-4 border-collapse w-full">
                <thead>
                    <tr>
                        <th class="border border-gray-400 px-4 py-2">Name</th>
                        <th class="border border-gray-400 px-4 py-2">Email</th>
                        <th class="border border-gray-400 px-4 py-2">Roles</th>
                        <th class="border border-gray-400 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td class="border border-gray-400 px-4 py-2">{{ user.name }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ user.email }}</td>
                        <td class="border border-gray-400 px-4 py-2">
                            {{ user.role.join(", ") }}
                        </td>
                        <td class="border border-gray-400 px-4 py-2">
                            <!-- Assign admin role -->
                            <button
                                v-if="!user.role.includes('admin')"
                                @click="assignAdmin(user.id)"
                                class="text-black-500 bg-gray-500 rounded-md px-2 py-1"
                            >
                                Make Admin
                            </button>

                            <!-- Revoke admin role -->
                            <button
                                v-if="user.role.includes('admin')"
                                @click="revokeAdmin(user.id)"
                                class="text-black-500 bg-orange-500 rounded-md px-2 py-1"
                            >
                                Revoke Admin
                            </button>

                            <button
                                v-if="!user.role.includes('admin')"
                                @click="deleteUser(user.id)"
                                class="text-red-500 ml-2"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
