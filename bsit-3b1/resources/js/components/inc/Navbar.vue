<template>
    <div>
        <v-app-bar :dark="darkMode">
            <v-toolbar-title>
                <router-link id="brand-name" to="/" tag="span">PCTECH</router-link>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn outlined x-small class="mx-3 hidden-sm-and-down">
                <router-link to="/products" tag="span" style="cursor: pointer">Products</router-link>
            </v-btn>

            <!-- Admin -->
            <v-btn v-if="isAuth && isAdmin" outlined x-small class="mx-3 hidden-sm-and-down">
                <router-link to="/admin/categories" tag="span" style="cursor: pointer">categories</router-link>
            </v-btn>

            <!-- User -->
            <v-btn v-if="isAuth && !isAdmin" outlined x-small class="mx-3 hidden-sm-and-down">
                <router-link :to="'/profile/' + user_id" tag="span" style="cursor: pointer">Profile</router-link>
            </v-btn>

            <!-- Guest -->
            <v-btn v-if="!isAuth" outlined x-small class="mx-3 hidden-sm-and-down">
                <router-link to="/login" tag="span" style="cursor: pointer">Login</router-link>
            </v-btn>

            <v-btn v-if="!isAuth" outlined x-small class="mx-3 hidden-sm-and-down">
                <router-link to="/register" tag="span" style="cursor: pointer">Register</router-link>
            </v-btn>

            <!-- Humburger menu -->
            <v-btn icon class="hidden-md-and-up" @click="drawer = !drawer">
                <v-icon>menu</v-icon>
            </v-btn>
        </v-app-bar>


        <v-navigation-drawer class="hidden-md-and-up" v-model="drawer" app dark>

            <v-layout column align-center v-if="isAuth">
                <v-flex class="mt-5">
                    <v-list-item-avatar size="80">
                        <img src="http://localhost:8000/images/monitor.jpeg" alt="profile">
                    </v-list-item-avatar>    

                    <p align-center class="white--text subheading mt-1">
                        Clark Dave Ibarreta
                    </p>

                    <v-btn rounded small @click="goToProfile" v-if="isAuth && !isAdmin">
                        view profile
                    </v-btn>

                    <v-btn rounded small to="/admin" v-if="isAuth && isAdmin">
                        Dashboard
                    </v-btn>
                </v-flex>
            </v-layout>
            <v-divider></v-divider>

            <!-- PRODUCTS -->
            <v-list-item link to="/products">
                <v-list-item-icon>
                    <v-icon>shop</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>
                        Products
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <!-- CATEGORY -->
            <v-list-item link to="/admin/categories" v-if="isAuth && isAdmin">
                <v-list-item-icon>
                    <v-icon>category</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>
                        Categories
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <!-- MESSAGING -->
            <v-list-item link :to="'/messages/' + user_id" v-if="isAuth && !isAdmin">
                <v-list-item-icon>
                    <v-icon>chat</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>
                        Message
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <!-- LEXIN -->
            <v-list-item link to="/lexin" v-if="isAuth && !isAdmin">
                <v-list-item-icon>
                    <v-icon>android</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>
                        LEXIN
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <!-- SHOPPING CART -->
            <v-list-item link :to="'/cart/' + user_id" v-if="isAuth && !isAdmin">
                <v-list-item-icon>
                    <v-icon>shopping_cart</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>
                        Cart
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <!-- LOGIN -->
            <v-list-item link to="/login" v-if="!isAuth">
                <v-list-item-icon>
                    <v-icon>account_circle</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>
                        Login
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <!-- REGISTER -->
            <v-list-item link to="/register" v-if="!isAuth">
                <v-list-item-icon>
                    <v-icon>how_to_reg</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>
                        Register
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <!-- LOGOUT -->
            <template v-slot:append v-if="isAuth">
                <div class="pa-2">
                    <v-btn block @click="logout()">Logout</v-btn>
                </div>
            </template>
        </v-navigation-drawer>
    </div>
</template>


<script>
export default {
    data () {
        return {
            isAuth: false,
            isAdmin: false,
            user_id: '',
            darkMode: true,
            drawer: false,
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

        goToProfile() {
            this.$router.push('/profile/' + this.user_id)
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
        font-size: 1.5em;
        font-family: 'batmfa';
        cursor: pointer;
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