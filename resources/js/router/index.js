import { createRouter, createWebHistory } from "vue-router";
// Use dynamic imports for all components
const Home = () => import("@/view/Dashboard/Homepage.vue");
const About = () => import("@/view/About.vue");
const Customer = () => import("@/view/Customers/Customer.vue");
const addCustomer = () => import("@/view/Customers/addCustomer.vue");
const editCustomer = () => import("@/view/Customers/editCustomer.vue");
const viewCustomer = () => import("@/view/Customers/viewCustomer.vue");
const Employee = () => import("@/view/Employees/Employee.vue");
const Product = () => import("@/view/Products/Products.vue");
const viewProduct = () => import("@/view/Products/viewProduct.vue");
const Users = () => import("@/view/Users/User.vue");
const addUser = () => import("@/view/Users/addUser.vue");
const Setting = () => import("@/view/Settings/Setting.vue");
const addProduct = () => import("@/view/Products/addProduct.vue");
const editProduct = () => import("@/view/Products/editProduct.vue");
const Register = () => import("@/view/Auth/Register.vue");
const Login = () => import("@/view/Auth/Login.vue");
const Client = () => import("@/view/Client.vue");
const Profile = () => import("@/view/ProfileComponent.vue");
const Sale = () => import("@/view/Sales/Sale.vue");
const addSale = () => import("@/view/Sales/addSale.vue");
const editSale = () => import("@/view/Sales/editSale.vue");
const addEmployee = () => import("@/view/Employees/addEmployee.vue");
const editEmployee = () => import("@/view/Employees/EditEmployee.vue");
const viewEmployee = () => import("@/view/Employees/viewEmployee.vue");

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
        path: "/setting",
        component: Setting,
    },
    {
        path: "/customer",
        component: Customer,
    },
    {
        path: "/viewCustomer/:id",
        component: viewCustomer,
    },
    {
        path: "/addCustomer",
        component: addCustomer,
    },
    {
        path: "/editCustomer/:id",
        component: editCustomer,
    },

    {
        path: "/employee",
        component: Employee,
    },
    {
        path: "/viewEmployee/:id",
        component: viewEmployee,
    },
    {
        path: "/addEmployee",
        component: addEmployee,
    },
    {
        path: "/editEmployee/:id",
        component: editEmployee,
    },

    {
        path: "/register",
        component: Register,
    },
    {
        path: "/users",
        component: Users,
    },   {
        path: "/addUser",
        component: addUser,
    },
    {
        path: "/login",
        component: Login,
    },
    {
        path: "/client",
        component: Client,
    },
    {
        path: "/profileComponent",
        component: Profile,
    },

    {
        path: "/products",
        component: Product,
    },
    {
        path: "/viewProduct/:id",
        component: viewProduct,
    },

    {
        path: "/addProduct",
        component: addProduct,
    },
    {
        path: "/editProduct/:id",
        component: editProduct,
    },
    {
        path: "/sale",
        component: Sale,
    },
    {
        path: "/addSale",
        component: addSale,
    },
    {
        path: "/editSale/:id",
        component: editSale,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
