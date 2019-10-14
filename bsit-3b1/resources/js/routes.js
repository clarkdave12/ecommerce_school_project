/* Admin views */
import Dashboard from './admin/Dashboard.vue';
import AdminCategories from './admin/pages/Categories.vue';
import AdminProducts from './admin/pages/Products.vue';
import AdminUsers from './admin/pages/Users.vue';

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
        path: '/admin/users',
        component: AdminUsers
    },
    {
        path: '/admin/categories',
        component: AdminCategories
    },
    {
        path: '/admin/products',
        component: AdminProducts
    },

    /* Other Routes */
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