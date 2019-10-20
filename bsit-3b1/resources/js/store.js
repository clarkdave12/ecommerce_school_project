import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import { getAccessToken, userRoleURL, getHeader, loginURL } from './api';
import { reject } from 'q';

Vue.use(Vuex);
window.axios = axios

export const store = new Vuex.Store({
    state: {
        token: '',
        user: [],

        isAuthenticatedUser: false,
        isUserAnAdmin: false
    },
    
    getters: {
        getToken: (state) => {
            return state.token
        }
    },

    mutations: {
        SET_TOKEN(state, token) {
            state.token = token
        }
    },

    actions: {
        login({commit}, data) {
            axios.post(loginURL, data)
                .then(response => {
                    const token = response.data.access_token
                    commit('SET_TOKEN', token)
                })
                .catch(error => {
                    console.log(error)
                })
        },

        setUserData({commit}) {
            const header = {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + this.getters.getToken
            }

            axios.get(userURL, {header: header})
                .then(response => {
                    console.log(response)
                })
                .catch(error => {
                    console.log(error.response)
                })
        }
    }

});