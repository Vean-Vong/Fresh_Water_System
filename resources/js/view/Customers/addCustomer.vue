<template>
    <div class="container">
        <div class="heading">{{ $t("new_customer") }}</div>
        <form class="form" @submit.prevent="addCustomer">
            <div class="form-row">
                <!-- Left Column -->
                <div class="form-column">
                    <div class="input-field">
                        <input
                            class="form-control"
                            required
                            autocomplete="off"
                            type="text"
                            v-model="newCustomer.name"
                            :placeholder="$t('customer_name')"
                        />
                    </div>

                    <div class="input-field">
                        <!-- <label for="job">{{ $t("job") }}</label> -->
                        <select
                            id="job"
                            class="form-select"
                            v-model="newCustomer.job"
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
                            v-model="newCustomer.date"
                            required
                        />
                    </div>
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <div class="input-field">
                        <input
                            class="form-control"
                            required
                            autocomplete="off"
                            type="text"
                            v-model="newCustomer.phone"
                            :placeholder="$t('phone')"
                        />
                    </div>
                    <div class="input-field">
                        <!-- <label for="address">{{ $t("address") }}</label> -->
                        <select
                            id="address"
                            class="form-select"
                            v-model="newCustomer.address"
                            required
                        >
                            <option disabled value="">
                                {{ $t("address") }}
                            </option>
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
<script>
import axios from "axios";
export default {
    data() {
        return {
            showAddDialog: false,
            newCustomer: {
                name: "",
                address: "",
                phone: "",
                date: "",
                job: "",
            },
            customers: [],
        };
    },
    methods: {
        goBack() {
            this.$router.go(-1);
        },
        addCustomer() {
            // Validate required fields
            if (
                !this.newCustomer.name ||
                !this.newCustomer.address ||
                !this.newCustomer.phone ||
                !this.newCustomer.date ||
                !this.newCustomer.job
            ) {
                Swal.fire({
                    icon: "error",
                    title: "Please fill in all required fields.",
                });
                return;
            }
            axios
                .post("http://127.0.0.1:8000/api/customers", this.newCustomer)
                .then(() => {
                    toast.fire({
                        icon: "success",
                        title: this.$t("customer_added"),
                    });
                    this.$router.go(-1);
                })
                .catch((error) => {
                    console.error(error);
                    Swal.fire({
                        icon: "error",
                        title: this.$t("error"),
                        text: this.$t("failed_to_add_customer"),
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
