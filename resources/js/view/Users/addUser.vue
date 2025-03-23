<template>
    <div class="container">
        <div class="heading">{{ $t("new_user") }}</div>
        <form class="form" @submit.prevent="addUser">
            <div class="form-row">
                <!-- Left Column -->
                <div class="form-column">
                    <!-- Username -->
                    <div class="input-field">
                        <input
                            class="form-control"
                            required
                            autocomplete="off"
                            type="text"
                            v-model="newUser.username"
                            :placeholder="$t('username')"
                        />
                    </div>

                    <!-- Phone -->
                    <div class="input-field">
                        <input
                            class="form-control"
                            required
                            autocomplete="off"
                            type="text"
                            v-model="newUser.phone"
                            :placeholder="$t('phone')"
                        />
                    </div>

                    <!-- Email -->
                    <div class="input-field">
                        <input
                            class="form-control"
                            required
                            autocomplete="off"
                            type="email"
                            v-model="newUser.email"
                            :placeholder="$t('email')"
                        />
                    </div>
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <!-- Gender Dropdown -->
                    <div class="input-field">
                        <!-- <label for="gender">{{ $t("gender") }}</label> -->
                        <select
                            id="gender"
                            class="form-select"
                            required
                            v-model="newUser.gender"
                        >
                            <option disabled value="">
                                {{ $t("gender") }}
                            </option>
                            <option value="Male">Male (ប្រុស)</option>
                            <option value="Female">Female (ស្រី)</option>
                            <option value="Other">Other (ផ្សេងៗ)</option>
                        </select>
                    </div>

                    <!-- Address Dropdown -->
                    <div class="input-field">
                        <!-- <label for="address">{{ $t("address") }}</label> -->
                        <select
                            id="address"
                            class="form-select"
                            required
                            v-model="newUser.address"
                        >
                            <option disabled value="">
                                {{ $t("address") }}
                            </option>
                            <option value="battambang">
                                {{ $t("Battambang") }}
                            </option>
                            <option value="kampong_thom">
                                {{ $t("Kampong Thom") }}
                            </option>
                            <option value="pursat">{{ $t("Pursat") }}</option>
                            <option value="phnom_penh">
                                {{ $t("Phnom Penh") }}
                            </option>
                            <option value="banteay_meanchey">
                                {{ $t("Banteay Meanchey") }}
                            </option>
                            <option value="oddar_meanchey">
                                {{ $t("Oddar Meanchey") }}
                            </option>
                            <option value="siem_reap">
                                {{ $t("Siem Reap") }}
                            </option>
                            <option value="ratanakiri">
                                {{ $t("Ratanakiri") }}
                            </option>
                            <option value="kampong_cham">
                                {{ $t("Kampong Cham") }}
                            </option>
                            <option value="koh_kong">
                                {{ $t("Koh Kong") }}
                            </option>
                        </select>
                    </div>

                    <!-- Password Input -->
                    <div class="input-field">
                        <input
                            class="form-control"
                            required
                            autocomplete="off"
                            type="password"
                            v-model="newUser.password"
                            :placeholder="$t('password')"
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
import Swal from "sweetalert2";

export default {
    data() {
        return {
            newUser: {
                username: "",
                gender: "",
                phone: "",
                address: "",
                email: "",
                password: "",
            },
            isLoading: false, // Loading state
        };
    },
    methods: {
        goBack() {
            this.$router.go(-1);
        },
        addUser() {
            if (
                !this.newUser.username ||
                !this.newUser.gender ||
                !this.newUser.phone ||
                !this.newUser.address ||
                !this.newUser.email ||
                !this.newUser.password
            ) {
                Swal.fire({
                    icon: "error",
                    title: this.$t("error"),
                    text: this.$t("please_fill_in_all_fields"),
                });
                return;
            }

            this.isLoading = true; // Set loading to true
            // Send data to the backend
            axios
                .post("http://127.0.0.1:8000/api/auth/register", this.newUser)
                .then((response) => {
                    console.log("Success response:", response);

                    if (response.status === 200 || response.status === 201) {
                        toast.success(this.$t("user_added"));
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
                            this.$t("failed_to_add_user"),
                    });
                })
                .finally(() => {
                    this.isLoading = false; // Reset loading state
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
    padding-top: 20px;
}

.btn {
    width: 200px;
    text-align: center;
}
</style>
