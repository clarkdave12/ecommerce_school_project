/* Admin views */
import Dashboard from './admin/Dashboard.vue';


import Home from './pages/Home.vue';
import Register from './pages/Register.vue';
import Login from './pages/Login.vue';
import LandingPage from './pages/LandingPage.vue';

export const routes = [
    /* For Admin */
    {
        path: '/admin',
        component: Dashboard
    },

    {
        path: '/',
        component: LandingPage
    },
    {
        path: '/home',
        component: Home
    },
    {
        path: '/register',
        component: Register
    },
    {
        path: '/login',
        component: Login
    }
]