<template>
    <nav class="navbar navbar-light navbar-expand-lg py-2 px-3">
        <router-link to="/" class="navbar-brand mr-3" id="brand-name"> pctech </router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#content">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="content">
            <ul class="navbar-nav mr-auto" v-if="!isAdmin">
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

            <ul class="navbar-nav mr-auto" v-if="isAdmin">
                <!-- Admin Controls -->
                <li class="nav-item py-2">
                    <router-link to="/admin/categories" class="nav-link js-scroll-trigger" id="link"> Categories </router-link>
                </li>
                <li class="nav-item py-2">
                    <router-link to="/admin/users" class="nav-link js-scroll-trigger" id="link"> Users </router-link>
                </li>
                <li class="nav-item py-2">
                    <router-link to="/admin/products" class="nav-link js-scroll-trigger" id="link"> Products </router-link>
                </li>
                <li class="nav-item py-2">
                    <router-link to="/admin/products/add" class="nav-link js-scroll-trigger" id="link"> Add Product </router-link>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto" v-if="!isAuth">
                <li class="nav-item mr-3 py-2">
                    <router-link to="/register" class="nav-link js-scroll-trigger">Register</router-link>
                </li>
                <li class="nav-item mr-3 py-2">
                    <router-link to="/login" class="nav-link js-scroll-trigger">Login</router-link>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto" v-if="isAuth">
                <li v-if="! isAdmin" class="nav-item mr-3 py-2">
                    <router-link :to="'/profile/' + user_id" class="nav-link js-scroll-trigger">Profile</router-link>
                </li>
                <li v-if="! isAdmin" class="nav-item mr-3 py-2">
                    <router-link to="/cart" class="nav-link js-scroll-trigger">Cart</router-link>
                </li>
                <li v-if="isAdmin && name" class="nav-item py-2">
                    <a href="" class="nav-link js-scroll-trigger"> {{ name }} </a>
                </li>
                <li class="nav-item py-2">
                    <button @click="logout()" class="btn nav-link js-scroll-trigger">Logout</button>
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
            token: '',
            name: '',
            user_id: ''
        }
    },

    mounted () {

            if(isAuthenticated()) {
                this.isAuth = true
                this.getUserRole()
            }
            else {
                this.isAuth = false
            }

            

        bus.$on('login', () => {
            this.isAuth = true
            this.getUserRole()
        })

        bus.$on('logout', () => {
            axios.get(userURL, {headers: getHeader()})
            .then(response => {
                this.isAuth = true
            })
            .catch(error => {
                this.isAuth = false
            }) 
        })
    },
    
    methods: {
        
        getUserRole() {
            axios.get(userURL, {headers: getHeader()})
                .then(response => {
                    this.isAuth = true
                    this.name = response.data.last_name + ', ' + response.data.first_name
                    this.user_id = response.data.id
                    
                    axios.get(userRoleURL + '/' + response.data.id)
                        .then(response => {
                            if(response.data == 'User') {
                                this.isAdmin = false
                            }
                            else if(response.data == 'Admin') {
                                this.isAdmin = true
                            }
                        })
                        .catch(error => {
                            this.isAuth = false
                        })
                })
                .catch(error => {
                    this.isAuth = false
                })
        },

        logout() {
            
            const d = new Date()
            d.setTime(d.getTime() + (-1 * 24 * 60 * 60 * 1000));
            const expires = d.toUTCString();

            document.cookie = 'access_token=;expires=' + expires;
            bus.$emit('logout')
            this.$router.push('/login')
        },
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