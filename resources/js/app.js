import './bootstrap';
import { createApp } from 'vue';
import router from './router'; // Import the router

const app = createApp({});

// Register your components if needed
import App from './components/App.vue';
app.component('example-component', App);

// Use the router in your app
app.use(router);

app.mount('#app');
