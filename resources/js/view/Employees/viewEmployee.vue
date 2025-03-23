<template>
    <div class="container">
        <h3 class="title">{{ $t("view_employee") }}</h3>

        <div v-if="loading" class="text-center">
            <p>{{ $t("loading") }}...</p>
        </div>

        <div v-else-if="viewEmployee">
            <p>
                <strong>{{ $t("employee_name") }}:</strong>
                {{ viewEmployee.name }}
            </p>
            <p>
                <strong>{{ $t("gender") }}:</strong> {{ viewEmployee.gender }}
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
                <strong>{{ $t("address") }}:</strong> {{ viewEmployee.address }}
            </p>

            <div class="btn">
                <router-link to="/employees" @click="goBack">
                    <button class="btn btn-secondary">
                        {{ $t("cancel") }}
                    </button>
                </router-link>
                <button class="btn btn-primary" @click="printEmployeeDetails">
                    <i class="fas fa-print"></i> {{ $t("print") }}
                </button>
            </div>
        </div>

        <div v-else class="text-center">
            <p class="text-danger">{{ $t("employee_not_found") }}</p>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            loading: false,
            viewEmployee: null,
        };
    },
    async created() {
        const employeeId = this.$route.params.id;
        if (employeeId) {
            await this.fetchEmployeeDetails(employeeId);
        }
    },
    methods: {
        goBack() {
            this.$router.go(-1);
        },
        async fetchEmployeeDetails(id) {
            this.loading = true;
            try {
                const response = await axios.get(`/employees/${id}`);
                this.viewEmployee = response.data;
            } catch (error) {
                console.error("Error fetching employee:", error);
                this.viewEmployee = null;
            } finally {
                this.loading = false;
            }
        },

        printEmployeeDetails() {
            window.print();
            printWindow.document.close();
            printWindow.print();
        },

        formatDate(date) {
            if (!date) return "-";
            return new Intl.DateTimeFormat("en-US", {
                year: "numeric",
                month: "long",
                day: "2-digit",
            }).format(new Date(date));
        },
    },
};
</script>

<style scoped>
.container {
    max-width: 600px;
    margin: auto;
    padding: 20px;
    margin-left: 100px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}
.title {
    text-align: center;
    font-weight: bold;
    margin-bottom: 20px;
}
p{
    font-size: 20px;
}
.btn-primary{
    margin-left: 50px;
}
</style>
