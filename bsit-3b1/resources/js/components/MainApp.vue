<template>
    <v-app id="bg">
        <Navbar />

        <v-container fluid>
            <router-view></router-view>
            <loader></loader>
        </v-container>
    </v-app>
</template>

<script>

import Navbar from './inc/Navbar.vue'
import loader from './inc/Loader.vue'

export default {
    components: {
        Navbar,
        loader,
    },

    created () {
        /* axios.interceptors.request.use(config => {
            
            this.$store.commit('SET_LOADER', true)
            return config
        }, error => {
            return Promise.reject(error)
        });

        axios.interceptors.response.use(response => {
            this.$store.commit('SET_LOADER', false)
            return response
        }, error => {
            return Promise.reject(error)
        }) */
    },
}
</script>

<style>

    
    @font-face {
        font-family: 'batmfa';
        src: url('../fonts/batmfa.ttf');
    }

    @font-face {
        font-family: 'batmfo';
        src: url('../fonts/batmfo.ttf');
    }

    #bg {
        background: url('../img/metal-bg.jpg');
        min-height: 100vh;
    }

</style>
