/* Admin views */
import Dashboard from './admin/Dashboard.vue';
import AdminCategories from './admin/pages/Categories.vue';
import AdminProducts from './admin/pages/Products.vue';
import AdminUsers from './admin/pages/Users.vue';
import AddProduct from './admin/pages/AddProduct.vue';
import ManageFeedbacks from './admin/pages/ManageFeedbacks.vue';
import EditProduct from './admin/pages/EditProduct.vue';
import Specs from './admin/pages/Specs.vue';
import Payments from './admin/pages/Payments.vue';

import Home from './pages/Home.vue';
import Register from './pages/Register.vue';
import Login from './pages/Login.vue';
import LandingPage from './pages/LandingPage.vue';
import ProductDetails from './pages/ProductDetails.vue';
import Cart from './pages/Cart.vue';
import Profile from './pages/Profile.vue';
import ProfileCreate from './pages/ProfileCreate.vue';
import UserFeedback from './pages/UserFeedback.vue';
import Message from './pages/Message.vue';
import Builder from './builder/Builder.vue';
import Contact from './pages/MessageComponents/Mobile/AdminContacts.vue';
import Success from './pages/SuccessfulPayment.vue';
import History from './pages/History.vue';
import OrderDetails from './admin/pages/OrderDetails.vue';
import ForgotPassword from './pages/ForgotPassword.vue';
import ResetPassword from './pages/ResetPassword.vue';
import ChangeProfile from './pages/ChangeProfile.vue';

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
        path: '/admin/product/:product_id',
        component: EditProduct,
        meta: { forAdmin: true }
    },
    {
        path: '/admin/products/add',
        component: AddProduct,
        meta: { forAdmin: true }
    },
    {
        path: '/admin/manage_feedbacks',
        component: ManageFeedbacks,
        meta: { forAdmin: true }
    },
    {
        path: '/specs/:product_id',
        component: Specs,
    },
    {
        path: '/payments',
        component: Payments,
        meta: { forAdmin: true }
    },
    {
        path: '/order_details/:user_id/:product_id/:quantity',
        component: OrderDetails,
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
        path: '/cart/:user_id',
        component: Cart,
        meta: { forUser: true }
    },
    {
        path: '/profile/:user_id',
        component: Profile,
        meta: { forUser: true }
    },
    {
        path: '/profile/create/:user_id',
        component: ProfileCreate,
        meta: { forUser: true }
    },
    {
        path: '/user_feedback/:user_id',
        component: UserFeedback,
        meta: { forUser: true }
    },
    {
        path: '/messages',
        component: Message,
    },
    {
        path: '/builder',
        component: Builder, 
        meta: { forUser: true }
    },
    {
        path: '/contact',
        component: Contact,    
    },
    {
        path: '/success',
        component: Success
    },
    {
        path: '/history',
        component: History,
        meta: { forUser: true }
    },
    {
        path: '/forgot_password',
        component: ForgotPassword,
        meta: { forGuest: true }
    },
    {
        path: '/reset_password',
        component: ResetPassword,
        meta: { forGuest: true }
    },
    {
        path: '/change_profile',
        component: ChangeProfile,
        meta: { forUser: true }
    }
]