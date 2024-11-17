import { createApp } from 'vue';
import App from './App.vue';
import store from './store';
import router from './router'; // Import the router
import './assets/tailwind.css';

const app = createApp(App);

app.use(store);
app.use(router); // Register the router
app.mount('#app');
