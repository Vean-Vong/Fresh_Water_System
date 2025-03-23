<template>
    <div class="container">
        <h3 class="title">{{ $t("view_customer") }}</h3>

        <div class="customer-details">
            <p>
                <strong>{{ $t("customer_name") }}:</strong> {{ customer.name }}
            </p>
            <p>
                <strong>{{ $t("address") }}:</strong> {{ customer.address }}
            </p>
            <p>
                <strong>{{ $t("phone") }}:</strong> {{ customer.phone }}
            </p>
            <p>
                <strong>{{ $t("date") }}:</strong>
                {{ formatDate(customer.date) }}
            </p>
            <p>
                <strong>{{ $t("job") }}:</strong> {{ customer.job }}
            </p>
        </div>

        <div class="actions">
            <button class="btn btn-secondary" @click="goBack">
                {{ $t("cancel") }}
            </button>
            <button class="btn btn-primary" @click="printCustomer">
                <i class="fas fa-print"></i> {{ $t("print") }}
            </button>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            loading: false,
            customer: {}, // Stores the customer data
        };
    },
    async created() {
        const customerId = this.$route.params.id; // Get ID from route
        if (customerId) {
            await this.fetchCustomerDetails(customerId);
        }
    },
    methods: {
        goBack() {
            this.$router.go(-1); // Navigate back to the previous page
        },

        async fetchCustomerDetails(id) {
            this.loading = true;
            try {
                const response = await axios.get(`/customers/${id}`);
                this.customer = response.data;
            } catch (error) {
                console.error("Error fetching customer:", error);
                this.customer = {}; // Reset to empty object on error
            } finally {
                this.loading = false;
            }
        },

        printCustomer() {
            window.print()
        },

        formatDate(date) {
            if (!date) return "-";
            return new Intl.DateTimeFormat("en-US", {
                year: "numeric",
                month: "long",
                day: "2-digit",
            }).format(new Date(date));
        },
    },
};
</script>

<style scoped>
.container {
    max-width: 600px;
    margin: auto;
    padding: 20px;
    margin-left: 100px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}
.title {
    text-align: center;
    font-weight: bold;
    margin-bottom: 20px;
}
p{
    font-size: 20px;
}
.btn-primary{
    margin-left: 50px;
}
</style>
