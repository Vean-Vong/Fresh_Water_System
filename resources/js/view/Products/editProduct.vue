<template>
    <div class="container">
        <div class="heading">{{ $t("edit_product") }}</div>
        <form class="form" @submit.prevent="submitProduct">
            <div class="form-row">
                <!-- Left Column -->
                <div class="form-column">
                    <div class="input-field">
                        <label for="select_hot_power" class="form-label">{{
                            $t("model")
                        }}</label>
                        <select
                            v-model="editedProduct.model"
                            class="form-select"
                            required
                        >
                            <option value="" disabled>
                                {{ $t("select_model") }}
                            </option>
                            <option value="GP-900">GP-900</option>
                            <option value="GP-900s">GP-900s</option>
                            <option value="GP-500s">GP-500s</option>
                            <option value="GP-50">GP-50</option>
                            <option value="GP-90">GP-90</option>
                            <option value="G-6000C">G-6000C</option>
                            <option value="G-80B">G-80B</option>
                        </select>
                    </div>

                    <div class="input-field">
                        <label for="select_hot_power" class="form-label">{{
                            $t("color")
                        }}</label>
                        <select
                            v-model="editedProduct.color"
                            class="form-select"
                            required
                        >
                            <option value="" disabled>
                                {{ $t("select_color") }}
                            </option>
                            <option value="Black">Black</option>
                            <option value="White">White</option>
                            <option value="White Silver">White Silver</option>
                            <option value="Black Silver">Black Silver</option>
                        </select>
                    </div>

                    <div class="input-field">
                        <label for="select_hot_power" class="form-label">{{
                            $t("filtration_stage")
                        }}</label>
                        <select
                            v-model="editedProduct.filtration_stage"
                            class="form-select"
                            required
                        >
                            <option value="" disabled>
                                {{ $t("select_filtration_stage") }}
                            </option>
                            <option value="4">4(Filters)</option>
                            <option value="5">5(Filters)</option>
                            <!-- Add any other options you need -->
                        </select>
                    </div>

                    <div class="input-field">
                        <label for="select_hot_power" class="form-label">{{
                            $t("cold_water_tank_capacity")
                        }}</label>
                        <select
                            v-model="editedProduct.cold_water_tank_capacity"
                            class="form-select"
                            required
                        >
                            <option value="" disabled>
                                {{ $t("select_cold_capacity") }}
                            </option>
                            <option value="8L">8L</option>
                            <option value="5L">5L</option>
                            <option value="3L">3L</option>
                            <option value="3.5L">3.5L</option>
                            <option value="7.5L">7.5L</option>
                        </select>
                    </div>

                    <div class="input-field">
                        <label for="select_hot_power" class="form-label">{{
                            $t("hot_water_tank_capacity")
                        }}</label>
                        <select
                            v-model="editedProduct.hot_water_tank_capacity"
                            class="form-select"
                            required
                        >
                            <option value="" disabled>
                                {{ $t("select_hot_capacity") }}
                            </option>
                            <option value="3L">3L</option>
                            <option value="5L">5L</option>
                            <option value="2.15L">2.15L</option>
                            <option value="1.25L">1.25L</option>
                            <option value="1.5L">1.5L</option>
                        </select>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <div class="input-field">
                        <label for="select_hot_power" class="form-label">{{
                            $t("heating_capacity")
                        }}</label>
                        <select
                            v-model="editedProduct.heating_capacity"
                            class="form-select"
                            required
                        >
                            <option value="" disabled>
                                {{ $t("select_heating_capacity") }}
                            </option>
                            <option value="80C-90C">80C-90C</option>
                        </select>
                    </div>

                    <div class="input-field">
                        <label for="select_hot_power" class="form-label">{{
                            $t("cold_power_consumption")
                        }}</label>
                        <select
                            v-model="editedProduct.cold_power_consumption"
                            class="form-select"
                            required
                        >
                            <option value="" disabled>
                                {{ $t("select_cold_power") }}
                            </option>
                            <option value="100W">100W</option>
                            <option value="110W">110W</option>
                        </select>
                    </div>

                    <div class="input-field">
                        <label for="select_hot_power" class="form-label">{{
                            $t("hot_power_consumption")
                        }}</label>
                        <select
                            v-model="editedProduct.hot_power_consumption"
                            class="form-select"
                            required
                        >
                            <option value="" disabled>
                                {{ $t("select_hot_power") }}
                            </option>
                            <option value="430W">430W</option>
                            <option value="300W">300W</option>
                        </select>
                    </div>

                    <div class="input-field">
                        <label for="quantity" class="form-label">{{
                            $t("quantity")
                        }}</label>
                        <select
                            v-model="editedProduct.quantity"
                            class="form-select"
                            required
                        >
                            <option value="" disabled>
                                {{ $t("select_quantity") }}
                            </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>

                    <div class="input-field">
                        <label for="select_hot_power" class="form-label">{{
                            $t("image")
                        }}</label>
                        <input
                            class="form-control"
                            type="file"
                            @change="handleFileUpload"
                        />
                    </div>
                </div>
            </div>

            <div class="btn-container">
                <button
                    class="btn bg-danger text-white text-center"
                    type="button"
                    @click="goBack"
                >
                    {{ $t("cancel") }}
                </button>
                <button
                    class="btn bg-primary text-white text-center"
                    type="submit"
                    :disabled="isSubmitting"
                >
                    {{ $t("update") }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
    data() {
        return {
            editedProduct: {
                id: null,
                model: "",
                color: "",
                filtration_stage: "",
                cold_water_tank_capacity: "",
                hot_water_tank_capacity: "",
                heating_capacity: "",
                cold_power_consumption: "",
                hot_power_consumption: "",
                quantity: "",
                image: null, // Handle image upload
            },
            errorMessage: "",
            isSubmitting: false, // Flag to disable the submit button while submitting
        };
    },
    created() {
        this.fetchProduct();
    },
    methods: {
        async fetchProduct() {
            try {
                const productId = this.$route.params.id;
                console.log("Product ID from route:", productId);

                if (!productId) {
                    console.error("No product ID found in route");
                    this.errorMessage = "Invalid product ID.";
                    return;
                }

                const response = await axios.get(
                    `http://127.0.0.1:8000/api/products/${productId}`
                );

                console.log("API Response:", response.data);

                if (response.data) {
                    this.editedProduct = response.data;
                    console.log("Edited Product:", this.editedProduct);
                } else {
                    console.error("No data received from API");
                    this.errorMessage = "No product data found.";
                }
            } catch (error) {
                console.error("Fetch Error:", error);
                this.errorMessage = "Failed to fetch product data.";
            }
        },
        async submitProduct() {
            this.isSubmitting = true;
            const formData = new FormData();

            formData.append("_method", "PATCH"); // Explicitly tell Laravel it's a PATCH request
            formData.append("model", this.editedProduct.model);
            formData.append("color", this.editedProduct.color);
            formData.append(
                "filtration_stage",
                String(this.editedProduct.filtration_stage)
            );
            formData.append(
                "cold_water_tank_capacity",
                this.editedProduct.cold_water_tank_capacity
            );
            formData.append(
                "hot_water_tank_capacity",
                this.editedProduct.hot_water_tank_capacity
            );
            formData.append(
                "heating_capacity",
                this.editedProduct.heating_capacity
            );
            formData.append(
                "cold_power_consumption",
                this.editedProduct.cold_power_consumption
            );
            formData.append(
                "hot_power_consumption",
                this.editedProduct.hot_power_consumption
            );
            formData.append("quantity", String(this.editedProduct.quantity));

            // Only append the image if a new file is selected
            if (this.editedProduct.image instanceof File) {
                formData.append("image", this.editedProduct.image);
            }

            try {
                const response = await axios.post(
                    `http://127.0.0.1:8000/api/products/${this.editedProduct.id}`,
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );

                console.log("Product updated successfully:", response.data);
                toast.fire({
                    icon: "success",
                    title: this.$t("product_updated_success"),
                });

                // Refetch updated data
                this.fetchProduct();
                this.$router.push("/products");
            } catch (error) {
                console.error(
                    "Error updating product:",
                    error.response ? error.response.data : error.message
                );
                Swal.fire(
                    "Error",
                    error.response?.data?.message ||
                        "Failed to update product. Please try again.",
                    "error"
                );
            } finally {
                this.isSubmitting = false;
            }
        },
        goBack() {
            this.$router.go(-1); // Go back to the previous page
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.editedProduct.image = file; // Set the image to the editedProduct
            }
        },
    },
};
</script>

<style scoped>
.container {
    padding: 20px;
    border-radius: 20px;
    background-color: #fff;
}

.container .heading {
    font-size: 1.8rem;
    margin-bottom: 20px;
    font-weight: bolder;
}

.form-select {
    height: 48px;
    border: #8d8d8d solid 1px;
}

/* Two-column layout */
.form-row {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.form-column {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.input-field {
    position: relative;
}

.input-field input {
    padding: 10px 15px;
    font-size: 1rem;
    border-radius: 8px;
    border: solid 1px #8d8d8d;
    width: 100%;
}

.btn-container {
    margin-top: 20px;
    display: flex;
    gap: 20px;
}

.btn {
    width: 200px;
    text-align: center;
}
</style>
