require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import {routes} from './routes';
import {registerURL, loginURL, userRoleURL, userURL, getHeader,
        categoryURL,productURL, getUserURL, feedbackURL, cartURL,
        getAccessToken, isAuthenticated} from './api';


window.isAuthenticated = isAuthenticated;
window.getAccessToken = getAccessToken;
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
            axios.get(userURL, {headers: getHeader()})
                .then(response => {
                    
                    next({ path: '/products' })
                })
                .catch(error => {
                    
                    next()
                })
        }
        else { next() }

        /* Navigation Guard for User */
        if(to.matched.some(record => record.meta.forUser)) {
            axios.get(userURL, {headers: getHeader()})
                .then(response => {
                    next()
                })
                .catch(error => {
                    next({ path: '/login' })
                })
        }
        else { next() }

        /* Navigation Guard for Admin */
        if(to.matched.some(record => record.meta.forAdmin)) {
            axios.get(userURL, {headers: getHeader()})
                .then(response => {
                    axios.get(userRoleURL + '/' + response.data.id)
                        .then(response => {
                            if(response.data == 'User') {
                                next({ path: '/products' })
                            }
                            else if(response.data == 'Admin') {
                                next()
                            }
                            else {
                                next({ path: '/login' })
                            }
                        })
                        .catch(error => {
                            next({ path: '/login' })
                        })
                })
                .catch(error => {
                    next({ path: '/login' })
                })
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
