<script setup>
import { reactive, watch } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();

// Reactive form and error objects
let form = reactive({
    email: "",
    password: "",
});

let errors = reactive({
    email: "",
    password: "",
});

// Validation function
const validateForm = () => {
    let isValid = true;
    errors.email = "";
    errors.password = "";

    if (!form.email.trim()) {
        errors.email = "Email is required";
        isValid = false;
    } else if (!/\S+@\S+\.\S+/.test(form.email)) {
        errors.email = "Email is invalid";
        isValid = false;
    }

    if (!form.password.trim()) {
        errors.password = "Password is required";
        isValid = false;
    }

    return isValid;
};

// Real-time validation feedback
watch(
    () => form.email,
    () => {
        if (errors.email && form.email.trim()) {
            errors.email = ""; // Clear error once user starts typing
        }
    }
);

watch(
    () => form.password,
    () => {
        if (errors.password && form.password.trim()) {
            errors.password = ""; // Clear error once user starts typing
        }
    }
);

// Login function
const login = async () => {
    if (!validateForm()) {
        return; // Stop if validation fails
    }

    try {
        const response = await axios.post("api/auth/login", form);
        console.log(response); // Debugging

        // If the response contains a message indicating a login failure, handle it
        if (response.data.error) {
            errors.email = response.data.error || "Invalid login details.";
        } else {
            router.push("/"); // Redirect to Home after successful login
        }
    } catch (error) {
        console.error(
            "Error:",
            error.response?.data?.message || "Login failed"
        );

        const errorMessage = error.response?.data?.message;

        if (errorMessage.includes("email") || errorMessage.includes("Email")) {
            errors.email = errorMessage;
        } else if (
            errorMessage.includes("password") ||
            errorMessage.includes("Password")
        ) {
            errors.password = errorMessage;
        } else {
            errors.email = errorMessage || "Login failed";
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
            <h2 class="text-center mb-4 text-primary">Login</h2>
            <form @submit.prevent="login">
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

                <button type="submit" class="btn btn-primary w-100">
                    Sign-in
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
