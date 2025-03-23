<template>
    <div class="container">
        <div class="heading">{{ $t("new_sale") }}</div>
        <form class="form" @submit.prevent="addSale">
            <div class="form-row">
                <!-- Left Column -->
                <div class="form-column">
                    <!-- Model Dropdown -->
                    <div class="input-field">
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
                        <select
                            class="form-select"
                            required
                            v-model="newSale.discount"
                            :placeholder="$t('discount')"
                        >
                            <option disabled value="">
                                {{ $t("discount") }}
                            </option>
                            <option value="0">{{ $t("0") }}%</option>
                            <option value="10">{{ $t("10") }}%</option>
                            <option value="20">{{ $t("20") }}%</option>
                        </select>

                    </div>

                    <!-- Date Input -->
                    <div class="mb-3">
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
                        <select
                            class="form-select"
                            required
                            v-model="newSale.duration"
                            :placeholder="$t('duration')"
                        >
                            <option disabled value="">
                                {{ $t("duration") }}
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
                        <select
                            class="form-select"
                            required
                            v-model="newSale.warranty"
                            :placeholder="$t('warranty')"
                        >
                            <option disabled value="">
                                {{ $t("warranty") }}
                            </option>
                            <option value="Free monthly maintenance">
                                {{ $t("Free monthly maintenance") }}
                            </option>
                        </select>

                    </div>

                    <!-- Seller Input -->
                    <div class="input-field">
                        <input
                            class="form-control"
                            required
                            autocomplete="off"
                            type="text"
                            v-model="newSale.seller"
                            :placeholder="$t('seller')"
                        />
                    </div>

                    <!-- Contract Type Dropdown -->
                    <div class="input-field">
                        <select
                            class="form-select"
                            required
                            v-model="newSale.contract_type"
                            :placeholder="$t('contract_type')"
                        >
                            <option disabled value="">
                                {{ $t("contract") }}
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

.input-field label {
    position: absolute;
    color: #8d8d8d;
    left: 15px;
    transform: translateY(0.6rem);
    transition: all 0.3s ease;
}

.input-field input,
.input-field select {
    padding: 10px 15px;
    font-size: 1rem;
    border-radius: 8px;
    border: solid 1px #8d8d8d;
    width: 100%;
}



.arrow-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 16px;
    color: #010921;
    pointer-events: none;
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

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
    data() {
        return {
            newSale: {
                model: "",
                price: "",
                discount: "",
                date: "",
                duration: "",
                warranty: "",
                seller: "",
                contract_type: "",
            },
        };
    },
    methods: {
        goBack() {
            this.$router.go(-1);
        },
        addSale() {
            // Validate required fields
            if (
                !this.newSale.model ||
                !this.newSale.price ||
                !this.newSale.discount ||
                !this.newSale.date ||
                !this.newSale.duration ||
                !this.newSale.warranty ||
                !this.newSale.seller ||
                !this.newSale.contract_type
            ) {
                Swal.fire({
                    icon: "error",
                    title: this.$t("error"),
                    text: this.$t("please_fill_in_all_fields"),
                });
                return;
            }

            // Convert date to ISO format (if not already in that format)
            if (this.newSale.date) {
                this.newSale.date = new Date(this.newSale.date)
                    .toISOString()
                    .split("T")[0]; // Ensuring YYYY-MM-DD format
            }
            // Handle the discount value (add % symbol to display)
            if (this.newSale.discount) {
                this.newSale.discount = `${this.newSale.discount}%`;
            }
            // Send data to the backend
            axios
                .post("http://127.0.0.1:8000/api/sales", this.newSale)
                .then((response) => {
                    console.log("Success response:", response);

                    if (response.status === 200 || response.status === 201) {
                        toast.fire({
                            icon: "success",
                            title: this.$t("sale_added"),
                        });
                        this.$router.go(-1); // Go back after success
                    }
                })
                .catch((error) => {
                    console.error(error.response.data); // Check the error message returned from the backend
                    Swal.fire({
                        icon: "error",
                        title: this.$t("error"),
                        text:
                            error.response.data.message ||
                            this.$t("failed_to_add_sale"),
                    });
                });
        },
    },
};
</script>
