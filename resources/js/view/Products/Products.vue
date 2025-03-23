<template>
    <!-- Product Table -->
    <div class="container">
        <div class="addCustomer">
            <router-link to="/addProduct">
                <button class="btnAdd text-white">
                    <i class="fas fa-plus"></i> {{ $t("new_product") }}
                </button></router-link
            >
            <div class="input-group" style="width: 500px">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Search here..."
                    v-model="searchQuery"
                />
                <button class="btnSearch" type="button" @click="searchProduct">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th class="table-title text-white">ID</th>
                    <th class="table-title text-white">{{ $t("image") }}</th>
                    <th class="table-title text-white">{{ $t("model") }}</th>
                    <th class="table-title text-white">{{ $t("color") }}</th>
                    <th class="table-title text-white">
                        {{ $t("filtration_stage") }}
                    </th>
                    <th class="table-title text-white">
                        {{ $t("cold_water_tank_capacity") }}
                    </th>
                    <th class="table-title text-white">
                        {{ $t("hot_water_tank_capacity") }}
                    </th>
                    <th class="table-title text-white">
                        {{ $t("heating_capacity") }}
                    </th>
                    <th class="table-title text-white">
                        {{ $t("cold_power_consumption") }}
                    </th>
                    <th class="table-title text-white">
                        {{ $t("hot_power_consumption") }}
                    </th>
                    <th class="table-title text-white">{{ $t("quantity") }}</th>
                    <th class="table-title text-white">{{ $t("action") }}</th>
                </tr>
            </thead>
            <tbody>
                <!-- Show loader inside the table -->
                <tr v-if="loading">
                    <td colspan="12" class="text-center">
                        <div class="center-loader-container">
                            <div class="loader"></div>
                        </div>
                    </td>
                </tr>

                <!-- Show message if no products are available -->
                <tr v-else-if="products.length === 0">
                    <td colspan="12" class="text-center">
                        {{ $t("no_product_available") }}
                    </td>
                </tr>

                <tr v-for="product in filteredProducts" :key="product.id">
                    <td>{{ product.id }}</td>
                    <td>
                        <img
                            :src="getFullImageUrl(product.image)"
                            alt="Product Image"
                            class="img-fluid"
                            style="width: 70px; height: auto"
                        />
                    </td>
                    <td>{{ product.model }}</td>
                    <td>{{ product.color }}</td>
                    <td>{{ product.filtration_stage }}</td>
                    <td>{{ product.cold_water_tank_capacity }}</td>
                    <td>{{ product.hot_water_tank_capacity }}</td>
                    <td>{{ product.heating_capacity }}</td>
                    <td>{{ product.cold_power_consumption }}</td>
                    <td>{{ product.hot_power_consumption }}</td>
                    <td>{{ product.quantity }}</td>

                    <td>
                        <button
                            class="btn btn-sm btn-warning btn-view"
                            @click="openViewDialog(product)"
                        >
                            <i class="fas fa-print"></i>
                        </button>
                        <router-link :to="`/editProduct/${product.id}`">
                            <button class="btn btn-sm btn-warning btn-edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </router-link>

                        <button
                            class="btn btn-sm btn-danger btn-delete"
                            @click="deleteProduct(product.id)"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- View Product Dialog (for print) -->
    <div v-if="showViewDialog" class="modal">
        <div class="modal-content">
            <h3 class="title">{{ $t("view_product") }}</h3>
            <div class="view_detail">
                <div class="dataDetail">
                    <p>
                        <strong>{{ $t("model") }}:</strong>
                        {{ selectedProduct.model }}
                    </p>
                    <p>
                        <strong>{{ $t("color") }}:</strong>
                        {{ selectedProduct.color }}
                    </p>
                    <p>
                        <strong>{{ $t("filtration_stage") }}:</strong>
                        {{ selectedProduct.filtration_stage }}
                    </p>
                    <p>
                        <strong>{{ $t("cold_water_tank_capacity") }}:</strong>
                        {{ selectedProduct.cold_water_tank_capacity }}
                    </p>
                    <p>
                        <strong>{{ $t("hot_water_tank_capacity") }}:</strong>
                        {{ selectedProduct.hot_water_tank_capacity }}
                    </p>
                    <p>
                        <strong>{{ $t("heating_capacity") }}:</strong>
                        {{ selectedProduct.heating_capacity }}
                    </p>
                    <p>
                        <strong>{{ $t("cold_power_consumption") }}:</strong>
                        {{ selectedProduct.cold_power_consumption }}
                    </p>
                    <p>
                        <strong>{{ $t("hot_power_consumption") }}:</strong>
                        {{ selectedProduct.hot_power_consumption }}
                    </p>
                    <p>
                        <strong>{{ $t("quantity") }}:</strong>
                        {{ selectedProduct.quantity }}
                    </p>
                </div>
                <div class="image">
                    <img
                        :src="getFullImageUrl(selectedProduct.image)"
                        alt="Product Image"
                        width="200"
                        height="200"
                    />
                </div>
            </div>

            <div class="modal-actions">
                <button class="btn btn-secondary" @click="closeViewDialog">
                    {{ $t("cancel") }}
                </button>
                <button class="btn btn-primary" @click="printProduct">
                    <i class="fas fa-print"></i> {{ $t("print") }}
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.view_detail {
    display: flex;
    justify-content: space-between;
    align-items: center;
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
</style>
<script>
import axios from "axios";
import Swal from "sweetalert2"; // Import SweetAlert2

export default {
    data() {
        return {
            products: [],
            loading: true,
            showViewDialog: false,
            searchQuery: "",
        };
    },
    computed: {
        filteredProducts() {
            const searchQueryLower = this.searchQuery.toLowerCase();
            return this.products.filter((product) => {
                // Ensure name and model exist before calling toLowerCase()
                const name = product.name ? product.name.toLowerCase() : "";
                const model = product.model ? product.model.toLowerCase() : "";
                return (
                    name.includes(searchQueryLower) ||
                    model.includes(searchQueryLower)
                );
            });
        },
    },
    methods: {
        fetchProducts() {
            this.loading = true;
            axios
                .get("http://127.0.0.1:8000/api/products")
                .then((response) => {
                    console.log("API Response:", response.data); // Debug API output
                    this.products = response.data;
                })
                .catch((error) => console.error("Fetch error:", error))
                .finally(() => {
                    this.loading = false;
                });
        },

        handleImageChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.newProduct.image = file;
            }
        },

        handleEditImageChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.selectedProduct.image = file;
            }
        },
        deleteProduct(productId) {
            Swal.fire({
                title: this.$t("are_you_sure"),
                text: this.$t("once_delete"),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                cancelButtonText: this.$t("cancel"),
                confirmButtonText: this.$t("Yes_delete_it"),
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(
                            `http://127.0.0.1:8000/api/products/${productId}`
                        )
                        .then(() => {
                            this.fetchProducts();
                            Swal.fire(
                                this.$t("Deleted"),
                                this.$t("product_deleted"),
                                "success"
                            );
                        })
                        .catch((error) => {
                            console.error(error);
                            Swal.fire(
                                "Error",
                                "Failed to delete product",
                                "error"
                            );
                        });
                }
            });
        },

        openViewDialog(product) {
            this.selectedProduct = { ...product }; // Clone product for view
            this.showViewDialog = true;
        },

        closeViewDialog() {
            this.showViewDialog = false;
        },

        printProduct() {
            window.print();
            printWindow.document.close();
        },

        getFullImageUrl(imagePath) {
            if (!imagePath) return "https://via.placeholder.com/150"; // Default image
            return `http://127.0.0.1:8000/storage/${imagePath}`;
        },
    },

    created() {
        this.fetchProducts();
    },
};
</script>
