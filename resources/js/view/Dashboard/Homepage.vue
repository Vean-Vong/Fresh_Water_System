<template>
    <div class="row removable">
        <div class="col-sm-3 drop-zone">
            <div class="card text-white draggable">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title text-white opacity-9">
                                {{ $t("earning") }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i
                                    class="fas fa-dollar-sign"
                                    style="font-size: 40px"
                                ></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3 text-white">$ {{ SaleTotalPrice }}</h1>
                    <div class="mb-0">
                        <span class="text-success">
                            <i class="mdi mdi-arrow-bottom-right"></i> 6.65%
                        </span>
                        <span class="text-white opacity-8"
                            >Since last week</span
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-3 drop-zone">
            <div class="card text-white draggable">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title text-white opacity-9">
                                {{ $t("employee") }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i
                                    class="fas fa-user-tie"
                                    style="font-size: 40px"
                                ></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3 text-white">{{ employeeCount }}</h1>
                    <!-- Display Employee Count -->
                    <div class="mb-0">
                        <span class="text-success">
                            <i class="mdi mdi-arrow-bottom-right"></i>
                            {{ employeePercentageChange }}%
                        </span>
                        <span class="text-white opacity-8"
                            >Since last week</span
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-3 drop-zone">
            <div class="card text-white draggable">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title text-white opacity-9">
                                {{ $t("customer") }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i
                                    class="fas fa-users"
                                    style="font-size: 40px"
                                ></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3 text-white">{{ customerCount }}</h1>
                    <!-- Display Customer Count -->
                    <div class="mb-0">
                        <span class="text-success">
                            <i class="mdi mdi-arrow-bottom-right"></i>
                            {{ customerPercentageChange }}%
                        </span>
                        <span class="text-white opacity-8"
                            >Since last week</span
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-3 drop-zone">
            <div class="card text-white draggable">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title text-white opacity-9">
                                {{ $t("product") }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i
                                    class="fas fa-box-open"
                                    style="font-size: 40px"
                                ></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3 text-white">{{ productCount }}</h1>
                    <!-- Display Product Count -->
                    <div class="mb-0">
                        <span class="text-success">
                            <i class="mdi mdi-arrow-bottom-right"></i>
                            {{ productPercentageChange }}%
                        </span>
                        <span class="text-white opacity-8"
                            >Since last week</span
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-3 drop-zone">
            <div class="card text-white draggable">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title text-white opacity-9">
                                {{ $t("Sidebar.sale") }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i
                                    class="fas fa-user-tag"
                                    style="font-size: 40px"
                                ></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3 text-white">{{ saleCount }}</h1>
                    <!-- Display Product Count -->
                    <div class="mb-0">
                        <span class="text-success">
                            <i class="mdi mdi-arrow-bottom-right"></i>
                            {{ productPercentageChange }}%
                        </span>
                        <span class="text-white opacity-8"
                            >Since last week</span
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
axios.defaults.baseURL = "http://127.0.0.1:8000/api";
export default {
    data() {
        return {
            employees: [],
            customers: [],
            products: [],
            sales: [],
            previousEmployeeCount: 0,
            previousCustomerCount: 0,
            previousProductCount: 0,
            previousSaleCount: 0,
            isInitialFetch: true, // Flag to track first fetch
        };
    },
    computed: {
        employeeCount() {
            return this.employees.length;
        },
        customerCount() {
            return this.customers.length;
        },
        productCount() {
            return this.products.length;
        },
        saleCount() {
            return this.sales.length;
        },
        SaleTotalPrice() {
            return this.sales
                .reduce((total, sale) => {
                    return total + parseFloat(sale.price) || 0; // Parse price to float and ensure valid numbers
                }, 0)
                .toFixed(2); // Optional: format to 2 decimal places
        },

        // Calculate percentage change for each category, but only after the initial fetch
        employeePercentageChange() {
            return this.isInitialFetch
                ? 0
                : this.calculatePercentageChange(
                      this.previousEmployeeCount,
                      this.employeeCount
                  );
        },
        customerPercentageChange() {
            return this.isInitialFetch
                ? 0
                : this.calculatePercentageChange(
                      this.previousCustomerCount,
                      this.customerCount
                  );
        },
        productPercentageChange() {
            return this.isInitialFetch
                ? 0
                : this.calculatePercentageChange(
                      this.previousProductCount,
                      this.productCount
                  );
        },
    },
    methods: {
        fetchEmployees() {
            axios
                .get("/employees")
                .then((response) => {
                    if (!this.isInitialFetch) {
                        this.previousEmployeeCount = this.employeeCount; // Store previous count
                    }
                    this.employees = response.data;
                    this.isInitialFetch = false; // Mark initial fetch as completed
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        fetchCustomers() {
            axios
                .get("/customers")
                .then((response) => {
                    if (!this.isInitialFetch) {
                        this.previousCustomerCount = this.customerCount; // Store previous count
                    }
                    this.customers = response.data.customers.data;
                    this.isInitialFetch = false; // Mark initial fetch as completed
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        fetchProducts() {
            axios
                .get("/products")
                .then((response) => {
                    if (!this.isInitialFetch) {
                        this.previousProductCount = this.productCount; // Store previous count
                    }
                    this.products = response.data;
                    this.isInitialFetch = false; // Mark initial fetch as completed
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        fetchSales() {
            axios
                .get("/sales")
                .then((response) => {
                    if (!this.isInitialFetch) {
                        this.previousSaleCount = this.saleCount; // Store previous count
                    }
                    this.sales = response.data;
                    this.isInitialFetch = false; // Mark initial fetch as completed
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        // Calculate the percentage change
        calculatePercentageChange(previousValue, currentValue) {
            if (previousValue === 0) return currentValue > 0 ? 100 : 0; // Special case when there's no previous value
            return ((currentValue - previousValue) / previousValue) * 100;
        },
    },
    mounted() {
        this.fetchEmployees();
        this.fetchCustomers();
        this.fetchProducts();
        this.fetchSales();
    },
};
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap");

body {
    font-family: "Metal", sans-serif;
    margin: 0;
    padding: 0;
}
.drop-zone {
    width: 280px;
}
.draggable {
    background: linear-gradient(to right, #010921, #202c3c);
}
.dashboard-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    padding: 1rem;
}

/* .content-card {
    width: 280px;
    height: 120px;
    background: linear-gradient(to right, #1e3c72, #2a5298);
    border-radius: 15px;
    display: flex;
    align-items: center;
    padding: 1rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
} */

.content-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
}
.draggable {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}
.draggable:hover {
    transform: translateY(-5px);
}
.icons {
    font-size: 35px;
    color: white;
    margin-right: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
}

.content-title h2 {
    margin: 0;
    font-size: 20px;
    color: white;
}

.content-title p {
    margin: 5px 0 0;
    font-size: 15px;
    font-weight: bold;
    color: white;
}
</style>
