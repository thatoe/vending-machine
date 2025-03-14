<script setup>
import { ref, computed } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

const form = ref({
    name: "",
    price: "",
    quantity_available: "",
});

const errors = computed(() => usePage().props.errors || {});

const submit = () => {
    router.post("/products", form.value);
};
</script>

<template>
    <AppLayout title="Products">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Product
            </h2>
            <div>
                <h1 class="text-2xl font-bold mb-4">Create Product</h1>
                <form @submit.prevent="submit">
                    <label>Name:</label>
                    <input
                        type="text"
                        v-model="form.name"
                        class="border p-2 w-full mb-2"
                    />
                    <p v-if="errors.name" class="text-red-500">{{ errors.name }}</p>

                    <label>Price:</label>
                    <input
                        type="number"
                        v-model="form.price"
                        class="border p-2 w-full mb-2"
                    />
                    <p v-if="errors.price" class="text-red-500">{{ errors.price }}</p>

                    <label>Quantity:</label>
                    <input
                        type="number"
                        v-model="form.quantity_available"
                        class="border p-2 w-full mb-2"
                    />
                    <p v-if="errors.quantity_available" class="text-red-500">
                    {{ errors.quantity_available }}
                </p>

                    <button
                        type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded"
                    >
                        Save
                    </button>
                </form>
            </div>
        </template>
    </AppLayout>
</template>
