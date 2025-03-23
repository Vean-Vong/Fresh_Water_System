<template>
    <div class="container">
        <div class="heading">{{ $t("new_employee") }}</div>
        <form class="form" @submit.prevent="addEmployee">
            <div class="form-row">
                <!-- Left Column -->
                <div class="form-column">
                    <div class="input-field">
                        <input
                            class="form-control"
                            required
                            autocomplete="off"
                            type="text"
                            v-model="newEmployee.name"
                            :placeholder="$t('employee_name')"
                        />
                    </div>

                    <select
                        v-model="newEmployee.gender"
                        class="form-select"
                        aria-label="Default select example"
                    >
                        <option value="" disabled selected>
                            {{ $t("select_gender") }}
                        </option>
                        <option value="Male">Male (ប្រុស)</option>
                        <option value="Female">Female (ស្រី)</option>
                        <option value="Other">Other (ផ្សេងៗ)</option>
                    </select>

                    <div class="input-field">
                        <input
                            class="form-control"
                            required
                            autocomplete="off"
                            type="text"
                            v-model="newEmployee.position"
                            :placeholder="$t('position')"
                        />
                    </div>

                    <div class="mb-3">
                        <label for="dob" class="form-label">{{
                            $t("date_of_birth")
                        }}</label>
                        <input
                            type="date"
                            class="form-control"
                            id="dob"
                            v-model="newEmployee.date_of_birth"
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
                            v-model="newEmployee.phone"
                            :placeholder="$t('phone')"
                        />
                        <!-- <label for="phone">{{ $t("phone") }}</label> -->
                    </div>
                    <div class="input-field">
                        <input
                            class="form-control"
                            required
                            autocomplete="off"
                            type="text"
                            v-model="newEmployee.address"
                            :placeholder="$t('address')"
                        />
                        <!-- <label for="address">{{ $t("address") }}</label> -->
                    </div>
                    <div class="input-field">
                        <input
                            class="form-control"
                            required
                            autocomplete="off"
                            type="email"
                            v-model="newEmployee.email"
                            :placeholder="$t('email')"
                        />
                        <!-- <label for="email">{{ $t("email") }}</label> -->
                    </div>
                    <div class="mb-3">
                        <label for="hire-date" class="form-label">{{
                            $t("hire_date")
                        }}</label>
                        <input
                            type="date"
                            class="form-control"
                            id="hire-date"
                            v-model="newEmployee.hire_date"
                            required
                        />
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
            newEmployee: {
                name: "",
                gender: "",
                position: "",
                email: "",
                phone: "",
                date_of_birth: "",
                hire_date: "",
                address: "",
            },
            employees: [], // Store fetched employees
        };
    },
    methods: {
        goBack() {
            this.$router.go(-1);
        },
        addEmployee() {
            // Ensure date_of_birth and hire_date are formatted correctly
            if (this.newEmployee.date_of_birth) {
                this.newEmployee.date_of_birth = new Date(
                    this.newEmployee.date_of_birth
                )
                    .toISOString()
                    .split("T")[0];
            }
            if (this.newEmployee.hire_date) {
                this.newEmployee.hire_date = new Date(
                    this.newEmployee.hire_date
                )
                    .toISOString()
                    .split("T")[0];
            }

            // Validate required fields
            if (
                !this.newEmployee.name ||
                !this.newEmployee.email ||
                !this.newEmployee.position ||
                !this.newEmployee.phone ||
                !this.newEmployee.date_of_birth ||
                !this.newEmployee.hire_date ||
                !this.newEmployee.address ||
                !this.newEmployee.gender
            ) {
                Swal.fire({
                    icon: "error",
                    title: "Please fill in all required fields.",
                });
                return;
            }

            // Send data to the backend
            axios
                .post("http://127.0.0.1:8000/api/employees", this.newEmployee)
                .then((response) => {
                    console.log("Success response:", response);

                    // Ensure response is successful
                    if (response.status === 200 || response.status === 201) {
                        toast.fire({
                            icon: "success",
                            title: this.$t("employee_added_success"),
                        });
                        this.$router.go(-1);
                    }
                })
                .catch((error) => {
                    console.error(error);
                    Swal.fire({
                        icon: "error",
                        title: this.$t("error"),
                        text: this.$t("failed_to_add_employee"),
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
