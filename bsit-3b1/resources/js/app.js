require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuetify from 'vuetify';
import axios from 'axios';
import {routes} from './routes';
import {store} from './store/store'
import {api} from './api'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import VueChatScroll from 'vue-chat-scroll'

Vue.use(VueChatScroll)
Vue.use(VueRouter);
Vue.use(Vuetify);


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

        /* For Authenticated */
        if(to.matched.some(record => record.meta.forAuth)) {
            if(localStorage.getItem('token')) {
                store.dispatch('USER_DATA')
                    .then(() => {
                        if(store.state.user.role == 'Admin') {
                            next()
                        }
                        else if(store.state.user.role == 'User') {
                            next()
                        }
                        else {
                            next({
                                path: '/login'
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
    vuetify: new Vuetify({
        icons: {
            iconfont: 'md'
        }
    }),
});
