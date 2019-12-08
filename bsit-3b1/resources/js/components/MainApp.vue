<template>
    <v-app id="bg" dark>
        <Navbar />

        <v-content id="content">
            <div class="container-fluid">
                <router-view></router-view>
                <loader></loader>
            </div>
        </v-content>
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
        var channel = Echo.channel('my-channel');
                    channel.listen('.TestEvent', (data) => {
                    alert(JSON.stringify(data));
                    });

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
        /* background: url('../img/metal-bg.jpg'); */
        background: #808080;
        min-height: 100vh;
    }

    #content {
        margin-top: 70px;
    }

</style>
