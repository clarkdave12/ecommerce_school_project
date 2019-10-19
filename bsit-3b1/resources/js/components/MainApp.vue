<template>
    <div class="container-fluid" id="bg">
        <Navbar />
        <router-view></router-view>
    </div>
</template>

<script>

import Navbar from './inc/Navbar.vue'

export default {
    components: {
        Navbar,
    }
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
