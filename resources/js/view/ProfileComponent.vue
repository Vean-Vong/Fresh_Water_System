<template>
    <div>
        <div class="container mt-1">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <!-- Profile Picture -->
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ username }}</h5>
                            <p class="card-text">Email: {{ email }}</p>
                            <p class="card-text">Phone: {{ phone }}</p>
                            <div class="btn">
                                <button
                                    class="btn btn-primary"
                                    @click="editProfile"
                                >
                                    Edit
                                </button>
                                <button
                                    class="btn btn-danger mt-2"
                                    @click="deleteProfile"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Profile Information</h4>
                        </div>
                        <div class="card-body">
                            <h5>Username:</h5>
                            <p>{{ username }}</p>
                            <hr />
                            <h5>Gender:</h5>
                            <p>{{ gender }}</p>
                            <hr />
                            <h5>Email:</h5>
                            <p>{{ email }}</p>
                            <hr />
                            <h5>Password:</h5>
                            <p>{{ password }}</p>
                            <hr />
                            <h5>Phone Number:</h5>
                            <p>{{ phone }}</p>
                            <hr />
                            <h5>Address:</h5>
                            <p>{{ address }}</p>
                            <hr />
                            <h5>Phone Number:</h5>
                            <p>{{ phone }}</p>
                            <hr />
                            <h5>Date of Birth:</h5>
                            <p>{{ phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Modal (optional) -->
        <div v-if="isEditing" class="modal">
            <div class="modal-content">
                <h4>Edit Profile</h4>
                <div>
                    <label for="editUsername">Username</label>
                    <input
                        v-model="newUsername"
                        id="editUsername"
                        type="text"
                    />
                </div>
                <div>
                    <label for="editEmail">Email</label>
                    <input v-model="newEmail" id="editEmail" type="email" />
                </div>
                <div>
                    <label for="editPhone">Phone Number</label>
                    <input v-model="newPhone" id="editPhone" type="text" />
                </div>
                <button @click="saveProfile">Save Changes</button>
                <button @click="cancelEdit">Cancel</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            profilePicture: "https://via.placeholder.com/150",
            username: localStorage.getItem("username") || "Default User",
            email: localStorage.getItem("email") || "example@example.com",
            phone: localStorage.getItem("phone_number") || "1234567890",
            isEditing: false,
            newUsername: "",
            newEmail: "",
            newPhone: "",
        };
    },
    methods: {
        editProfile() {
            // Pre-fill the fields with current data
            this.newUsername = this.username;
            this.newEmail = this.email;
            this.newPhone = this.phone;
            this.isEditing = true;
        },
        saveProfile() {
            // Save changes to localStorage
            localStorage.setItem("username", this.newUsername);
            localStorage.setItem("email", this.newEmail);
            localStorage.setItem("phone_number", this.newPhone);

            // Update the data in the component
            this.username = this.newUsername;
            this.email = this.newEmail;
            this.phone = this.newPhone;

            this.isEditing = false;
        },
        cancelEdit() {
            this.isEditing = false;
        },
        deleteProfile() {
            // Clear data from localStorage
            localStorage.removeItem("username");
            localStorage.removeItem("email");
            localStorage.removeItem("phone_number");

            // Reset component data
            this.username = "Default User";
            this.email = "example@example.com";
            this.phone = "1234567890";
        },
    },
};
</script>

<style scoped>
/* Optional: Style the modal */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}
.modal-content {
    background: white;
    border-radius: 5px;
    width: 300px;
}
</style>
