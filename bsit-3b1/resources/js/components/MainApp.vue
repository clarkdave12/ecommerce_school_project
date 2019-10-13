<template>
    <div>
        <Navbar />
        <router-view></router-view>
    </div>
</template>

<script>

import Navbar from './inc/Navbar.vue'

    export default {
        components: {
            Navbar,
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
