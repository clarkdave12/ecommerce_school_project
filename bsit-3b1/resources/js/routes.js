/* Admin views */
import Dashboard from './admin/Dashboard.vue';
import AdminCategories from './admin/pages/Categories.vue';
import AdminProducts from './admin/pages/Products.vue';
import AdminUsers from './admin/pages/Users.vue';
import AddProduct from './admin/pages/AddProduct.vue';

import Home from './pages/Home.vue';
import Register from './pages/Register.vue';
import Login from './pages/Login.vue';
import LandingPage from './pages/LandingPage.vue';
import ProductDetails from './pages/ProductDetails.vue';
import Cart from './pages/Cart.vue';

export const routes = [
    /* For Admin */
    {
        path: '/admin',
        component: Dashboard,
        meta: { forAdmin: true }
    },
    {
        path: '/admin/users',
        component: AdminUsers,
        meta: { forAdmin: true }
    },
    {
        path: '/admin/categories',
        component: AdminCategories,
        meta: { forAdmin: true }
    },
    {
        path: '/admin/products',
        component: AdminProducts,
        meta: { forAdmin: true }
    },
    {
        path: '/admin/products/add',
        component: AddProduct,
        meta: { forAdmin: true }
    },

    /* Other Routes */
    {
        path: '/',
        component: LandingPage
    },
    {
        path: '/products',
        component: Home
    },
    {
        path: '/product_details/:id',
        component: ProductDetails
    },
    {
        path: '/register',
        component: Register,
        meta: { forGuest: true }
    },
    {
        path: '/login',
        component: Login,
        meta: { forGuest: true }
    },
    {
        path: '/cart',
        component: Cart,
        meta: { forUser: true }
    }
]