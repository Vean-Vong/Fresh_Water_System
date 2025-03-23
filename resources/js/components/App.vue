<script setup>
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "@fortawesome/fontawesome-free/css/all.min.css";
</script>

<template>
    <div class="layout">
        <!-- Sidebar -->
        <aside :class="['sidebar', { collapsed: isMobile && !sidebarOpen }]">
            <!-- Parent Container with Flexbox -->
            <div class="Logo">
                <img
                    src="http://gangsan.com.kh/wp-content/uploads/2018/08/cropped-logo-1.png"
                    style="width: 150px"
                />
            </div>

            <nav class="sidebar-menu">
                <router-link
                    to="/"
                    active-class="active"
                    @click="handleLinkClick"
                >
                    <i class="fa fa-home"></i>
                    {{ $t("Sidebar.dashboard") }}
                </router-link>
                <router-link
                    to="/employee"
                    active-class="active"
                    @click="handleLinkClick"
                >
                    <i class="fas fa-user-tie"></i>
                    {{ $t("Sidebar.employee") }}
                </router-link>
                <router-link
                    to="/customer"
                    active-class="active"
                    @click="handleLinkClick"
                >
                    <i class="fas fa-users"></i>
                    {{ $t("Sidebar.customer") }}
                </router-link>
                <router-link
                    to="/products"
                    active-class="active"
                    @click="handleLinkClick"
                >
                    <i class="fas fa-box-open"></i>
                    {{ $t("Sidebar.product") }}
                </router-link>
                <router-link
                    to="/sale"
                    active-class="active"
                    @click="handleLinkClick"
                >
                    <i class="fas fa-user-tag"></i>
                    {{ $t("Sidebar.sale") }}
                </router-link>
                <router-link
                    to="/setting"
                    active-class="active"
                    @click="handleLinkClick"
                >
                    <i class="fas fa-cog"></i>
                    {{ $t("Sidebar.setting") }}
                </router-link>
                <router-link
                    to="/about"
                    active-class="active"
                    @click="handleLinkClick"
                >
                    <i class="fas fa-info-circle"></i>
                    {{ $t("Sidebar.about") }}
                </router-link>
                <router-link
                    to="/client"
                    active-class="active"
                    @click="handleLinkClick"
                >
                    <i class="fas fa-building"></i>
                    {{ $t("Sidebar.client") }}
                </router-link>
                <!-- <router-link
                    to="/login"
                    active-class="active"
                    @click="handleLinkClick"
                >
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </router-link>
                <router-link
                    to="/register"
                    active-class="active"
                    @click="handleLinkClick"
                >
                    <i class="fas fa-user-plus"></i>
                    <span>Register</span>
                </router-link> -->
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <header class="navbar">
                <button
                    class="menu-toggle"
                    @click="toggleSidebar"
                    v-if="isMobile"
                >
                    ☰
                </button>
                <h2 class="text-white">{{ $t("system") }}</h2>

                <!-- Change Language and dark mode -->
                <div class="Right-item">
                    <!-- dark and Light Mode -->
                    <div class="dropdown">
                        <button
                            class="btn dropdown-toggle"
                            type="button"
                            @click="toggleDropdown"
                            aria-expanded="isDropdownOpen"
                            style="color: white"
                        >
                            <img
                                :src="selectedLanguage.flag"
                                alt="Flag"
                                class="flag-icon"
                            />
                            {{ selectedLanguage.short }}
                        </button>
                        <ul v-if="isDropdownOpen" class="dropdown-menu show">
                            <li v-for="lang in languages" :key="lang.name">
                                <a
                                    class="dropdown-item"
                                    @click="selectLanguage(lang)"
                                >
                                    <img
                                        :src="lang.flag"
                                        alt="Flag"
                                        class="flag-icon"
                                    />
                                    {{ lang.name }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- From Uiverse.io by RiccardoRapelli -->
                    <label class="switch">
                        <input id="input" type="checkbox" checked="darkTheme" />
                        <div class="slider round">
                            <div class="sun-moon">
                                <svg
                                    id="moon-dot-1"
                                    class="moon-dot"
                                    viewBox="0 0 100 100"
                                >
                                    <circle cx="50" cy="50" r="50"></circle>
                                </svg>
                                <svg
                                    id="moon-dot-2"
                                    class="moon-dot"
                                    viewBox="0 0 100 100"
                                >
                                    <circle cx="50" cy="50" r="50"></circle>
                                </svg>
                                <svg
                                    id="moon-dot-3"
                                    class="moon-dot"
                                    viewBox="0 0 100 100"
                                >
                                    <circle cx="50" cy="50" r="50"></circle>
                                </svg>
                                <svg
                                    id="light-ray-1"
                                    class="light-ray"
                                    viewBox="0 0 100 100"
                                >
                                    <circle cx="50" cy="50" r="50"></circle>
                                </svg>
                                <svg
                                    id="light-ray-2"
                                    class="light-ray"
                                    viewBox="0 0 100 100"
                                >
                                    <circle cx="50" cy="50" r="50"></circle>
                                </svg>
                                <svg
                                    id="light-ray-3"
                                    class="light-ray"
                                    viewBox="0 0 100 100"
                                >
                                    <circle cx="50" cy="50" r="50"></circle>
                                </svg>

                                <svg
                                    id="cloud-1"
                                    class="cloud-dark"
                                    viewBox="0 0 100 100"
                                >
                                    <circle cx="50" cy="50" r="50"></circle>
                                </svg>
                                <svg
                                    id="cloud-2"
                                    class="cloud-dark"
                                    viewBox="0 0 100 100"
                                >
                                    <circle cx="50" cy="50" r="50"></circle>
                                </svg>
                                <svg
                                    id="cloud-3"
                                    class="cloud-dark"
                                    viewBox="0 0 100 100"
                                >
                                    <circle cx="50" cy="50" r="50"></circle>
                                </svg>
                                <svg
                                    id="cloud-4"
                                    class="cloud-light"
                                    viewBox="0 0 100 100"
                                >
                                    <circle cx="50" cy="50" r="50"></circle>
                                </svg>
                                <svg
                                    id="cloud-5"
                                    class="cloud-light"
                                    viewBox="0 0 100 100"
                                >
                                    <circle cx="50" cy="50" r="50"></circle>
                                </svg>
                                <svg
                                    id="cloud-6"
                                    class="cloud-light"
                                    viewBox="0 0 100 100"
                                >
                                    <circle cx="50" cy="50" r="50"></circle>
                                </svg>
                            </div>

                            <!-- Icon dark and light mode -->
                            <div class="stars">
                                <svg
                                    id="star-1"
                                    class="star"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z"
                                    ></path>
                                </svg>
                                <svg
                                    id="star-2"
                                    class="star"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z"
                                    ></path>
                                </svg>
                                <svg
                                    id="star-3"
                                    class="star"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z"
                                    ></path>
                                </svg>
                                <svg
                                    id="star-4"
                                    class="star"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                    </label>

                    <div class="dropdown">
                        <button
                            class="btn dropdown-toggle"
                            type="button"
                            @click="openAvatar"
                            :aria-expanded="isOpenAvatar.toString()"
                        >
                            <img
                                class="avatar"
                                style="
                                    width: 50px;
                                    border-radius: 50%;
                                    margin-left: 20px;
                                    cursor: pointer;
                                "
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQYN4scLAOk6JcRBGzBZrq9N4zSHo6oOB_aycIUGb6FlF48fK8XsTr1a6AJZgMuYrduBeY&usqp=CAU"
                                alt="User Avatar"
                            />
                        </button>

                        <!-- Dropdown Menu -->
                        <div
                            v-if="isOpenAvatar"
                            class="dropdown-menu"
                            style="
                                position: absolute;
                                top: 50px;
                                right: 0;
                                width: 200px;
                            "
                        >
                            <ul
                                class="list-unstyled d-flex flex-column p-0 m-0"
                            >
                                <li>
                                    <router-link
                                        to="/profileComponent"
                                        active-class="active"
                                        @click="goToProfile"
                                        class="text-decoration-none d-flex align-items-center"
                                    >
                                        <i class="fas fa-user p-2"></i>
                                        <span>{{ $t("profile") }}</span>
                                    </router-link>
                                </li>
                                <li>
                                    <router-link
                                        to="/login"
                                        active-class="active"
                                        @click="logOut"
                                        class="text-decoration-none d-flex align-items-center"
                                    >
                                        <i
                                            class="fas fa-sign-out-alt p-2 text-danger"
                                        ></i>
                                        <span class="text-danger">{{
                                            $t("logout")
                                        }}</span>
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>

            <main>
                <router-view />
            </main>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            isMobile: window.innerWidth <= 768,
            isOpenAvatar: false,
            sidebarOpen: false,
            isDropdownOpen: false,
            selectedLanguage: {
                code: "km",
                name: "Khmer",
                short: "KH",
                flag: "https://flagcdn.com/w40/kh.png",
            },
            languages: [
                {
                    code: "km",
                    name: "Khmer",
                    short: "KH",
                    flag: "https://flagcdn.com/w40/kh.png",
                },
                {
                    code: "en",
                    name: "English",
                    short: "EN",
                    flag: "https://flagcdn.com/w40/gb.png",
                },
            ],
        };
    },
    mounted() {
        console.log("Responsive Sidebar and Navbar component mounted.");
        window.addEventListener("resize", this.handleResize);

        // Load the saved language from localStorage
        const savedLanguage = localStorage.getItem("selectedLanguage");
        if (savedLanguage) {
            this.selectedLanguage = JSON.parse(savedLanguage);
            this.$i18n.locale = this.selectedLanguage.code; // Apply saved language
        } else {
            // Default language based on Vue I18n locale
            this.selectedLanguage =
                this.languages.find(
                    (lang) => lang.code === this.$i18n.locale
                ) || this.languages[0];
        }
    },
    beforeUnmount() {
        window.removeEventListener("resize", this.handleResize);
    },
    methods: {
        handleResize() {
            this.isMobile = window.innerWidth <= 768;
            if (!this.isMobile) {
                this.sidebarOpen = true;
            }
        },
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        },
        handleLinkClick() {
            if (this.isMobile) {
                this.sidebarOpen = false;
            }
        },
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
        },
        selectLanguage(lang) {
            this.selectedLanguage = lang;
            this.$i18n.locale = lang.code;
            localStorage.setItem("selectedLanguage", JSON.stringify(lang)); // Save selection
            this.isDropdownOpen = false;
        },
        openAvatar() {
            this.isOpenAvatar = !this.isOpenAvatar;
        },
        goToProfile() {
            console.log("Navigate to Profile");
            this.isOpenAvatar = false;
        },
        goToSettings() {
            console.log("Navigate to Settings");
            this.isOpenAvatar = false;
        },
        logOut() {
            console.log("Log out");
            this.isOpenAvatar = false;
            this.$router.push("/login");
        },
    },
};
</script>

<style scoped>
h2 {
    font-family: "Moul", serif;
    font-weight: 400;
    font-style: normal;
    font-size: 20px;
}

/* Optional: Styling for the dropdown items */
.dropdown-menu {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 200px;
    right: 0;
}
.dropdown-menu ul {
    padding: 0;
    margin: 0;
}
.dropdown-menu li {
    padding: 8px 16px;
    cursor: pointer;
}
.dropdown-menu li:hover {
    background-color: #f1f1f1;
}
.Logo {
    margin-top: -10px;
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
}
.dropdown {
    position: relative;
    display: inline-block;
}
.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    display: block;
    background-color: white;
    border: 1px solid #ddd;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    min-width: 180px;
}
.dropdown-menu.show {
    display: block;
}
.dropdown-item {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    cursor: pointer;
}
.dropdown-item:hover {
    background-color: #f8f9fa;
}
.flag-icon {
    width: 20px;
    height: 14px;
    margin-right: 8px;
}
/* Layout */
.layout {
    display: flex;
    flex-direction: row;
    height: 100vh;
}

/* Sidebar */
.sidebar {
    display: flex;
    flex-direction: column;
    height: 100vh;
    width: 250px;
    background: linear-gradient(to right, #010921, #202c3c);
    padding: 1rem;
    border-right: 1px solid #ddd;
    transition: transform 0.3s ease;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}
.sidebar a i {
    margin-right: 10px;
}

.logout {
    margin-top: auto;
    padding: 10px 0;
    padding-bottom: 40px;
}
.sidebar.collapsed {
    transform: translateX(-100%);
    /* Hide sidebar off-screen when collapsed */
}

h1 {
    display: flex;
    justify-content: center;
    margin-bottom: 3rem;
    margin-top: 1rem;
    font-size: 30px;
    color: white;
}

/* Navigation Links */
.sidebar nav {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.sidebar a {
    display: flex;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    width: auto;
    text-decoration: none;
    color: white;
    font-size: 1rem;
    border-radius: 40px;
    transition: all 0.3s ease-in-out;
    width: 220px;
}

.sidebar a:hover {
    background-color: white;
    color: black;
    font-weight: bold;
    transform: translateX(10px);
}

.sidebar a.active {
    font-weight: bold;
    color: black;
    background-color: white;
}

.sidebar a i {
    font-size: 1.2rem;
}

/* Main Content */
.main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* Navbar */
.navbar {
    background: linear-gradient(to left, #010921, #202c3c);
    padding: 1rem;
    border-bottom: 1px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    box-shadow: 0px 4px 9px rgba(0, 0, 0, 0.2);
}

/* Menu Toggle Button */
.menu-toggle {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0.5rem;
}

/* Search Bar */
.search-bar {
    flex: 1;
    max-width: 400px;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

/* Main Content */
main {
    padding: 1rem;
    overflow-y: auto;
}

/* Bottom Switch dark and light mode */
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch #input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #2196f3;
    -webkit-transition: 0.4s;
    transition: 0.4s;
    z-index: 0;
    overflow: hidden;
}

.sun-moon {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: yellow;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

#input:checked + .slider {
    background-color: black;
}

#input:focus + .slider {
    box-shadow: 0 0 1px #2196f3;
}

#input:checked + .slider .sun-moon {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
    background-color: white;
    -webkit-animation: rotate-center 0.6s ease-in-out both;
    animation: rotate-center 0.6s ease-in-out both;
}

.moon-dot {
    opacity: 0;
    transition: 0.4s;
    fill: gray;
}

#input:checked + .slider .sun-moon .moon-dot {
    opacity: 1;
}

.slider.round {
    border-radius: 34px;
}

.slider.round .sun-moon {
    border-radius: 50%;
}

#moon-dot-1 {
    left: 10px;
    top: 3px;
    position: absolute;
    width: 6px;
    height: 6px;
    z-index: 4;
}

#moon-dot-2 {
    left: 2px;
    top: 10px;
    position: absolute;
    width: 10px;
    height: 10px;
    z-index: 4;
}

#moon-dot-3 {
    left: 16px;
    top: 18px;
    position: absolute;
    width: 3px;
    height: 3px;
    z-index: 4;
}

#light-ray-1 {
    left: -8px;
    top: -8px;
    position: absolute;
    width: 43px;
    height: 43px;
    z-index: -1;
    fill: white;
    opacity: 10%;
}

#light-ray-2 {
    left: -50%;
    top: -50%;
    position: absolute;
    width: 55px;
    height: 55px;
    z-index: -1;
    fill: white;
    opacity: 10%;
}

#light-ray-3 {
    left: -18px;
    top: -18px;
    position: absolute;
    width: 60px;
    height: 60px;
    z-index: -1;
    fill: white;
    opacity: 10%;
}

.cloud-light {
    position: absolute;
    fill: #eee;
    animation-name: cloud-move;
    animation-duration: 6s;
    animation-iteration-count: infinite;
}

.cloud-dark {
    position: absolute;
    fill: #ccc;
    animation-name: cloud-move;
    animation-duration: 6s;
    animation-iteration-count: infinite;
    animation-delay: 1s;
}

#cloud-1 {
    left: 30px;
    top: 15px;
    width: 40px;
}

#cloud-2 {
    left: 44px;
    top: 10px;
    width: 20px;
}

#cloud-3 {
    left: 18px;
    top: 24px;
    width: 30px;
}

#cloud-4 {
    left: 36px;
    top: 18px;
    width: 40px;
}

#cloud-5 {
    left: 48px;
    top: 14px;
    width: 20px;
}

#cloud-6 {
    left: 22px;
    top: 26px;
    width: 30px;
}

@keyframes cloud-move {
    0% {
        transform: translateX(0px);
    }

    40% {
        transform: translateX(4px);
    }

    80% {
        transform: translateX(-4px);
    }

    100% {
        transform: translateX(0px);
    }
}

.stars {
    transform: translateY(-32px);
    opacity: 0;
    transition: 0.4s;
}

.star {
    fill: white;
    position: absolute;
    -webkit-transition: 0.4s;
    transition: 0.4s;
    animation-name: star-twinkle;
    animation-duration: 2s;
    animation-iteration-count: infinite;
}

#input:checked + .slider .stars {
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    transform: translateY(0);
    opacity: 1;
}

#star-1 {
    width: 20px;
    top: 2px;
    left: 3px;
    animation-delay: 0.3s;
}

#star-2 {
    width: 6px;
    top: 16px;
    left: 3px;
}

#star-3 {
    width: 12px;
    top: 20px;
    left: 10px;
    animation-delay: 0.6s;
}

#star-4 {
    width: 18px;
    top: 0px;
    left: 18px;
    animation-delay: 1.3s;
}

@keyframes star-twinkle {
    0% {
        transform: scale(1);
    }

    40% {
        transform: scale(1.2);
    }

    80% {
        transform: scale(0.8);
    }

    100% {
        transform: scale(1);
    }
}

/* Responsive Styles */
@media (max-width: 768px) {
    .layout {
        flex-direction: column;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        z-index: 1000;
        background-color: #f8f9fa;
        transform: translateX(-100%); /* Hide sidebar off-screen */
    }

    .sidebar:not(.collapsed) {
        transform: translateX(0); /* Show sidebar when not collapsed */
    }

    .navbar {
        display: flex;
        gap: 1rem;
    }

    .menu-toggle {
        display: block;
    }

    main {
        margin-top: 4rem;
    }
}
</style>
