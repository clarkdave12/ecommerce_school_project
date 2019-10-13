require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import {routes} from './routes';
import {registerURL, loginURL, userRoleURL, userURL, getHeader} from './api';

window.getHeader = getHeader;
window.userURL = userURL;
window.userRoleURL = userRoleURL;
window.registerURL = registerURL;
window.loginURL = loginURL;

Vue.use(VueRouter);

window.axios = axios;



const router = new VueRouter({
    mode: 'history',
    routes
});

Vue.component('main-app', require('./components/MainApp.vue').default);

const app = new Vue({
    router,
    el: '#app',
});
