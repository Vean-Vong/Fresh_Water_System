import { createRouter, createWebHistory } from "vue-router";

// Use dynamic imports for all components
const Home = () => import("@/view/Dashboard/Homepage.vue");
const About = () => import("@/view/About.vue");
const Customer = () => import("@/view/Customers/Customer.vue");
const Employee = () => import("@/view/Employees/Employee.vue");
const Product = () => import("@/view/Products.vue");
const Register = () => import("@/view/Auth/Register.vue");
const Login = () => import("@/view/Auth/Login.vue");

const routes = [
    {
        path: "/",
        component: Home,
    },
    {
        path: "/about",
        component: About,
    },
    {
        path: "/customer",
        component: Customer,
    },
    {
        path: "/employee",
        component: Employee,
    },
    {
        path: "/products",
        component: Product,
    },
    {
        path: "/register",
        component: Register,
    },
    {
        path: "/login",
        component: Login,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
