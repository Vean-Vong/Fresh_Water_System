<template>
    <div>
        <!-- Customer Table -->
        <div class="container">
            <div class="addCustomer">
                <router-link to="/addCustomer">
                    <button class="btnAdd text-white">
                        <i class="fas fa-plus"></i> {{ $t("new_customer") }}
                    </button></router-link
                >
                <div class="input-group" style="width: 500px">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Search here..."
                        v-model="searchQuery"
                    />
                    <button class="btnSearch" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr class="table">
                        <th class="table-title text-white">ID</th>
                        <th class="table-title text-white">
                            {{ $t("customer_name") }}
                        </th>
                        <th class="table-title text-white">
                            {{ $t("address") }}
                        </th>
                        <th class="table-title text-white">
                            {{ $t("phone") }}
                        </th>
                        <th class="table-title text-white">{{ $t("date") }}</th>
                        <th class="table-title text-white">
                            {{ $t("job") }}
                        </th>
                        <th class="table-title text-white">
                            {{ $t("action") }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <div v-if="loading" class="center-loader-container">
                        <div class="loader"></div>
                    </div>

                    <!-- Show error message if request fails -->
                    <tr v-else-if="errorMessage">
                        <td colspan="10" class="text-center text-danger">
                            {{ errorMessage }}
                        </td>
                    </tr>

                    <!-- Show "No data" message if the response is empty -->
                    <tr v-else-if="customers.length === 0">
                        <td colspan="10" class="text-center">
                            {{ $t("no_customer_available") }}
                        </td>
                    </tr>

                    <tr v-for="customer in customers" :key="customer.id">
                        <td>{{ customer.id }}</td>
                        <td>{{ customer.name }}</td>
                        <td>{{ customer.address }}</td>
                        <td>{{ customer.phone }}</td>
                        <td>{{ formatDate(customer.date) }}</td>
                        <td>{{ customer.job }}</td>
                        <td>
                            <button
                                class="btn btn-sm btn-warning btn-view"
                                @click="openViewDialog(customer)"
                            >
                                <i class="fas fa-print"></i>
                            </button>
                            <router-link :to="`/editCustomer/${customer.id}`">
                                <button class="btn btn-sm btn-warning btn-edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </router-link>

                            <button
                                class="btn btn-sm btn-danger btn-delete"
                                @click="deleteCustomer(customer.id)"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- View Customer Modal -->
        <div v-if="showViewDialog" class="modal">
            <div class="modal-content">
                <h3 class="title">{{ $t("view_customer") }}</h3>
                <p>
                    <strong>{{ $t("customer_name") }}:</strong> {{ editedCustomer.name }}
                </p>
                <p>
                    <strong>{{ $t("address") }}:</strong>
                    {{ editedCustomer.address }}
                </p>
                <p>
                    <strong>{{ $t("phone") }}:</strong>
                    {{ editedCustomer.phone }}
                </p>
                <p>
                    <strong>{{ $t("date") }}:</strong>
                    {{ formatDate(editedCustomer.date) }}
                </p>
                <p>
                    <strong>{{ $t("job") }}:</strong>
                    {{ editedCustomer.job }}
                </p>

                <div class="modal-actions">
                    <button
                        class="btn btn-secondary"
                        @click="showViewDialog = false"
                    >
                        {{ $t("cancel") }}
                    </button>
                    <!-- Print Button -->
                    <button class="btn btn-primary" @click="printCustomer">
                        <i class="fas fa-print"></i> {{ $t("print") }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2"; // Import SweetAlert2

export default {
    data() {
        return {
            customers: [],
            loading: true,
            searchQuery: "",
            successMessage: "",
            errorMessage: "",
            showViewDialog: false,

        };
    },

    mounted() {
        this.fetchCustomers();
    },
    computed: {
        customers() {
            return this.customers.filter((customer) => {
                return customer.name
                    .toLowerCase()
                    .includes(this.searchQuery.toLowerCase());
            });
        },
    },
    methods: {
        async fetchCustomers() {
            this.loading = true;
            this.errorMessage = "";

            try {
                const response = await axios.get(
                    "http://127.0.0.1:8000/api/customers"
                );
                this.customers = response.data.customers.data;
            } catch (error) {
                console.error(error);
                this.errorMessage = "Failed to load customers.";
            } finally {
                this.loading = false;
            }
        },

        // Open the edit dialog with the selected customer's data
        openEditDialog(customer) {
            this.editedCustomer = { ...customer }; // Clone the customer data

            // If the date exists, format it to YYYY-MM-DD
            if (this.editedCustomer.date) {
                const date = new Date(this.editedCustomer.date);
                // Use toLocaleDateString() or manually format to YYYY-MM-DD
                this.editedCustomer.date = date.toISOString().split("T")[0]; // Formats date to YYYY-MM-DD
            }

            this.showEditDialog = true; // Show the modal
        },


        openViewDialog(customer) {
            this.editedCustomer = { ...customer }; // Clone the customer data
            this.showViewDialog = true; // Show the modal
        },

        // Print function
        printCustomer() {
            window.print();
        },



        deleteCustomer(id) {
            Swal.fire({
                title: this.$t("are_you_sure"),
                text: this.$t("once_delete"),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText:this.$t('Yes_delete_it'),
                cancelButtonText: this.$t("cancel"),
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`http://127.0.0.1:8000/api/customers/${id}`)
                        .then(() => {
                            this.fetchCustomers(); // Refresh the list
                            Swal.fire(
                                this.$t('Deleted'),
                               this.$t('customer_deleted'),
                                "success"
                            );
                        })
                        .catch((error) => {
                            console.error(error);
                            this.errorMessage = "Failed to delete customer.";
                            Swal.fire(
                                "Error!",
                                "Failed to delete customer.",
                                "error"
                            );
                        });
                }
            });
        },

        formatDate(date) {
            if (!date) return "";
            const options = { year: "numeric", month: "long", day: "numeric" };
            return new Date(date).toLocaleDateString("en-US", options);
        },
    },
    created() {
        this.fetchCustomers();
    },
};
</script>

<style scoped>
/* Center the loader in the viewport */
.center-loader-container {
    display: flex;
    padding-bottom: 10px;
    padding-left: 600px;
}

.loader {
    width: 25px;
    height: 50px;
    display: grid;
    color: #000;
    background: linear-gradient(currentColor 0 0) top/100% 2px,
        radial-gradient(
                farthest-side at top,
                #0000 calc(100% - 2px),
                currentColor calc(100% - 1px),
                #0000
            )
            top,
        linear-gradient(currentColor 0 0) bottom/100% 2px,
        radial-gradient(
                farthest-side at bottom,
                #0000 calc(100% - 2px),
                currentColor calc(100% - 1px),
                #0000
            )
            bottom;
    background-size: 100% 1px, 100% 50%;
    background-repeat: no-repeat;
    animation: l18 4s infinite linear;
}

.loader::before,
.loader::after {
    content: "";
    grid-area: 1/1;
    background: inherit;
    border: inherit;
    animation: inherit;
}

.loader::after {
    animation-duration: 2s;
}

@keyframes l18 {
    100% {
        transform: rotate(1turn);
    }
}
.btnSearch {
    background: linear-gradient(to right, #010921, #202c3c);
    color: white;
}
.form-control {
    border: #010921 solid 1px;
}

h2,
h3 {
    font-family: "Moul", serif;
    font-weight: 400;
    font-style: normal;
    font-size: 28px;
}
.btnAdd {
    background: linear-gradient(to right, #010921, #202c3c);
}
.table-title {
    background: linear-gradient(to right, #010921, #202c3c);
    font-family: "Content", serif;
}
.container {
    margin-left: -20px;
}
.addCustomer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
    padding-left: 2px;
}

.table {
    width: 110%;
    border-collapse: collapse;
}
.table th,
.table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
    font-size: 15px;
    vertical-align: middle;

}
.alert {
    transition: opacity 0.8s ease-in-out;
}

/* Transparent background for buttons */

.btn-view {
    background-color: transparent !important;
    border: none;
    padding: 6px 12px;
    cursor: pointer;
    font-size: 18px;
}
.btn-edit {
    background-color: transparent !important;
    border: none;
    padding: 6px 2px;
    cursor: pointer;
    font-size: 18px;
}

.btn-delete {
    background-color: transparent !important;
    border: none;
    padding: 6px 12px;
    cursor: pointer;
    color: red;
}

/* Modal Overlay */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7); /* Darker overlay for better focus */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000; /* Ensure it's above other elements */
}
.title {
    font-size: 30px;
    font-weight: 300;
}
/* Modal Content */
.modal-content {
    /* background: #fff; */
    padding: 25px;
    width: 400px;
    max-width: 90%; /* Make the modal responsive on smaller screens */
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Slight shadow for depth */
    animation: fadeIn 0.3s ease-out;
}

/* Fade-in animation for smooth appearance */
@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: scale(0.9);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

/* Label Styles */
label {
    font-size: 18px;
    font-weight: 500;
    display: block;
    color: #333;
    margin-bottom: -10px;
}

/* Modal Actions (buttons) */
.modal-actions {
    display: flex;
    justify-content: space-between; /* Align buttons to the right */
    gap: 10px; /* Space between buttons */
    margin-top: 20px;
}

/* Button Styles */
button {
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

/* Save Button */
.btn-success {
    background-color: #28a745;
    color: white;
}

.btn-success:hover {
    background-color: #218838;
}

/* Cancel Button */
.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

/* Close Button and Cancel Button - Styling */
button:hover {
    transform: translateY(-2px); /* Slight hover effect */
}
</style>
