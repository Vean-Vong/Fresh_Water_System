<script setup>
import { onMounted, reactive, ref } from "vue";
import axios from "axios";

// Reactive customer list and form data
const customers = ref([]);
const form = reactive({
    id: null,
    name: "",
    address: "",
    phone: "",
    date: "",
    model: "",
    seller: "",
    contract_type: "",
});

// Dialog state
const isDialogOpen = ref(false);

// Feedback messages
const successMessage = ref("");
const errorMessage = ref("");

// Fetch customers from API or from localStorage
const fetchCustomers = async () => {
    if (localStorage.getItem("customers")) {
        customers.value = JSON.parse(localStorage.getItem("customers"));
    } else {
        try {
            const response = await axios.get("api/customers");
            if (response.data.customers && response.data.customers.data) {
                const newCustomers = response.data.customers.data;

                // Remove duplicates: Check if customer already exists in the list
                newCustomers.forEach((customer) => {
                    if (
                        !customers.value.some(
                            (existingCustomer) =>
                                existingCustomer.id === customer.id
                        )
                    ) {
                        customers.value.push(customer);
                    }
                });

                // localStorage.setItem("customers", JSON.stringify(customers.value));
            }
        } catch (error) {
            console.error("Error fetching customers:", error);
        }
    }
};

// Open dialog
const openDialog = (customer = null) => {
    if (customer) {
        form.id = customer.id;
        form.name = customer.name;
        form.address = customer.address;
        form.phone = customer.phone;
        form.date = customer.date;
        form.model = customer.model;
        form.seller = customer.seller;
        form.contract_type = customer.contract_type;
    } else {
        Object.keys(form).forEach((key) => (form[key] = "")); // Reset form
    }
    isDialogOpen.value = true;
};

// Close dialog
const closeDialog = () => {
    isDialogOpen.value = false;
    Object.keys(form).forEach((key) => (form[key] = "")); // Reset form
};

/// Submit form and add or update customer
const submitForm = async () => {
    try {
        let response;
        if (form.id) {
            // Update existing customer
            response = await axios.put(`api/customers/${form.id}`, form);
            successMessage.value = "Customer updated successfully!";
        } else {
            // Add new customer
            response = await axios.post("api/customers", form);
            successMessage.value = "Customer added successfully!";
        }
        errorMessage.value = ""; // Clear any previous errors
        console.log(response);

        // Update customer list and localStorage
        if (form.id) {
            // Update customer in list
            const index = customers.value.findIndex((c) => c.id === form.id);
            if (index !== -1) {
                customers.value[index] = response.data.customer;
            }
        } else {
            // Add new customer to list
            customers.value.push(response.data.customer);
        }
        localStorage.setItem("customers", JSON.stringify(customers.value));
        closeDialog();

        // Hide success message after 3 seconds
        setTimeout(() => {
            successMessage.value = "";
        }, 3000);
    } catch (error) {
        errorMessage.value = "Failed to save customer. Please try again.";
        console.error(error);

        // Hide error message after 3 seconds
        setTimeout(() => {
            errorMessage.value = "";
        }, 3000);
    }
};

// Delete customer
const deleteCustomer = async (id) => {
    try {
        const response = await axios.delete(`api/customers/${id}`);
        if (response.status === 200) {
            // Remove customer from local list and localStorage
            customers.value = customers.value.filter((c) => c.id !== id);
            localStorage.setItem("customers", JSON.stringify(customers.value));
            successMessage.value = "Customer deleted successfully!";

            // Hide success message after 3 seconds
            setTimeout(() => {
                successMessage.value = "";
            }, 3000);
        }
    } catch (error) {
        errorMessage.value = "Failed to delete customer. Please try again.";
        console.error(error);

        // Hide error message after 3 seconds
        setTimeout(() => {
            errorMessage.value = "";
        }, 3000);
    }
};

// Fetch customers on component mount
onMounted(() => {
    fetchCustomers(); // Call fetchCustomers when the component mounts
});
</script>
<template>
    <div>
        <!-- Customer Table -->
        <div class="container">
            <div class="addCustomer flex justify-between items-center">
                <h2>Customer List</h2>
                <button class="btn btn-primary" @click="openDialog()">
                    <i class="fas fa-plus"></i> New Customer
                </button>
            </div>
            <table class="table">
                <thead>
                    <tr class="table text-center">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Model</th>
                        <th>Seller</th>
                        <th>Contract Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr
                        class="text-center border-none"
                        v-for="(customer, index) in customers"
                        :key="customer.id"
                    >
                        <td>{{ index + 1 }}</td>
                        <td>{{ customer.name }}</td>
                        <td>{{ customer.address }}</td>
                        <td>{{ customer.phone }}</td>
                        <td>{{ customer.date }}</td>
                        <td>{{ customer.model }}</td>
                        <td>{{ customer.seller }}</td>
                        <td>{{ customer.contract_type }}</td>
                        <td>
                            <!-- Edit and Delete buttons -->
                            <button
                                class="btn btn-warning btn-sm m-2"
                                @click="openDialog(customer)"
                            >
                                Edit
                            </button>
                            <button
                                class="btn btn-danger btn-sm"
                                @click="deleteCustomer(customer.id)"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Add/Edit Customer Modal -->
        <div v-if="isDialogOpen" class="modal d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ form.id ? "Edit Customer" : "Add New Customer" }}
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="closeDialog"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <form
                            @submit.prevent="submitForm"
                            class="needs-validation"
                            novalidate
                        >
                            <div class="mb-3">
                                <label for="name" class="form-label"
                                    >Name</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="name"
                                    v-model="form.name"
                                    required
                                />
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label"
                                    >Address</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="address"
                                    v-model="form.address"
                                    required
                                />
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label"
                                    >Phone</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="phone"
                                    v-model="form.phone"
                                    required
                                />
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label"
                                    >Date</label
                                >
                                <input
                                    type="date"
                                    class="form-control"
                                    id="date"
                                    v-model="form.date"
                                    required
                                />
                            </div>

                            <div class="mb-3">
                                <label for="model" class="form-label"
                                    >Model</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="model"
                                    v-model="form.model"
                                    required
                                />
                            </div>

                            <div class="mb-3">
                                <label for="seller" class="form-label"
                                    >Seller</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="seller"
                                    v-model="form.seller"
                                    required
                                />
                            </div>

                            <div class="mb-3">
                                <label for="contract_type" class="form-label"
                                    >Contract Type</label
                                >
                                <select
                                    id="contract_type"
                                    class="form-select"
                                    v-model="form.contract_type"
                                    required
                                >
                                    <option value="" disabled>
                                        Select contract type
                                    </option>
                                    <option value="installment">
                                        Installment
                                    </option>
                                    <option value="rental">Rental</option>
                                    <option value="buy">Buy</option>
                                </select>
                            </div>

                            <div class="bottom">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    @click="closeDialog"
                                >
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success and Error Messages -->
        <div v-if="successMessage" class="alert alert-success mt-3">
            {{ successMessage }}
        </div>
        <div v-if="errorMessage" class="alert alert-danger mt-3">
            {{ errorMessage }}
        </div>
    </div>
</template>

<style scoped>
.container {
    margin-left: -20px;
}
.addCustomer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.bottom {
    display: flex;
    justify-content: space-between;
}
.alert {
    transition: opacity 0.8s ease-in-out;
}

.alert-enter-active,
.alert-leave-active {
    transition: opacity 0.5s;
}

.alert-leave-to {
    opacity: 0;
}

/* table {
    border-collapse: collapse;
    width: 100%;
    border-bottom: 2px solid #000;
}

th,
td {
    border: none;
    text-align: center;
} */
</style>
