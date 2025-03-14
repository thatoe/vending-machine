<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

defineProps({
    transactions: Object,
});

const page = usePage();
const user = page.props.auth.user;

</script>

<template>
    <AppLayout title="Transactions">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Transaction List
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <table class="mt-4 border-collapse w-full">
                <tr>
                    <th class="border border-gray-400 px-4 py-2">Customer Name</th>
                    <th class="border border-gray-400 px-4 py-2">Product Name</th>
                    <th class="border border-gray-400 px-4 py-2">Price</th>
                    <th class="border border-gray-400 px-4 py-2">QTY</th>
                    <th class="border border-gray-400 px-4 py-2">Total Price</th>
                </tr>
                <tr v-for="transaction in transactions.data" :key="transaction.id">
                    <td class="border border-gray-400 px-4 py-2">
                        {{ transaction.user.name }}
                    </td>
                    <td class="border border-gray-400 px-4 py-2">
                        {{ transaction.product.name }}
                    </td>
                    <td class="border border-gray-400 px-4 py-2">
                        {{ transaction.product.price }}
                    </td>
                    <td class="border border-gray-400 px-4 py-2">
                        {{ transaction.quantity }}
                    </td>
                    <td class="border border-gray-400 px-4 py-2">
                        {{ transaction.total_price }}
                    </td>
                </tr>
            </table>

            <div class="mt-4">
                <button
                    v-if="transactions.prev_page_url"
                    @click="navigate(transactions.prev_page_url)"
                    class="bg-gray-500 text-black px-4 py-2 rounded mr-2"
                >
                    Previous
                </button>

                <button
                    v-if="transactions.next_page_url"
                    @click="navigate(transactions.next_page_url)"
                    class="bg-gray-500 text-black px-4 py-2 rounded"
                >
                    Next
                </button>
            </div>
        </div>
    </AppLayout>
</template>
