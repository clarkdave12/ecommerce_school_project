<template>
    <nav class="navbar navbar-light navbar-expand-lg py-2 px-3">
        <router-link to="/" class="navbar-brand mr-3" id="brand-name"> pctech </router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#content">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="content">
            <ul class="navbar-nav mr-auto" v-if="isAdmin === false">
                <li class="nav-item py-2">
                    <router-link to="/products" class="nav-link js-scroll-trigger"> Products </router-link>
                </li>
                <li class="nav-item py-2">
                    <a href="" class="nav-link js-scroll-trigger">Contact Us</a>
                </li>
                <li class="nav-item py-2">
                    <a href="" class="nav-link js-scroll-trigger">About Us</a>
                </li>
            </ul>

            <ul class="navbar-nav mr-auto" v-if="isAdmin === true">
                <!-- Admin Controls -->
                <li class="nav-item py-2">
                    <router-link to="/admin/categories" class="nav-link js-scroll-trigger" id="link"> Categories </router-link>
                </li>
                <!-- <li class="nav-item py-2">
                    <router-link to="/admin/users" class="nav-link js-scroll-trigger" id="link"> Users </router-link>
                </li> -->
                <li class="nav-item py-2">
                    <router-link to="/admin/manage_feedbacks" class="nav-link js-scroll-trigger" id="link"> Feedbacks </router-link>
                </li>
                <li class="nav-item py-2">
                    <router-link to="/admin/products" class="nav-link js-scroll-trigger" id="link"> Products </router-link>
                </li>
                <li class="nav-item py-2">
                    <router-link to="/admin/products/add" class="nav-link js-scroll-trigger" id="link"> Add Product </router-link>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto" v-if="isAuth === false">
                <li class="nav-item mr-3 py-2">
                    <router-link to="/register" class="nav-link js-scroll-trigger">Register</router-link>
                </li>
                <li class="nav-item mr-3 py-2">
                    <router-link to="/login" class="nav-link js-scroll-trigger">Login</router-link>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto" v-if="isAuth === true">
                <li v-if="! isAdmin" class="nav-item mr-3 py-2">
                    <router-link :to="'/profile/' + user_id" class="nav-link js-scroll-trigger">Profile</router-link>
                </li>
                <li v-if="! isAdmin" class="nav-item mr-3 py-2">
                    <router-link :to="'/user_feedback/' + user_id" class="nav-link js-scroll-trigger">Feedbacks</router-link>
                </li>
                <li v-if="! isAdmin" class="nav-item mr-3 py-2">
                    <router-link :to="'/cart/' + user_id" class="nav-link js-scroll-trigger">Cart</router-link>
                </li>
                <li v-if="isAdmin && name" class="nav-item py-2">
                    <a href="" class="nav-link js-scroll-trigger"> {{ name }} </a>
                </li>
                <li class="nav-item py-2">
                    <a @click="logout()" class="nav-link js-scroll-trigger" role="button">Logout</a>
                    <!-- <button @click="logout()" class="btn nav-link js-scroll-trigger">Logout</button> -->
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
export default {
    data () {
        return {
            isAuth: false,
            isAdmin: false,
            user_id: ''
            
        }
    },

    computed: {
        name() {
            return this.$store.state.user.name
        }
    },
    
    created () {
        this.setUser()

        bus.$on('login', () => {
            this.setUser()
        })

        bus.$on('logout', () => {
            this.isAuth = false
            this.isAdmin = false
            this.$router.push('/login')
        })
    },

    methods: {

        setUser() {
            if(localStorage.getItem('token')) {
                
                this.$store.dispatch('USER_DATA')
                    .then(() => {
                        
                        if(this.$store.state.user.role == 'Admin') {
                            this.isAuth = true
                            this.isAdmin = true
                            this.user_id = this.$store.state.user.id
                        }
                        else if(this.$store.state.user.role == 'User') {
                            this.isAuth = true
                            this.isAdmin = false
                            this.user_id = this.$store.state.user.id
                        }
                        else {
                            this.isAuth = false
                            this.isAdmin = false
                        }
                    })
            }
        },

        logout() {
            localStorage.removeItem('token')
            bus.$emit('logout')
        }
    }
}
</script>

<style scoped>
    nav {
        border-bottom: 1px white solid;
    }

    #b {
        margin-top: 20px;
    }

    #brand-name {
        color: red;
        font-weight: 900;
        font-size: 2em;
        font-family: 'batmfa';
    }

    .navbar-nav .nav-item .nav-link {
        color: #aaaaaa;
        text-transform: uppercase;
        font-size: .8em;

    }

    .navbar-nav .nav-item .nav-link:hover {
        background: #ffffff;
        color: #000000;
    }

</style>