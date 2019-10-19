require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import {routes} from './routes';
import {registerURL, loginURL, userRoleURL, userURL, getHeader,
        categoryURL,productURL, getUserURL, feedbackURL, cartURL} from './api';


window.cartURL = cartURL;
window.feedbackURL = feedbackURL;
window.productURL = productURL;
window.getUserURL = getUserURL;
window.categoryURL = categoryURL;
window.getHeader = getHeader;
window.userURL = userURL;
window.userRoleURL = userRoleURL;
window.registerURL = registerURL;
window.loginURL = loginURL;

Vue.use(VueRouter);

window.axios = axios;
window.bus = new Vue();

const router = new VueRouter({
    mode: 'history',
    routes
});


router.beforeEach(
    (to, from, next) => {
        /* Navigation Guard for Guest */
        if(to.matched.some(record => record.meta.forGuest)) {
            if(window.localStorage.getItem('role') == 'User') {
                next({ path: '/home' })
            }
            else if(window.localStorage.getItem('role') == 'Admin') {
                next({ path: '/admin' })
            }
            else { next() }
        }
        else { next() }

        /* Navigation Guard for User */
        if(to.matched.some(record => record.meta.forUser)) {
            if(window.localStorage.getItem('role') != 'User') {
                next({ path: '/login' })
            }
            else { next() }
        }
        else { next() }

        /* Navigation Guard for Admin */
        if(to.matched.some(record => record.meta.forAdmin)) {
            if(window.localStorage.getItem('role') != 'Admin') {
                next({ path: '/login' })
            }
            else if(window.localStorage.getItem('role') == 'User') {
                from()
            }
            else { next() }
        }
        else { next() }
    }
)


Vue.component('main-app', require('./components/MainApp.vue').default);
Vue.component('admin-navbar', require('./admin/AdminNavbar.vue').default);

const app = new Vue({
    router,
    el: '#app',
});
