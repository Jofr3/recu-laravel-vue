import {createRouter, createWebHistory} from 'vue-router';
import Index from '../components/index';
import Products from '../components/productes';

const routes = [
    {path: '/', component: Index},
    {path: '/productes', component: Products}
]

const routerHistory = createWebHistory();
const router = createRouter({
    history: routerHistory,
    routes
});

export default router