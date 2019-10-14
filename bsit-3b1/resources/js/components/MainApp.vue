<template>
    <div>
        <div v-if="! isAdmin">
            <Navbar />
        </div>

        <div v-if="isAdmin">
            <adminNavbar />
        </div>

        <router-view></router-view>
    </div>
</template>

<script>

import Navbar from './inc/Navbar.vue'
import adminNavbar from '../admin/AdminNavbar.vue'

export default {
    components: {
        Navbar,
        adminNavbar
    },

    data () {
        return {
            isAdmin: true,
        }
    },

    mounted() {
        console.log('Component mounted.')
    }
}
</script>
