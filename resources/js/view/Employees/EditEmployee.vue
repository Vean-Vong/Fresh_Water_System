<template>
    <div class="container">
        <div class="heading">{{ $t("edit_employee") }}</div>
        <form class="form" @submit.prevent="updateEmployee">
            <div class="form-row">
                <!-- Left Column -->
                <div class="form-column">
                    <div class="input-field">
                        <label class="form-label">{{
                            $t("employee_name")
                        }}</label>
                        <input
                            class="form-control"
                            required
                            type="text"
                            v-model="editedEmployee.name"
                            :placeholder="$t('employee_name')"
                        />
                    </div>

                    <div class="input-field">
                        <label class="form-label">{{
                            $t("select_gender")
                        }}</label>
                        <select
                            v-model="editedEmployee.gender"
                            class="form-select"
                        >
                            <option value="" disabled>
                                {{ $t("select_gender") }}
                            </option>
                            <option value="Male">Male (ប្រុស)</option>
                            <option value="Female">Female (ស្រី)</option>
                            <option value="Other">Other (ផ្សេងៗ)</option>
                        </select>
                    </div>

                    <div class="input-field">
                        <label class="form-label">{{ $t("position") }}</label>
                        <input
                            class="form-control"
                            required
                            type="text"
                            v-model="editedEmployee.position"
                            :placeholder="$t('position')"
                        />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{
                            $t("date_of_birth")
                        }}</label>
                        <input
                            type="date"
                            class="form-control"
                            v-model="editedEmployee.date_of_birth"
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
                            type="text"
                            v-model="editedEmployee.phone"
                            :placeholder="$t('phone')"
                        />
                    </div>
                    <div class="input-field">
                        <label class="form-label">{{ $t("address") }}</label>
                        <input
                            class="form-control"
                            required
                            type="text"
                            v-model="editedEmployee.address"
                            :placeholder="$t('address')"
                        />
                    </div>
                    <div class="input-field">
                        <label class="form-label">{{ $t("email") }}</label>
                        <input
                            class="form-control"
                            required
                            type="email"
                            v-model="editedEmployee.email"
                            :placeholder="$t('email')"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ $t("hire_date") }}</label>
                        <input
                            type="date"
                            class="form-control"
                            v-model="editedEmployee.hire_date"
                            required
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
            editedEmployee: {
                name: "",
                gender: "",
                position: "",
                date_of_birth: "",
                phone: "",
                address: "",
                email: "",
                hire_date: "",
            },
        };
    },
    created() {
        this.fetchEmployee();
    },
    methods: {
        async fetchEmployee() {
            try {
                const employeeId = this.$route.params.id;
                if (!employeeId) {
                    console.error("No employee ID found in route");
                    return;
                }

                const response = await axios.get(
                    `http://127.0.0.1:8000/api/employees/${employeeId}`
                );

                if (response.data) {
                    console.log("Fetched Employee Data:", response.data);

                    // Ensure data is assigned correctly
                    this.editedEmployee = { ...response.data };

                    // Ensure date fields are formatted correctly
                    if (this.editedEmployee.date_of_birth) {
                        this.editedEmployee.date_of_birth =
                            this.editedEmployee.date_of_birth.split("T")[0];
                    }
                    if (this.editedEmployee.hire_date) {
                        this.editedEmployee.hire_date =
                            this.editedEmployee.hire_date.split("T")[0];
                    }
                } else {
                    console.error("No data received from API");
                }
            } catch (error) {
                console.error("Error fetching employee data:", error);
                Swal.fire("Error!", "Failed to load employee data.", "error");
            }
        },

        async updateEmployee() {
            try {
                await axios.put(
                    `http://127.0.0.1:8000/api/employees/${this.editedEmployee.id}`,
                    this.editedEmployee
                );
                toast.fire({
                    icon: "success",
                    title: this.$t("employee_updated"),
                });
                this.$router.go(-1);
            } catch (error) {
                console.error("Update Error:", error);
                Swal.fire("Error!", "Failed to update employee.", "error");
            }
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
