<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps, ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    product: Object,
});

const form = ref({
    name: props.product.name,
    price: props.product.price,
    quantity_available: props.product.quantity_available,
});

const errors = computed(() => usePage().props.errors || {});

const submit = () => {
    router.put(`/products/${props.product.id}`, form.value);
};
</script>
<template>
    <AppLayout title="Edit Product">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Product
            </h2>

            <div>
                <form @submit.prevent="submit">
                    <label>Name:</label>
                    <input
                        type="text"
                        v-model="form.name"
                        class="border p-2 w-full mb-2"
                    />
                    <p v-if="errors.name" class="text-red-500">
                        {{ errors.name }}
                    </p>

                    <label>Price:</label>
                    <input
                        type="number"
                        v-model="form.price"
                        class="border p-2 w-full mb-2"
                    />
                    <p v-if="errors.price" class="text-red-500">
                        {{ errors.price }}
                    </p>

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
                        class="bg-gray-500 text-white px-4 py-2 rounded"
                    >
                        Update
                    </button>
                </form>
            </div>
        </template>
    </AppLayout>
</template>
