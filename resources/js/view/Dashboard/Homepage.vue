<template>
    <div class="dashboard-container">
        <div class="content-card">
            <div class="icons">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="content-title">
                <h2>Earnings</h2>
                <p>$2274.00</p>
            </div>
        </div>
        <div class="content-card">
            <div class="icons">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="content-title">
                <h2>Employees</h2>
                <p>1299</p>
            </div>
        </div>
        <div class="content-card">
            <div class="icons">
                <i class="fas fa-users"></i>
            </div>
            <div class="content-title">
                <h2>Customers</h2>
                <p>100</p>
            </div>
        </div>
        <!-- <div class="content-card">
            <div class="icons">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="content-title">
                <h2>Orders</h2>
                <p>450</p>
            </div>
        </div> -->

        <!-- <div class="content-card">
            <div class="icons">
                <i class="fas fa-eye"></i>
            </div>
            <div class="content-title">
                <h2>Visitors</h2>
                <p>8,900</p>
            </div>
        </div> -->
        <div class="content-card">
            <div class="icons">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="content-title">
                <h2>Active Users</h2>
                <p>350</p>
            </div>
        </div>
    </div>
</template>

<style>
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap");

body {
    font-family: "Roboto", sans-serif;
    margin: 0;
    padding: 0;
}

.dashboard-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    padding: 1rem;
}

.content-card {
    width: 280px;
    height: 120px;
    background: linear-gradient(to right, #1e3c72, #2a5298);
    border-radius: 15px;
    display: flex;
    align-items: center;
    padding: 1rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.content-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
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
