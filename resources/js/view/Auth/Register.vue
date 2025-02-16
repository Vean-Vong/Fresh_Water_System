<script setup>
import { reactive, watch } from "vue";
import axios from "axios";
import { useRouter } from "vue-router"; // Import Vue Router

// Initialize Vue Router
const router = useRouter();

// Form and errors reactive objects
let form = reactive({
    name: "",
    email: "",
    password: "",
    phone_number: "",
});

let errors = reactive({
    name: "",
    email: "",
    password: "",
    phone_number: "",
    emailExists: "", // To handle the specific email existence error
});

// Validation function
const validateForm = () => {
    let isValid = true;

    // Reset errors on every validation call
    errors.name = "";
    errors.email = "";
    errors.password = "";
    errors.phone_number = "";
    errors.emailExists = ""; // Reset emailExists error

    // Validate Username
    if (!form.name) {
        errors.name = "Username is required";
        isValid = false;
    }

    // Validate Email
    if (!form.email) {
        errors.email = "Email is required";
        isValid = false;
    } else if (!/\S+@\S+\.\S+/.test(form.email)) {
        errors.email = "Email is invalid";
        isValid = false;
    }

    // Validate Password
    if (!form.password) {
        errors.password = "Password is required";
        isValid = false;
    } else if (form.password.length < 6) {
        errors.password = "Password must be at least 6 characters";
        isValid = false;
    }

    // Validate Phone Number
    if (!form.phone_number) {
        errors.phone_number = "Phone number is required";
        isValid = false;
    } else if (!/^\d{9,10}$/.test(form.phone_number)) {
        errors.phone_number = "Phone number must be 9 or 10 digits";
        isValid = false;
    }

    return isValid;
};

// Clear errors when the user starts typing
watch(
    () => form.name,
    () => {
        if (errors.name && form.name.trim()) errors.name = "";
    }
);

watch(
    () => form.email,
    () => {
        if (errors.email && form.email.trim()) errors.email = "";
        if (errors.emailExists) errors.emailExists = "";
    }
);

watch(
    () => form.password,
    () => {
        if (errors.password && form.password.trim()) errors.password = "";
    }
);

watch(
    () => form.phone_number,
    () => {
        if (errors.phone_number && form.phone_number.trim())
            errors.phone_number = "";
    }
);

// Register function (to handle form submission)
const register = async () => {
    if (!validateForm()) {
        return;
    }

    try {
        // Send the registration data
        const response = await axios.post("/api/auth/register", form);
        console.log(response); // For debugging purposes

        // If registration is successful, reset the form and redirect to login page
        form.name = "";
        form.email = "";
        form.password = "";
        form.phone_number = "";

        // Navigate to login page
        router.push("/login"); // Assuming you have a login route
    } catch (error) {
        // Log the error to debug the response structure
        console.error("Registration error response:", error.response);

        // Handle errors returned from the server
        if (error.response?.data?.email) {
            errors.emailExists = error.response.data.email[0]; // Display the first email error message
        } else {
            console.error(error.response?.data?.message || "Register failed");
        }
    }
};
</script>

<template>
    <div class="d-flex justify-content-center align-items-center">
        <div
            class="card shadow p-4"
            style="width: 100%; max-width: 400px; border-radius: 15px"
        >
            <h2 class="text-center text-primary mb-4">Registration</h2>
            <form @submit.prevent="register">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input
                        type="text"
                        class="form-control"
                        id="username"
                        v-model="form.name"
                        placeholder="Enter your username"
                    />
                    <div v-if="errors.name" class="text-danger mt-1">
                        {{ errors.name }}
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        v-model="form.email"
                        placeholder="Enter your email"
                    />
                    <div v-if="errors.email" class="text-danger mt-1">
                        {{ errors.email }}
                    </div>
                    <div v-if="errors.emailExists" class="text-danger mt-1">
                        {{ errors.emailExists }}
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        v-model="form.password"
                        placeholder="Enter your password"
                    />
                    <div v-if="errors.password" class="text-danger mt-1">
                        {{ errors.password }}
                    </div>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input
                        type="text"
                        class="form-control"
                        id="phone"
                        v-model="form.phone_number"
                        placeholder="Enter your phone number"
                    />
                    <div v-if="errors.phone_number" class="text-danger mt-1">
                        {{ errors.phone_number }}
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">
                    Sign-up
                </button>
            </form>
        </div>
      
    </div>
</template>

<style scoped>
body {
    background-color: #f8f9fa;
}

.card {
    background: #ffffff;
}

input:focus {
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    border-color: #80bdff;
}

button {
    border-radius: 25px;
}
</style>
