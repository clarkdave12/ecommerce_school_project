<template>
    <nav class="navbar navbar-light navbar-expand-lg">
        <router-link to="/" class="navbar-brand" id="brand-name"> pctech </router-link>

        <ul class="navbar-nav mr-auto">
            <li class="nav-item ml-3">
                <router-link to="/products" class="nav-link"> Products </router-link>
            </li>
            <li class="nav-item ml-3">
                <a href="" class="nav-link">Contact Us</a>
            </li>
            <li class="nav-item ml-3">
                <a href="" class="nav-link">About Us</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto" v-if="! isAuth">
            <li class="nav-item mr-3">
                <router-link to="/register" class="nav-link">Register</router-link>
            </li>
            <li class="nav-item mr-3">
                <router-link to="/login" class="nav-link">Login</router-link>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto" v-if="isAuth">
            <li v-if="! isAdmin" class="nav-item mr-3">
                <router-link to="/cart" class="nav-link">Cart</router-link>
            </li>
            <li v-if="isAdmin" class="nav-item">
                <a href="" class="nav-link">Name</a>
            </li>
            <li class="nav-item">
                <button @click="logout()" class="btn nav-link">Logout</button>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    data () {
        return {
            isAuth: false,
            isAdmin: false,
            token: ''
        }
    },

    mounted () {
        this.getToken()
        
        bus.$on('login', () => {
            this.getToken()
        })

        bus.$on('logout', () => {
            this.getToken()
            this.$router.push('/login')
        })
    },

    created () {
       bus.$on('login', () => {
            axios.get(userRoleURL + '/' + window.localStorage.getItem('id'))
                .then(response => {
                    if(response.data == 'Admin') {
                        this.isAdmin = true
                    }
                    else {
                        this.isAdmin = false
                    }
                })
                .catch(error => {
                    console.log(error)
                })
       })
    },
    
    methods: {
        getToken() {
            this.token = window.localStorage.getItem('token')
            if(this.token) {
                this.isAuth = true
            }
            else {
                this.isAuth = false
            }
        },

        getRole() {
            
        },

        logout() {
            window.localStorage.removeItem('token')
            window.localStorage.removeItem('id')
            window.localStorage.removeItem('name')
            window.localStorage.removeItem('address')
            window.localStorage.removeItem('email')
            window.localStorage.removeItem('role')

            bus.$emit('logout')
        }
    }
}
</script>

<style scoped>

    nav {
        padding: 20px 50px;
    }

    #b {
        margin-top: 20px;
    }

    #brand-name {
        color: red;
        font-weight: 900;
        font-size: 2.5em;
        font-family: 'batmfa';
        letter-spacing: 10px;
    }

    .navbar-nav .nav-item .nav-link {
        color: #aaaaaa;
        text-transform: uppercase;
    }

    .navbar-nav .nav-item .nav-link:hover {
        background: #ffffff;
        color: #000000;
    }

</style>