import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import {api} from '../api'


Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        token: [],
        user: [],
        products: [],
        product: [],
        feedbacks: [],
        cart: [],
        userFeedbacks: [],
        allFeedbacks: [],
        profile: [],
        categories: [],
        messages: [],
        specs: [],
        admins: [],
        users: [],

        receiver: '',
        loader: false
    },
    mutations: {
        SET_LOADER: (state, data) => {
            state.loader = data
        },

        SET_TOKEN: (state, data) => {
            state.token = data
        },

        SET_USER: (state, data) => {
            state.user = data
        },

        SET_PRODUCTS: (state, data) => {
            state.products = data
        },

        SET_PRODUCT_INFO: (state, data) => {
            state.product = data
        },

        SET_FEEDBACKS: (state, data) => {
            state.feedbacks = data
        },

        SET_CART: (state, data) => {
            state.cart = data
        },

        SET_USER_FEEDBACKS: (state, data) => {
            state.userFeedbacks = data
        },

        SET_PROFILE: (state, data) => {
            state.profile = data
        },

        SET_CATEGORIES: (state, data) => {
            state.categories = data
        },

        SET_ALL_FEEDBACKS: (state, data) => {
            state.allFeedbacks = data
        },

        SET_MESSAGES: (state, data) => {
            state.messages = data
        },

        SET_SPECS: (state, data) => {
            state.specs = data
        },

        SET_ADMINS: (state, data) => {
            state.admins = data
        },

        SET_USERS: (state, data) => {
            state.users = data
        },

        SET_RECEIVER: (state, data) => {
            state.receiver = data
        }
    },
    actions: {

        LOGIN: ({commit}, payload) => {
            commit('SET_LOADER', true)
            return new Promise((resolve, reject) => {
                axios.post(api.login, payload)
                    .then(({data}) => {
                        commit('SET_TOKEN', data)
                        commit('SET_LOADER', false)
                        resolve(true)
                    })      
                    .catch(error => {
                        commit('SET_LOADER', false)
                        reject(error)
                    })
            })
        },

        USER_DATA: ({commit}) => {

            const header = {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            }

            const userInfo = {
                email: '',
                name: '',
                id: '',
                address: '',
                role: ''
            }

            return new Promise((resolve, reject) => {
                axios.get(api.user, { headers: header })
                    .then(({data}) => {
                        userInfo.email = data.email
                        userInfo.name = data.last_name + ', ' + data.first_name
                        userInfo.id = data.id
                        userInfo.address = data.address

                        /* get the user role */
                        axios.get(api.userRole + '/' + userInfo.id, {headers: header})
                            .then(({data}) => {
                                userInfo.role = data

                                commit('SET_USER', userInfo)
                                resolve(true)

                            }) 
                            .catch(error => {
                                reject(error)
                            })

                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        REGISTER: ({commit}, payload) => {
            commit('SET_LOADER', true)
            return new Promise((resolve, reject) => {
                axios.post(api.register, payload)
                    .then(() => {
                        commit('SET_LOADER', false)
                        resolve(true)
                    })
                    .catch(error => {
                        commit('SET_LOADER', false)
                        console.log(error.response)
                    })
            })
        },

        GET_PRODUCTS: ({commit}) => {
            commit('SET_LOADER', true)
            return new Promise((resolve, reject) => {
                axios.get(api.products)
                    .then(({data}) => {
                        commit('SET_PRODUCTS', data.products)   
                        commit('SET_LOADER', false)         
                        resolve(true)
                    })
                    .catch(error => {
                        commit('SET_LOADER', false)
                        reject(error)
                    })
            })
        },

        GET_PRODUCT_INFO: ({commit}, payload) => {
            commit('SET_LOADER', true)
            return new Promise((resolve, reject) => {
                axios.get(api.products + '/' + payload)
                    .then(({data}) => {
                        commit('SET_PRODUCT_INFO', data.product)
                        commit('SET_LOADER', false)
                        resolve(true)
                    })
                    .catch(error => {
                        commit('SET_LOADER', false)
                        reject(error)
                    })
            })
        },

        GET_FEEDBACKS: ({commit}, payload) => {
            commit('SET_LOADER', true)
            return new Promise((resolve, reject) => {
                axios.get(api.feedbacks + '/' + payload)
                    .then(({data}) => {
                        commit('SET_FEEDBACKS', data.feedbacks)
                        commit('SET_LOADER', false)
                        resolve(true)
                    })
                    .catch(error => {
                        commit('SET_LOADER', false)
                        reject(error)
                    })
            })
        },

        ADD_TO_CART: ({commit}, payload) => {
            return new Promise((resolve, reject) => {
                axios.post(api.carts, payload)
                    .then(() => {
                        resolve(true)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        POST_FEEDBACK: ({commit}, payload) => {
            return new Promise((resolve, reject) => {
                axios.post(api.feedbacks, payload)
                    .then(() => {
                        resolve(true)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        GET_CART: ({commit}, payload) => {
            commit('SET_LOADER', true)
            return new Promise((resolve, reject) => {
                axios.get(api.carts + '/' + payload)
                    .then(({data}) => {
                        commit('SET_CART', data)
                        commit('SET_LOADER', false)
                        resolve(true)
                    })
                    .catch(error => {
                        commit('SET_LOADER', false)
                        reject(error)
                    })
            })
        },

        GET_USER_FEEDBACKS: ({commit}, payload) => {
            commit('SET_LOADER', true)
            return new Promise((resolve, reject) => {
                axios.get(api.userFeedback + '/' + payload)
                    .then(({data}) => {
                        commit('SET_USER_FEEDBACKS', data.feedbacks)
                        commit('SET_LOADER', false)
                        resolve(true)
                    })
                    .catch(error => {
                        commit('SET_LOADER', false)
                        reject(error)
                    })
            })
        },

        GET_PROFILE: ({commit}, payload) => {
            commit('SET_LOADER', true)
            return new Promise((resolve, reject) => {
                axios.get(api.userProfile + '/' + payload)
                    .then(({data}) => {
                        commit('SET_PROFILE', data.profile[0])
                        commit('SET_LOADER', false)
                        resolve(true)
                    })
                    .catch(error => {
                        commit('SET_LOADER', false)
                        reject(error)
                    })
            })
        },

        UPDATE_PROFILE: ({commit}, payload) => {

            return new Promise((resolve, reject) => {
                axios.post(api.updateProfile + '/' + payload.user_id, payload)
                    .then(() => {
                        resolve(true)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        GET_MESSAGES: ({commit}, payload) => {

            return new Promise((resolve, reject) => {
                axios.get(api.message + '/' + payload)
                    .then(({data}) => {
                        commit('SET_MESSAGES', data)
                        console.log(data)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        GET_ADMINS: ({commit}) => {

            return new Promise((resolve, reject) => {
                axios.get(api.messageAdmin)
                    .then(({data}) => {
                        commit('SET_ADMINS', data)
                        resolve(true)
                    })
                    .catch(error => {
                        reject(error.response)
                    })
            })
        },

        GET_USERS: ({commit}) => {

            return new Promise((resolve, reject) => {
                axios.get(api.messageUser)
                    .then(({data}) => {
                        commit('SET_USERS', data)
                        resolve(true)
                    })
                    .catch(error => {
                        reject(error.response)
                    })
            })
        },

        /* For the Admin */
        GET_CATEGORIES: ({commit})=> {
            
            return new Promise((resolve, reject) => {
                axios.get(api.categories)
                    .then(({data}) => {
                        commit('SET_CATEGORIES', data)
                        resolve(true)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        ADD_CATEGORY: ({commit}, payload) => {
            return new Promise((resolve, reject) => {
                axios.post(api.categories, payload)
                    .then(() => {
                        resolve(true)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        UPDATE_CATEGORY: ({commit}, payload) => {
            
            return new Promise((resolve, reject) => {
                axios.put(api.categories + '/' + payload.id, payload)
                    .then(() => {
                        resolve(true)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        DELETE_CATEGORY: ({commit}, payload) => {
           
            return new Promise((resolve, reject) => {
                axios.delete(api.categories + '/' + payload)
                    .then(() => {
                        resolve(true)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        ADD_PRODUCT: ({commit}, payload) => {

            return new Promise((resolve, reject) => {
                axios.post(api.products, payload)
                    .then(() => {
                        resolve(true)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        UPDATE_PRODUCT: ({commit}, payload) => {

            return new Promise((resolve, reject) => {
                axios.put(api.products + '/' + payload.id, payload)
                    .then(() => {
                        resolve(true)
                    })
                    .catch(error => {
                        reject(error.response)
                    })
            })
        },

        DELETE_PRODUCT: ({commit}, payload) => {
            
            return new Promise((resolve, reject) => {
                axios.delete(api.products + '/' + payload)
                    .then(() => {
                        resolve(true)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        GET_SPECS: ({commit}, payload) => {

            return new Promise((resolve, reject) => {
                axios.get(api.specs + '/' + payload)
                    .then(({data}) => {
                        commit('SET_SPECS', data)
                        resolve(true)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        GET_ALL_FEEDBACKS: ({commit}) => {

            return new Promise((resolve, reject) => {
                axios.get(api.feedbacks)
                    .then(({data}) => {
                        commit('SET_ALL_FEEDBACKS', data)
                        resolve(true)
                    })
                    .catch(({response}) => {
                        reject(response)
                    })
            })
        }
    }
})