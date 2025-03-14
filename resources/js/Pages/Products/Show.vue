<script>
import { ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";  // Ensure this import is correct

export default {
    components: {
        AppLayout,
    },
    props: {
        product: Object,
    },
    data() {
        return {
            quantity: 1,
        };
    },
    methods: {
        handlePurchase() {
            if (
                this.quantity < 1 ||
                this.quantity > this.product.quantity_available
            ) {
                alert("Invalid quantity.");
                return;
            }

            // Make the post request to handle the purchase
            this.$inertia.post(`/products/${this.product.id}/purchase`, {
                quantity: this.quantity,
            });
        },
    },
};
</script>

<template>
    <AppLayout title="Purchase Product">
        <div class="p-4">
            <h1 class="text-2xl font-bold mb-4">Purchase Product</h1>

            <div class="bg-white shadow p-4 rounded-md">
                <h2 class="text-xl font-semibold">{{ product.name }}</h2>
                <p><strong>Price:</strong> ${{ product.price }}</p>
                <p>
                    <strong>Available Stock:</strong>
                    {{ product.quantity_available }}
                </p>

                <div class="mt-4">
                    <label for="quantity" class="block text-lg">Quantity:</label>
                    <input
                        v-model="quantity"
                        type="number"
                        id="quantity"
                        min="1"
                        :max="product.quantity_available"
                        class="border p-2 rounded w-32"
                    />
                    <span
                        v-if="quantity > product.quantity_available"
                        class="text-red-500"
                    >
                        Not enough stock available!
                    </span>
                    <span
                        v-if="quantity < 1"
                        class="text-red-500"
                    >
                        Quantity must be at least 1.
                    </span>
                </div>

                <div class="mt-6">
                    <button
                        @click="handlePurchase"
                        :disabled="quantity < 1 || quantity > product.quantity_available"
                        class="bg-blue-500 text-white px-4 py-2 rounded mr-2"
                    >
                        Buy
                    </button>

                    <inertia-link
                        :href="`/products`"
                        class="bg-gray-500 text-white px-4 py-2 rounded"
                    >
                        Cancel
                    </inertia-link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>