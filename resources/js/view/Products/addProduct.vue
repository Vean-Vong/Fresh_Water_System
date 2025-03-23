<template>
    <div class="container">
        <div class="heading">{{ $t("new_product") }}</div>
        <form class="form" @submit.prevent="submitProduct">
            <div class="form-row">
                <!-- Left Column -->
                <div class="form-column">
                    <select
                        v-model="addProduct.model"
                        class="form-select"
                        required
                    >
                        <option value="" disabled>
                            {{ $t("model") }}
                        </option>
                        <option value="GP-900">GP-900</option>
                        <option value="GP-900s">GP-900s</option>
                        <option value="GP-500s">GP-500s</option>
                        <option value="GP-50">GP-50</option>
                        <option value="GP-90">GP-90</option>
                        <option value="G-6000C">G-6000C</option>
                        <option value="G-80B">G-80B</option>
                    </select>

                    <select
                        v-model="addProduct.color"
                        class="form-select"
                        required
                    >
                        <option value="" disabled>
                            {{ $t("color") }}
                        </option>
                        <option value="Black">Black</option>
                        <option value="White">White</option>
                        <option value="White Silver">White Silver</option>
                        <option value="Black Silver">Black Silver</option>
                    </select>

                    <select
                        v-model="addProduct.filtration_stage"
                        class="form-select"
                        required
                    >
                        <option value="" disabled>
                            {{ $t("filtration_stage") }}
                        </option>
                        <option value="4">4(Filters)</option>
                        <option value="5">5(Filters)</option>
                    </select>

                    <select
                        v-model="addProduct.cold_water_tank_capacity"
                        class="form-select"
                        required
                    >
                        <option value="" disabled>
                            {{ $t("cold_water_tank_capacity") }}
                        </option>
                        <option value="8L">8L</option>
                        <option value="5L">5L</option>
                        <option value="3L">3L</option>
                        <option value="3.5L">3.5L</option>
                        <option value="7.5L">7.5L</option>
                    </select>

                    <select
                        v-model="addProduct.hot_water_tank_capacity"
                        class="form-select"
                        required
                    >
                        <option value="" disabled>
                            {{ $t("hot_water_tank_capacity") }}
                        </option>
                        <option value="3L">3L</option>
                        <option value="5L">5L</option>
                        <option value="2.15L">2.15L</option>
                        <option value="1.25L">1.25L</option>
                        <option value="1.5L">1.5L</option>
                    </select>
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <select
                        v-model="addProduct.heating_capacity"
                        class="form-select"
                        required
                    >
                        <option value="" disabled>
                            {{ $t("heating_capacity") }}
                        </option>
                        <option value="80C-90C">80C-90C</option>
                    </select>

                    <select
                        v-model="addProduct.cold_power_consumption"
                        class="form-select"
                        required
                    >
                        <option value="" disabled>
                            {{ $t("cold_power_consumption") }}
                        </option>
                        <option value="100W">100W</option>
                        <option value="110W">110W</option>
                    </select>

                    <select
                        v-model="addProduct.hot_power_consumption"
                        class="form-select"
                        required
                    >
                        <option value="" disabled>
                            {{ $t("hot_power_consumption") }}
                        </option>
                        <option value="300W">300W</option>
                        <option value="430W">430W</option>
                    </select>

                    <select
                        v-model="addProduct.quantity"
                        class="form-select"
                        required
                    >
                        <option value="" disabled>
                            {{ $t("quantity") }}
                        </option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>

                    <div class="input-field">
                        <input
                            class="form-control"
                            required
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
                >
                    {{ $t("save") }}
                </button>
            </div>
        </form>
    </div>
</template>
<script>
import axios from "axios";

export default {
    data() {
        return {
            addProduct: {
                model: "",
                color: "",
                filtration_stage: "",
                cold_capacity: "",
                cold_water_tank_capacity: "",
                hot_water_tank_capacity: "",
                heating_capacity: "",
                cold_power_consumption: "",
                hot_power_consumption: "",
                quantity: "",
                file: null,
            },
        };
    },
    methods: {
        handleFileUpload(event) {
            this.addProduct.file = event.target.files[0];
        },
        submitProduct() {
            // Validate required fields
            if (
                !this.addProduct.model ||
                !this.addProduct.color ||
                !this.addProduct.filtration_stage ||
                !this.addProduct.cold_water_tank_capacity ||
                !this.addProduct.hot_water_tank_capacity ||
                !this.addProduct.heating_capacity ||
                !this.addProduct.cold_power_consumption ||
                !this.addProduct.hot_power_consumption ||
                !this.addProduct.quantity ||
                !this.addProduct.file
            ) {
                Swal.fire({
                    icon: "error",
                    title: this.$t("error"),
                    text: this.$t("please_fill_in_all_fields"),
                });
                return;
            }

            // Convert reactive object to plain object
            const productData = JSON.parse(JSON.stringify(this.addProduct));

            let formData = new FormData();

            // Append fields to FormData, ensuring no empty values
            for (let key in productData) {
                if (
                    productData[key] !== null &&
                    productData[key] !== "" &&
                    key !== "file"
                ) {
                    formData.append(key, productData[key]);
                }
            }

            // Append file separately (use key "image" to match Laravel)
            if (this.addProduct.file instanceof File) {
                formData.append("image", this.addProduct.file);
            }

            // Debug logs
            console.log("Final FormData values:");
            for (let pair of formData.entries()) {
                console.log(pair[0], pair[1]);
            }

            // Axios request
            axios
                .post("http://127.0.0.1:8000/api/products", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    console.log("Success response:", response);

                    if (response.status === 200 || response.status === 201) {
                        toast.fire({
                            icon: "success",
                            title: this.$t("product_added"),
                        });
                        this.$router.go(-1);
                    }
                })
                .catch((error) => {
                    console.error("Error response:", error.response);
                    let errorMessage = this.$t("failed_to_add_product");
                    if (
                        error.response &&
                        error.response.data &&
                        error.response.data.message
                    ) {
                        errorMessage = error.response.data.message;
                    }

                    Swal.fire({
                        icon: "error",
                        title: this.$t("error"),
                        text: errorMessage,
                    });
                });
        },
        goBack() {
            this.$router.go(-1);
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
