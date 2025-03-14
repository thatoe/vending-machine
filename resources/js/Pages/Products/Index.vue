<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

defineProps({
    products: Object,
});

const page = usePage();
const user = page.props.auth.user;

const deleteProduct = (id) => {
    if (confirm("Are you sure you want to delete this product?")) {
        router.delete(`/products/${id}`);
    }
};

const navigate = (url) => {
    router.get(url);
};
</script>

<template>
    <AppLayout title="Products">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Products List
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <Link
                href="/products/create"
                class="bg-gray-500 text-black px-4 py-2 rounded"
                v-if="user.roles.includes('admin')"
            >
                Add New Product
            </Link>

            <table class="mt-4 border-collapse w-full">
                <tr>
                    <th class="border border-gray-400 px-4 py-2">Name</th>
                    <th class="border border-gray-400 px-4 py-2">Price</th>
                    <th class="border border-gray-400 px-4 py-2">Stock</th>
                    <th class="border border-gray-400 px-4 py-2">Actions</th>
                </tr>
                <tr v-for="product in products.data" :key="product.id">
                    <td class="border border-gray-400 px-4 py-2">
                        {{ product.name }}
                    </td>
                    <td class="border border-gray-400 px-4 py-2">
                        {{ product.price }}
                    </td>
                    <td class="border border-gray-400 px-4 py-2">
                        {{ product.quantity_available }}
                    </td>
                    <td class="border border-gray-400 px-4 py-2">
                        <Link
                            :href="`/products/${product.id}/edit`"
                            class="bg-yellow-500 text-black px-2 py-1 rounded"
                            v-if="user.roles.includes('admin')"
                        >Edit</Link>
                        <button
                            @click="deleteProduct(product.id)"
                            class="bg-red-500 text-black px-2 py-1 rounded ml-2"
                            v-if="user.roles.includes('admin')"
                        >Delete</button>

                        <Link
                            :href="`/products/${product.id}/show`"
                            class="bg-blue-500 text-black px-2 py-1 rounded ml-2"
                            v-if="!user.roles.includes('admin')"
                        >Purchase</Link>
                    </td>
                </tr>
            </table>

            <div class="mt-4">
                <button
                    v-if="products.prev_page_url"
                    @click="navigate(products.prev_page_url)"
                    class="bg-gray-500 text-black px-4 py-2 rounded mr-2"
                >
                    Previous
                </button>

                <button
                    v-if="products.next_page_url"
                    @click="navigate(products.next_page_url)"
                    class="bg-gray-500 text-black px-4 py-2 rounded"
                >
                    Next
                </button>
            </div>
        </div>
    </AppLayout>
</template>