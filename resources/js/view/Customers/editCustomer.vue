<template>
    <div class="container">
        <div class="heading">{{ $t("edit_customer") }}</div>
        <form class="form" @submit.prevent="updateCustomer">
            <div class="form-row">
                <!-- Left Column -->
                <div class="form-column">
                    <div class="input-field">
                        <label class="form-label">{{
                            $t("customer_name")
                        }}</label>

                        <input
                            class="form-control"
                            required
                            autocomplete="off"
                            type="text"
                            v-model="editedCustomer.name"
                            :placeholder="$t('customer_name')"
                        />
                    </div>

                    <div class="input-field">
                        <label for="job">{{ $t("job") }}</label>
                        <select
                            id="job"
                            class="form-select"
                            v-model="editedCustomer.job"
                            required
                        >
                            <option disabled value="">{{ $t("job") }}</option>
                            <option value="Teacher">{{ $t("Teacher") }}</option>
                            <option value="Doctor">{{ $t("Doctor") }}</option>
                            <option value="Engineer">
                                {{ $t("Engineer") }}
                            </option>
                            <option value="Business Owner">
                                {{ $t("Business Owner") }}
                            </option>
                            <option value="Student">{{ $t("Student") }}</option>
                            <option value="Farmer">{{ $t("Farmer") }}</option>
                            <option value="Other">{{ $t("Other") }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">{{
                            $t("date")
                        }}</label>
                        <input
                            type="date"
                            class="form-control"
                            id="dob"
                            v-model="editedCustomer.date"
                            required
                        />
                    </div>
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <div class="input-field">
                        <label class="form-label">{{ $t("phone") }}</label>

                        <input
                            class="form-control"
                            required
                            autocomplete="off"
                            type="text"
                            v-model="editedCustomer.phone"
                            :placeholder="$t('phone')"
                        />
                    </div>
                    <div class="input-field">
                        <label for="address">{{ $t("address") }}</label>
                        <select
                            id="address"
                            class="form-select"
                            v-model="editedCustomer.address"
                            required
                        >
                            <option value="Battambang">
                                {{ $t("Battambang") }}
                            </option>
                            <option value="Kampong Thom">
                                {{ $t("Kampong Thom") }}
                            </option>
                            <option value="Pursat">{{ $t("Pursat") }}</option>
                            <option value="Phnom Penh">
                                {{ $t("Phnom Penh") }}
                            </option>
                            <option value="banteay Meanchey">
                                {{ $t("Banteay Meanchey") }}
                            </option>
                            <option value="Oddar Meanchey">
                                {{ $t("Oddar Meanchey") }}
                            </option>
                            <option value="Siem Reap">
                                {{ $t("Siem Reap") }}
                            </option>
                            <option value="Ratanakiri">
                                {{ $t("Ratanakiri") }}
                            </option>
                            <option value="Kampong Cham">
                                {{ $t("Kampong Cham") }}
                            </option>
                            <option value="Koh Kong">
                                {{ $t("Koh Kong") }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="btn-container">
                <button
                    type="button"
                    class="btn bg-danger text-white text-center"
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
            editedCustomer: {
                id: null,
                name: "",
                address: "",
                phone: "",
                date: "",
                job: "",
            },
            errorMessage: "",
            isSubmitting: false, // Flag to disable the submit button
        };
    },
    created() {
        this.fetchCustomer();
    },
    methods: {
        async fetchCustomer() {
            try {
                const customerId = this.$route.params.id;
                console.log("Customer ID from route:", this.$route.params.id); // Add this line to debug

                if (!customerId) {
                    console.error("No customer ID found in route");
                    this.errorMessage = "Invalid customer ID.";
                    return;
                }

                const response = await axios.get(
                    `http://127.0.0.1:8000/api/customers/${customerId}` // Ensure the ID is appended correctly here
                );

                console.log("API Response:", response);

                if (response.data) {
                    this.editedCustomer = response.data; // Assuming the API directly returns the customer object

                    if (this.editedCustomer.date) {
                        this.editedCustomer.date =
                            this.editedCustomer.date.split("T")[0];
                    }
                } else {
                    console.error("No data received from API");
                    this.errorMessage = "No customer data found.";
                }
            } catch (error) {
                console.error("Fetch Error:", error);
                this.errorMessage = "Failed to fetch customer data.";
            }
        },
        async updateCustomer() {
            try {
                await axios.put(
                    `http://127.0.0.1:8000/api/customers/${this.editedCustomer.id}`,
                    this.editedCustomer
                );
                toast.fire({
                    icon: "success",
                    title: this.$t("customer_updated"),
                });
                this.$router.go(-1);
            } catch (error) {
                console.error("Update Error:", error);
                Swal.fire("Error!", "Failed to update customer.", "error");
            }
        },
        goBack() {
            this.$router.go(-1); // Go back to the previous page
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

.input-field input {
    padding: 10px 15px;
    font-size: 1rem;
    border-radius: 8px;
    border: solid 1px #8d8d8d;
    width: 100%;
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
