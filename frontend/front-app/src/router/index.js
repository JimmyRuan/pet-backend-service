import { createRouter, createWebHistory } from 'vue-router';
import PetRegistrationPage from '../pages/PetRegistrationPage.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: PetRegistrationPage,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
