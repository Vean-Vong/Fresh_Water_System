<template>
    <div>
        <!-- Customer Table -->
        <div class="container">
            <div class="addCustomer">
                <h2>Customer List</h2>
                <button class="btn btn-primary" @click="openAddDialog">
                    <i class="fas fa-plus"></i> New Customer
                </button>
            </div>

            <table class="table">
                <thead>
                    <tr class="table">
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
                <tbody>
                    <tr v-for="customer in customers" :key="customer.id">
                        <td>{{ customer.id }}</td>
                        <td>{{ customer.name }}</td>
                        <td>{{ customer.address }}</td>
                        <td>{{ customer.phone }}</td>
                        <td>{{ formatDate(customer.date) }}</td>
                        <td>{{ customer.model }}</td>
                        <td>{{ customer.seller }}</td>
                        <td>{{ customer.contract_type }}</td>
                        <td>
                            <button
                                class="btn btn-sm btn-warning btn-view"
                                @click="openViewDialog(customer)"
                            >
                                <i class="fas fa-print"></i>
                            </button>
                            <button
                                class="btn btn-sm btn-warning btn-edit"
                                @click="openEditDialog(customer)"
                            >
                                <i class="fas fa-edit"></i>
                            </button>

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

        <!-- Add Customer Dialog -->
        <div v-if="showAddDialog" class="modal">
            <div class="modal-content">
                <h3 class="title">Add Customer</h3>
                <label>Name:</label>
                <input type="text" v-model="newCustomer.name" />

                <label>Address:</label>
                <input type="text" v-model="newCustomer.address" />

                <label>Phone:</label>
                <input type="text" v-model="newCustomer.phone" />

                <label>Date:</label>
                <input type="date" v-model="newCustomer.date" />

                <label>Model:</label>
                <input type="text" v-model="newCustomer.model" />

                <label>Seller:</label>
                <input type="text" v-model="newCustomer.seller" />

                <label>Contract Type:</label>
                <select v-model="newCustomer.contract_type" class="mt-3">
                    <option value="" disabled>Select contract type</option>
                    <option value="installment">installment</option>
                    <option value="rental">rental</option>
                    <option value="buy">buy</option>
                </select>

                <div class="modal-actions">
                    <button class="btn btn-success" @click="addCustomer">
                        Save
                    </button>
                    <button class="btn btn-secondary" @click="closeAddDialog">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- Edit Dialog -->
        <div v-if="showEditDialog" class="modal">
            <div class="modal-content">
                <h3 class="title">Edit Customer</h3>
                <label>Name:</label>
                <input type="text" v-model="editedCustomer.name" />

                <label>Address:</label>
                <input type="text" v-model="editedCustomer.address" />

                <label>Phone:</label>
                <input type="text" v-model="editedCustomer.phone" />

                <label>Date:</label>
                <input type="date" v-model="editedCustomer.date" />

                <label>Model:</label>
                <input type="text" v-model="editedCustomer.model" />

                <label>Seller:</label>
                <input type="text" v-model="editedCustomer.seller" />

                <label>Contract Type:</label>
                <input type="text" v-model="editedCustomer.contract_type" />

                <div class="modal-actions">
                    <button class="btn btn-success" @click="updateCustomer">
                        Save
                    </button>
                    <button
                        class="btn btn-secondary"
                        @click="showEditDialog = false"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- View Customer Modal -->
        <div v-if="showViewDialog" class="modal">
            <div class="modal-content">
                <h3 class="title">Customer Details</h3>
                <p><strong>Name:</strong> {{ editedCustomer.name }}</p>
                <p><strong>Address:</strong> {{ editedCustomer.address }}</p>
                <p><strong>Phone:</strong> {{ editedCustomer.phone }}</p>
                <p>
                    <strong>Date:</strong> {{ formatDate(editedCustomer.date) }}
                </p>
                <p><strong>Model:</strong> {{ editedCustomer.model }}</p>
                <p><strong>Seller:</strong> {{ editedCustomer.seller }}</p>
                <p>
                    <strong>Contract Type:</strong>
                    {{ editedCustomer.contract_type }}
                </p>

                <div class="modal-actions">
                    <button
                        class="btn btn-secondary"
                        @click="showViewDialog = false"
                    >
                        Close
                    </button>
                    <!-- Print Button -->
                    <button class="btn btn-info" @click="printCustomer">
                        <i class="fas fa-print"></i> Print
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
            successMessage: "",
            errorMessage: "",
            showEditDialog: false, // Controls the edit modal
            showAddDialog: false, // Controls the add modal
            showViewDialog: false,
            editedCustomer: {
                id: null,
                name: "",
                address: "",
                phone: "",
                date: "",
                model: "",
                seller: "",
                contract_type: "",
            },
            newCustomer: {
                name: "",
                address: "",
                phone: "",
                date: "",
                model: "",
                seller: "",
                contract_type: "",
            },
        };
    },

    mounted() {
        this.fetchCustomers();
    },
    methods: {
        fetchCustomers() {
            axios
                .get("http://127.0.0.1:8000/api/customers")
                .then((response) => {
                    this.customers = response.data.customers.data;
                })
                .catch((error) => {
                    console.error(error);
                    this.errorMessage = "Failed to load customers.";
                });
        },

        // Open the edit dialog with the selected customer's data
        openEditDialog(customer) {
            this.editedCustomer = { ...customer }; // Clone the customer data
            this.showEditDialog = true; // Show the modal
        },

        // Open the add customer dialog
        openAddDialog() {
            this.newCustomer = {
                // Reset the form for a new customer
                name: "",
                address: "",
                phone: "",
                date: "",
                model: "",
                seller: "",
                contract_type: "",
            };
            this.showAddDialog = true; // Show the add modal
        },

        openViewDialog(customer) {
            this.editedCustomer = { ...customer }; // Clone the customer data
            this.showViewDialog = true; // Show the modal
        },

        // Close the add customer dialog
        closeAddDialog() {
            this.showAddDialog = false;
        },

        // Add the new customer
        addCustomer() {
            axios
                .post("http://127.0.0.1:8000/api/customers", this.newCustomer)
                .then(() => {
                    this.showAddDialog = false;
                    this.fetchCustomers(); // Refresh the list of customers
                    Swal.fire(
                        "Added!",
                        "New customer added successfully.",
                        "success"
                    );
                })
                .catch((error) => {
                    console.error(error);
                    this.errorMessage = "Failed to add customer.";
                    Swal.fire("Error!", "Failed to add customer.", "error");
                });
        },

        // Print function
        printCustomer() {
            const printWindow = window.open("", "", "width=600,height=600");
            printWindow.document.write(
                "<html><head><title>Print Customer</title></head><body>"
            );
            printWindow.document.write("<h3>Customer Details</h3>");
            printWindow.document.write(
                "<p><strong>Name:</strong> " + this.editedCustomer.name + "</p>"
            );
            printWindow.document.write(
                "<p><strong>Address:</strong> " +
                    this.editedCustomer.address +
                    "</p>"
            );
            printWindow.document.write(
                "<p><strong>Phone:</strong> " +
                    this.editedCustomer.phone +
                    "</p>"
            );
            printWindow.document.write(
                "<p><strong>Date:</strong> " +
                    this.formatDate(this.editedCustomer.date) +
                    "</p>"
            );
            printWindow.document.write(
                "<p><strong>Model:</strong> " +
                    this.editedCustomer.model +
                    "</p>"
            );
            printWindow.document.write(
                "<p><strong>Seller:</strong> " +
                    this.editedCustomer.seller +
                    "</p>"
            );
            printWindow.document.write(
                "<p><strong>Contract Type:</strong> " +
                    this.editedCustomer.contract_type +
                    "</p>"
            );
            printWindow.document.write("</body></html>");
            printWindow.document.close();
            printWindow.print();
        },

        updateCustomer() {
            axios
                .put(
                    `http://127.0.0.1:8000/api/customers/${this.editedCustomer.id}`,
                    this.editedCustomer
                )
                .then(() => {
                    this.showEditDialog = false;
                    this.fetchCustomers(); // Refresh the list of customers
                    Swal.fire(
                        "Updated!",
                        "Customer details updated successfully.",
                        "success"
                    );
                })
                .catch((error) => {
                    console.error(error);
                    this.errorMessage = "Failed to update customer.";
                    Swal.fire("Error!", "Failed to update customer.", "error");
                });
        },

        deleteCustomer(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`http://127.0.0.1:8000/api/customers/${id}`)
                        .then(() => {
                            this.fetchCustomers(); // Refresh the list
                            Swal.fire(
                                "Deleted!",
                                "Customer has been deleted.",
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
            return new Date(date).toLocaleDateString();
        },
    },
};
</script>

<style scoped>
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
}
.table th {
    background-color: #f2f2f2;
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
    background: #fff;
    padding: 25px;
    width: 450px;
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

/* Input Fields */
input[type="text"],
input[type="date"] {
    width: 100%;
    padding: 5px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box; /* Ensure padding doesn't affect the width */
    font-size: 18px;
}

/* Label Styles */
label {
    font-size: 20px;
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
