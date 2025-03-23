<template>
    <div class="container">
        <div class="heading">{{ $t("edit_sale") }}</div>
        <form class="form" @submit.prevent="editSale">
            <div class="form-row">
                <!-- Left Column -->
                <div class="form-column">
                    <!-- Model Dropdown -->
                    <div class="input-field">
                        <label for="dob" class="form-label">{{
                            $t("model")
                        }}</label>
                        <select
                            class="form-select"
                            required
                            v-model="newSale.model"
                            :placeholder="$t('model')"
                        >
                        <option disabled value="">{{ $t("model") }}</option>
                            <option value="GP-900">GP-900</option>
                            <option value="GP-900s">GP-900s</option>
                            <option value="GP-500s">GP-500s</option>
                            <option value="GP-50">GP-50</option>
                            <option value="GP-90">GP-90</option>
                            <option value="G-6000C">G-6000C</option>
                            <option value="G-80B">G-80B</option>
                        </select>
                    </div>

                    <!-- Price Dropdown -->
                    <div class="input-field">
                        <label for="dob" class="form-label">{{
                            $t("price")
                        }}</label>
                        <select
                            class="form-select"
                            required
                            v-model="newSale.price"
                            :placeholder="$t('price')"
                        >
                        <option disabled value="">{{ $t("price") }}</option>
                            <option value="790">{{ $t("$790(purchase)") }}</option>
                            <option value="720">{{ $t("$720(purchase)") }}</option>
                            <option value="545">{{ $t("$545(purchase)") }}</option>
                            <option value="490">{{ $t("$490(purchase)") }}</option>
                            <option value="30">{{ $t("$30(installment)") }}</option>
                            <option value="28">{{ $t("$28(installment)") }}</option>
                            <option value="26">{{ $t("$26(installment)") }}</option>
                            <option value="23">{{ $t("$23(installment)") }}</option>
                            <option value="28">{{ $t("$28(rental)") }}</option>
                            <option value="27">{{ $t("$27(rental)") }}</option>
                            <option value="25">{{ $t("$25(rental)") }}</option>
                            <option value="23">{{ $t("$23(rental)") }}</option>
                        </select>
                    </div>

                    <!-- Discount Dropdown -->
                    <div class="input-field">
                        <label for="dob" class="form-label">{{
                            $t("discount")
                        }}</label>
                        <select
                            class="form-select"
                            required
                            v-model="newSale.discount"
                            :placeholder="$t('discount')"
                        >
                            <option disabled value="">
                                {{ $t("select_discount") }}
                            </option>
                            <option value="0">{{ $t("0") }}%</option>
                            <option value="10">{{ $t("10") }}%</option>
                            <option value="20">{{ $t("20") }}%</option>
                        </select>
                    </div>

                    <!-- Date Input -->
                    <div class="mb-3 date">
                        <label for="dob" class="form-label">{{
                            $t("date")
                        }}</label>
                        <input
                            type="date"
                            class="form-control"
                            id="dob"
                            v-model="newSale.date"
                            required
                        />
                    </div>
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <!-- Duration Dropdown -->
                    <div class="input-field">
                        <label for="dob" class="form-label">{{
                            $t("duration")
                        }}</label>
                        <select
                            class="form-select"
                            required
                            v-model="newSale.duration"
                            :placeholder="$t('duration')"
                        >
                            <option disabled value="">
                                {{ $t("select_duration") }}
                            </option>
                            <option value="6 months">
                                {{ $t("6 months") }}
                            </option>
                            <option value="1 year">{{ $t("1 year") }}</option>
                            <option value="3 years">{{ $t("3 years") }}</option>
                            <option value="Unlimited">{{ $t("Unlimited") }}</option>
                        </select>
                    </div>

                    <!-- Warranty Dropdown -->
                    <div class="input-field">
                        <label for="dob" class="form-label">{{
                            $t("warranty")
                        }}</label>
                        <select
                            class="form-select"
                            required
                            v-model="newSale.warranty"
                            :placeholder="$t('warranty')"
                        >
                            <option disabled value="">
                                {{ $t("select_warranty") }}
                            </option>
                            <option value="Free monthly maintenance">
                                {{ $t("Free monthly maintenance") }}
                            </option>
                        </select>
                    </div>

                    <!-- Seller Input -->
                    <div class="input-field">
                        <label for="dob" class="form-label">{{
                            $t("seller")
                        }}</label>
                        <input
                            class="form-control"
                            required
                            type="text"
                            v-model="newSale.seller"
                            :placeholder="$t('seller')"
                        />
                    </div>
                    <!-- Contract Type Dropdown -->
                    <div class="input-field">
                        <label for="dob" class="form-label">{{
                            $t("contract")
                        }}</label>
                        <select
                            class="form-select"
                            required
                            v-model="newSale.contract_type"
                            :placeholder="$t('contract_type')"
                        >
                            <option disabled value="">
                                {{ $t("select_contract_type") }}
                            </option>
                            <option value="rental">{{ $t("rental") }}</option>
                            <option value="installment">
                                {{ $t("installment") }}
                            </option>
                            <option value="purchase">
                                {{ $t("purchase") }}
                            </option>
                        </select>
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
            newSale: {
                id: "",
                model: "",
                price: null, // Use null to allow it to be treated as a number
                discount: "",
                date: "",
                duration: "",
                warranty: "",
                seller: "",
                contract_type: "",
            },
        };
    },
    created() {
        const saleId = this.$route.params.id; // Get the sale ID from the route
        if (saleId) {
            this.fetchSaleData(saleId); // Fetch sale data if ID exists
        } else {
            console.error("No sale ID found in route");
        }
    },
    methods: {
        goBack() {
            this.$router.go(-1);
        },

        async fetchSaleData(saleId) {
            try {
                const response = await axios.get(
                    `http://127.0.0.1:8000/api/sales/${saleId}`
                );
                const saleData = response.data;

                // Ensure price is treated as a number
                this.newSale = {
                    id: saleData.id,
                    model: saleData.model,
                    price: parseFloat(saleData.price), // Convert to float for decimal
                    discount: saleData.discount.replace("%", ""),
                    date: saleData.date,
                    duration: saleData.duration,
                    warranty: saleData.warranty,
                    seller: saleData.seller,
                    contract_type: saleData.contract_type,
                };
            } catch (error) {
                console.error("Fetch Error:", error);
                Swal.fire({
                    icon: "error",
                    title: this.$t("error"),
                    text: this.$t("failed_to_fetch_sale_data"),
                });
            }
        },

        editSale() {
            if (Object.values(this.newSale).includes("") || !this.newSale.id) {
                Swal.fire({
                    icon: "error",
                    title: this.$t("error"),
                    text: this.$t("please_fill_in_all_fields"),
                });
                return;
            }

            // Ensure discount includes '%' before submission
            if (this.newSale.discount) {
                this.newSale.discount = `${this.newSale.discount}%`;
            }

            // Ensure price is numeric
            if (isNaN(this.newSale.price)) {
                Swal.fire({
                    icon: "error",
                    title: this.$t("error"),
                    title: this.$t("error"),
                    text: this.$t("invalid_price"),
                });
                return;
            }

            axios
                .put(
                    `http://127.0.0.1:8000/api/sales/${this.newSale.id}`,
                    this.newSale
                )
                .then(() => {
                    toast.fire({
                        icon: "success",
                        title: this.$t("sale_updated"),
                    });
                    this.$router.go(-1);
                })
                .catch((error) => {
                    console.error(error.response?.data);
                    Swal.fire({
                        icon: "error",
                        title: this.$t("error"),
                        text:
                            error.response?.data.message ||
                            this.$t("failed_to_update_sale"),
                    });
                });
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

.input-field input {
    padding: 10px 15px;
    font-size: 1rem;
    border-radius: 8px;
    border: solid 1px #8d8d8d;
    width: 100%;
}
.input-field select {
    padding: 10px 15px;
    font-size: 1rem;
    border-radius: 8px;
    border: solid 1px #8d8d8d;
    width: 100%;
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
.btn-container {
    width: 100%;
    display: flex;
    gap: 20px;
}

.btn {
    width: 200px;
    text-align: center;
}
</style>
