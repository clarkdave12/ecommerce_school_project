require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import {routes} from './routes';
import {store} from './store/store'
import {api} from './api'

Vue.use(VueRouter);

window.api = api;
window.axios = axios;
window.bus = new Vue();

const router = new VueRouter({
    mode: 'history',
    routes
});


router.beforeEach(
    (to, from, next) => {
        /* for Guest */
        if(to.matched.some(record => record.meta.forGuest)) {
            if(localStorage.getItem('token')) {
                store.dispatch('USER_DATA')
                    .then(() => {
                        if(store.state.user.role == 'Admin') {
                            next({
                                path: '/admin'
                            })
                        }
                        else if(store.state.user.role == 'User') {
                            next({
                                path: '/products'
                            })
                        }
                        else {
                            next()
                        }
                    })
                    .catch(error => {
                        next()
                    })
            } 
            else {
                next()
            }
        }
        /* for user */
        else if(to.matched.some(record => record.meta.forUser)) {
            if(localStorage.getItem('token')) {
                store.dispatch('USER_DATA')
                    .then(() => {
                        if(store.state.user.role == 'User') {
                            next()
                        }
                        else {
                            next({
                                path: '/products'
                            })
                        }
                    })
                    .catch(error => {
                        next({
                            path: '/login'
                        })
                    })
            }
            else {
                next({
                    path: '/login'
                })
            }
        }
        /* for Admin */
        else if(to.matched.some(record => record.meta.forAdmin)) {
            if(localStorage.getItem('token')) {
                store.dispatch('USER_DATA')
                    .then(() => {
                        if(store.state.user.role == 'Admin') {
                            next()
                        }
                        else {
                            next({
                                path: '/'
                            })
                        }
                    })
                    .catch(error => {
                        next({
                            path: '/login'
                        })
                    })
            }
            else {
                next({
                    path: '/login'
                })
            }
        }
        else {
            next()
        }
    }
)


Vue.component('main-app', require('./components/MainApp.vue').default);

const app = new Vue({
    router,
    store,
    el: '#app',
});
