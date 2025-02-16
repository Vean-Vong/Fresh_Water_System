<template>
    <div class="container">
        <div class="addemployee ">
            <h2>Employee List</h2>
            <button class="btn btn-primary" @click="openAddDialog">
                <i class="fas fa-plus"></i> New employee
            </button>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Date_Of_Birth</th>
                    <th>Hire_Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="employee in employees" :key="employee.id">
                    <td>{{ employee.id }}</td>
                    <td>{{ employee.name }}</td>
                    <td>{{ employee.gender }}</td>
                    <td>{{ employee.department }}</td>
                    <td>{{ employee.position }}</td>
                    <td>{{ employee.email }}</td>
                    <td>{{ employee.phone }}</td>
                    <td>{{ employee.address }}</td>
                    <td>{{ formatDate(employee.date_of_birth) }}</td>
                    <td>{{ formatDate(employee.hire_date) }}</td>
                    <td>{{ employee.status }}</td>
                    <td>
                        <button
                            class="btn btn-sm btn-info btn-view"
                            @click="openViewDialog(employee)"
                        >
                            <i class="fas fa-print"></i>
                        </button>
                        <button
                            class="btn btn-sm btn-warning btn-edit"
                            @click="openEditDialog(employee)"
                        >
                            <i class="fas fa-edit"></i>
                        </button>
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

        <!-- Add Employee Dialog -->
        <div v-if="showAddDialog" class="modal show">
            <div class="modal-content">
                <h3 class="title">Add Employee</h3>

                <label>Name:</label>
                <input type="text" v-model="newEmployee.name" />

                <label>Gender:</label>
                <select v-model="newEmployee.gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>

                <label>Department:</label>
                <input type="text" v-model="newEmployee.department" />

                <label>Position:</label>
                <input type="text" v-model="newEmployee.position" />

                <label>Email:</label>
                <input type="email" v-model="newEmployee.email" />

                <label>Phone:</label>
                <input type="text" v-model="newEmployee.phone" />

                <label>Date of Birth:</label>
                <div class="date-of-birth">
                    <select v-model="newEmployee.day_of_birth">
                        <option v-for="day in days" :value="day" :key="day">{{ day }}</option>
                    </select>

                    <select v-model="newEmployee.month_of_birth">
                        <option v-for="month in months" :value="month" :key="month">{{ month }}</option>
                    </select>

                    <select v-model="newEmployee.year_of_birth">
                        <option v-for="year in years" :value="year" :key="year">{{ year }}</option>
                    </select>
                </div>
                <label>Hire Date:</label>
                <input type="text" v-model="newEmployee.hire_date" />

                <label>Address:</label>
                <input type="text" v-model="newEmployee.address" />

                <label>Status:</label>
                <select v-model="newEmployee.status">
                    <option value="true">Active</option>
                    <option value="false">Inactive</option>
                </select>

                <div class="modal-actions ">
                    <button class="btn btn-success" @click="addEmployee">
                        Save
                    </button>
                    <button class="btn btn-secondary" @click="closeAddDialog">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
        <!-- Edit Employee Dialog -->
        <div v-if="showEditDialog" class="modal show">
            <div class="modal-content">
                <h3 class="title">Edit Employee</h3>

                <label>Name:</label>
                <input type="text" v-model="editedEmployee.name" />

                <label>Gender:</label>
                <select v-model="editedEmployee.gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>

                <label>Department:</label>
                <input type="text" v-model="editedEmployee.department" />

                <label>Position:</label>
                <input type="text" v-model="editedEmployee.position" />

                <label>Email:</label>
                <input type="email" v-model="editedEmployee.email" />

                <label>Phone:</label>
                <input type="text" v-model="editedEmployee.phone" />

                <label>Date of Birth:</label>
                <input type="text" v-model="editedEmployee.date_of_birth" />

                <label>Hire Date:</label>
                <input type="text" v-model="editedEmployee.hire_date" />

                <label>Address:</label>
                <input type="text" v-model="editedEmployee.address" />

                <label>Status:</label>
                <select v-model="editedEmployee.status">
                    <option :value="true">Active</option>
                    <option :value="false">Inactive</option>
                </select>

                <div class="modal-actions">
                    <button class="btn btn-success" @click="updateEmployee">
                        Save
                    </button>
                    <button class="btn btn-secondary" @click="closeEditDialog">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- View Employee Dialog -->
        <div v-if="showViewDialog" class="modal show">
            <div class="modal-content">
                <h3 class="title">View Employee</h3>

                <p><strong>Name:</strong> {{ viewEmployee.name }}</p>
                <p><strong>Gender:</strong> {{ viewEmployee.gender }}</p>
                <p>
                    <strong>Department:</strong> {{ viewEmployee.department }}
                </p>
                <p><strong>Position:</strong> {{ viewEmployee.position }}</p>
                <p><strong>Email:</strong> {{ viewEmployee.email }}</p>
                <p><strong>Phone:</strong> {{ viewEmployee.phone }}</p>
                <p>
                    <strong>Date of Birth:</strong>
                    {{ formatDate(viewEmployee.date_of_birth) }}
                </p>
                <p>
                    <strong>Hire Date:</strong>
                    {{ formatDate(viewEmployee.hire_date) }}
                </p>
                <p><strong>Address:</strong> {{ viewEmployee.address }}</p>
                <p>
                    <strong>Status:</strong>
                    {{ viewEmployee.status ? "Active" : "Inactive" }}
                </p>

                <div class="modal-actions">
                    <button class="btn btn-secondary" @click="closeViewDialog">
                        Close
                    </button>
                    <!-- Print Button -->
                    <button class="btn btn-info" @click="printEmployeeDetails">
                        <i class="fas fa-print"></i> Print
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
            employees: [],
            showAddDialog: false,
            showEditDialog: false,
            showViewDialog: false,
            newEmployee: {
                name: "",
                gender: "Male",
                department: "",
                position: "",
                email: "",
                phone: "",
                date_of_birth: "",
                hire_date: "",
                address: "",
                status: true,
            },
            days: Array.from({ length: 31 }, (_, i) => i + 1),
        months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        years: Array.from({ length: 100 }, (_, i) => 1920 + i),
            editedEmployee: {},
            viewEmployee: {},

        };
    },

    methods: {
        openAddDialog() {
            this.newEmployee = {
                name: "",
                gender: "Male",
                department: "",
                position: "",
                email: "",
                phone: "",
                date_of_birth: "",
                hire_date: "",
                address: "",
                status: true,
            };
            this.showAddDialog = true;
        },

        addEmployee() {
            this.newEmployee.date_of_birth = `${this.newEmployee.year_of_birth}-${this.months.indexOf(this.newEmployee.month_of_birth) + 1}-${this.newEmployee.day_of_birth}`;
            if (!this.newEmployee.name || !this.newEmployee.email) {
                Swal.fire(
                    "Error",
                    "Please fill in all required fields.",
                    "error"
                );
                return;
            }

            axios
                .post("/employees", this.newEmployee)
                .then(() => {
                    this.showAddDialog = false;
                    this.fetchEmployees();
                    Swal.fire(
                        "Added!",
                        "New employee added successfully.",
                        "success"
                    );
                })
                .catch((error) => {
                    console.error(error);
                    Swal.fire("Error!", "Failed to add employee.", "error");
                });
        },

        fetchEmployees() {
            axios
                .get("/employees")
                .then((response) => {
                    this.employees = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        openEditDialog(employee) {
            this.editedEmployee = { ...employee };
            this.showEditDialog = true;
        },

        updateEmployee() {
            axios
                .put(
                    `/employees/${this.editedEmployee.id}`,
                    this.editedEmployee
                )
                .then(() => {
                    this.showEditDialog = false;
                    this.fetchEmployees();
                    Swal.fire(
                        "Updated!",
                        "Employee details updated.",
                        "success"
                    );
                })
                .catch((error) => {
                    console.error(error);
                    Swal.fire("Error!", "Failed to update employee.", "error");
                });
        },

        deleteEmployee(employeeId) {
            Swal.fire({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this employee!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`/employees/${employeeId}`)
                        .then(() => {
                            this.fetchEmployees();
                            Swal.fire(
                                "Deleted!",
                                "Employee has been deleted.",
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
        // Creating a new window for printing
        const printWindow = window.open('', '', 'height=600,width=800');

        // Add HTML content for the print preview
        printWindow.document.write('<html><head><title>Employee Details</title>');
        printWindow.document.write('<style>');
        printWindow.document.write('body { font-family: Arial, sans-serif; padding: 20px; }');
        printWindow.document.write('h3 { text-align: center; }');
        printWindow.document.write('p { margin: 5px 0; }');
        printWindow.document.write('strong { width: 150px; display: inline-block; }');
        printWindow.document.write('</style>');
        printWindow.document.write('</head><body>');

        // Add the employee details to the content
        printWindow.document.write('<h3>Employee Details</h3>');
        printWindow.document.write(`<p><strong>Name:</strong> ${this.viewEmployee.name}</p>`);
        printWindow.document.write(`<p><strong>Gender:</strong> ${this.viewEmployee.gender}</p>`);
        printWindow.document.write(`<p><strong>Department:</strong> ${this.viewEmployee.department}</p>`);
        printWindow.document.write(`<p><strong>Position:</strong> ${this.viewEmployee.position}</p>`);
        printWindow.document.write(`<p><strong>Email:</strong> ${this.viewEmployee.email}</p>`);
        printWindow.document.write(`<p><strong>Phone:</strong> ${this.viewEmployee.phone}</p>`);
        printWindow.document.write(`<p><strong>Date of Birth:</strong> ${this.formatDate(this.viewEmployee.date_of_birth)}</p>`);
        printWindow.document.write(`<p><strong>Hire Date:</strong> ${this.formatDate(this.viewEmployee.hire_date)}</p>`);
        printWindow.document.write(`<p><strong>Address:</strong> ${this.viewEmployee.address}</p>`);
        printWindow.document.write(`<p><strong>Status:</strong> ${this.viewEmployee.status ? 'Active' : 'Inactive'}</p>`);

        printWindow.document.write('</body></html>');

        // Make sure the document is fully loaded before triggering print
        printWindow.document.close();
        printWindow.print();
    },
        openViewDialog(employee) {
            this.viewEmployee = { ...employee };
            this.showViewDialog = true;
        },

        closeAddDialog() {
            this.showAddDialog = false;
        },

        closeEditDialog() {
            this.showEditDialog = false;
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
};
</script>

<style scoped>
.container {
    margin-left: -15px;

}
.addemployee{
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
}
.table th {
    background-color: #f2f2f2;

}
.alert {
    transition: opacity 0.8s ease-in-out;
}
/* Transparent background for buttons */

.btn-view{
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
    display: flex; /* Show the modal when "show" class is added */
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    width: 400px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
</style>
