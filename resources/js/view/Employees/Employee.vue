<template>
    <div class="container">
        <div class="addemployee">
            <!-- <h2>{{ $t("employee_list") }}</h2> -->
            <router-link to="/addEmployee">
                <button class="btnAdd text-white">
                    <div class="addBtn">
                        <i class="fas fa-plus"></i> {{ $t("new_employee") }}
                    </div>
                </button></router-link
            >

            <div class="input-group" style="width: 500px">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Search here..."
                    v-model="searchQuery"
                />
                <button class="btnSearch" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th class="table-title text-white">ID</th>
                    <th class="table-title text-white">
                        {{ $t("employee_name") }}
                    </th>
                    <th class="table-title text-white">{{ $t("gender") }}</th>
                    <th class="table-title text-white">{{ $t("position") }}</th>
                    <th class="table-title text-white">{{ $t("email") }}</th>
                    <th class="table-title text-white">{{ $t("phone") }}</th>
                    <th class="table-title text-white">{{ $t("address") }}</th>
                    <th class="table-title text-white">
                        {{ $t("date_of_birth") }}
                    </th>
                    <th class="table-title text-white">
                        {{ $t("hire_date") }}
                    </th>
                    <th class="table-title text-white">{{ $t("action") }}</th>
                </tr>
            </thead>
            <tbody>
                <div v-if="loading" class="center-loader-container">
                    <div class="loader"></div>
                </div>
                <tr v-else-if="employees.length === 0">
                    <td colspan="12" class="text-center">
                        {{ $t("no_employee_available") }}
                    </td>
                </tr>
                <tr v-for="employee in employees" :key="employee.id">
                    <td>{{ employee.id }}</td>
                    <td>{{ employee.name }}</td>
                    <td>{{ employee.gender }}</td>
                    <td>{{ employee.position }}</td>
                    <td>{{ employee.email }}</td>
                    <td>{{ employee.phone }}</td>
                    <td>{{ employee.address }}</td>
                    <td>{{ formatDate(employee.date_of_birth) }}</td>
                    <td>{{ formatDate(employee.hire_date) }}</td>
                    <td>
                        <button
                            class="btn btn-sm btn-info btn-view"
                            @click="openViewDialog(employee)"
                        >
                            <i class="fas fa-print"></i>
                        </button>
                        <router-link :to="`/EditEmployee/${employee.id}`">
                            <button class="btn btn-sm btn-warning btn-edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </router-link>

                        <button
                            class="btn btn-sm btn-danger btn-delete"
                            @click="deleteEmployee(employee.id)"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- View Employee Dialog -->
        <div v-if="showViewDialog" class="modal show">
            <div class="modal-content">
                <h3 class="title">{{ $t("view_employee") }}</h3>

                <p>
                    <strong>{{ $t("employee_name") }}:</strong>
                    {{ viewEmployee.name }}
                </p>
                <p>
                    <strong>{{ $t("gender") }}:</strong>
                    {{ viewEmployee.gender }}
                </p>
                <p>
                    <strong>{{ $t("position") }}:</strong>
                    {{ viewEmployee.position }}
                </p>
                <p>
                    <strong>{{ $t("email") }}:</strong> {{ viewEmployee.email }}
                </p>
                <p>
                    <strong>{{ $t("phone") }}:</strong> {{ viewEmployee.phone }}
                </p>
                <p>
                    <strong>{{ $t("date_of_birth") }}:</strong>
                    {{ formatDate(viewEmployee.date_of_birth) }}
                </p>
                <p>
                    <strong>{{ $t("hire_date") }}:</strong>
                    {{ formatDate(viewEmployee.hire_date) }}
                </p>
                <p>
                    <strong>{{ $t("address") }}:</strong>
                    {{ viewEmployee.address }}
                </p>

                <div class="modal-actions">
                    <button class="btn btn-secondary" @click="closeViewDialog">
                        {{ $t("cancel") }}
                    </button>
                    <!-- Print Button -->
                    <button
                        class="btn btn-primary"
                        @click="printEmployeeDetails"
                    >
                        <i class="fas fa-print"></i> {{ $t("print") }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

// Ensure baseURL is set to match your API
axios.defaults.baseURL = "http://127.0.0.1:8000/api";

export default {
    data() {
        return {
            searchQuery: "",
            employees: [],
            loading: true,
            showAddDialog: false,
            showEditDialog: false,
            showViewDialog: false,

        };
    },
    computed: {
        employees() {
            return this.employees.filter((employee) => {
                return employee.name
                    .toLowerCase()
                    .includes(this.searchQuery.toLowerCase());
            });
        },
    },
    methods: {

        async fetchEmployees() {
            this.loading = true;
            try {
                const response = await axios.get("/employees"); // Adjust API endpoint
                this.employees = response.data;
            } catch (error) {
                console.error("Error fetching employees:", error);
            } finally {
                this.loading = false; // Stop loading after data is fetched
            }
        },


        deleteEmployee(employeeId) {
            Swal.fire({
                title: this.$t("are_you_sure"),
                text: this.$t("once_delete_employee"),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: this.$t("Yes_delete_it"),
                cancelButtonText: this.$t("cancel"),
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`/employees/${employeeId}`)
                        .then(() => {
                            this.fetchEmployees();
                            Swal.fire(
                                this.$t("Deleted"),
                                this.$t("employee_deleted"),
                                "success"
                            );
                        })

                        .catch((error) => {
                            console.error(error);
                            Swal.fire(
                                "Error!",
                                "Failed to delete employee.",
                                "error"
                            );
                        });
                }
            });
        },

        printEmployeeDetails() {
            window.print();
            printWindow.document.close();
            printWindow.print();
        },
        openViewDialog(employee) {
            this.viewEmployee = { ...employee };
            this.showViewDialog = true;
        },

        closeViewDialog() {
            this.showViewDialog = false;
        },

        formatDate(date) {
            if (!date) return "";
            const options = { year: "numeric", month: "long", day: "numeric" };
            return new Date(date).toLocaleDateString("en-US", options);
        },
    },

    mounted() {
        this.fetchEmployees();
    },
    created() {
        this.fetchEmployees(); // Fetch data when component is created
    },
};
</script>

<style scoped>
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
.addemployee {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
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
.modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: none; /* Hidden by default */
    background: rgba(0, 0, 0, 0.5); /* Background overlay */
    align-items: center;
    justify-content: center;
}
.modal-actions {
    display: flex;
    justify-content: space-between;
    padding: 10px;
}
.modal.show {
    display: flex;
}

.modal-content {
    /* background: white; */
    padding: 20px;
    border-radius: 10px;
    width: 400px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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
</style>
