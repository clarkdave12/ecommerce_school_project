<template>
    <div>
        <v-app-bar :dark="darkMode" fixed>
            <!-- Humburger menu -->
            <v-btn icon @click="drawer = !drawer">
                <v-icon>menu</v-icon>
            </v-btn>

            <v-toolbar-title>
                <!-- <router-link id="brand-name" to="/" tag="span"></router-link> -->
                <img id="logo" class="hidden-md-and-down" src="http://bsupctech.epizy.com/images/logo.png" alt="">
                <img id="logomobile" class="hidden-sm-and-up" src="http://bsupctech.epizy.com/images/logo.png" alt="">
            </v-toolbar-title>

            <v-spacer></v-spacer>
            <!-- Authenticated User -->
            <v-btn v-if="isAuth" text @click="logout()" class="mx-3 hidden-sm-and-down">LOGOUT</v-btn>
            <!-- Guest -->
            <router-link to="/login" style="cursor: pointer" class="mx-3 hidden-sm-and-down" tag="span" v-if="!isAuth">LOGIN</router-link>
            <router-link to="/register" style="cursor: pointer" class="mx-3 hidden-sm-and-down" tag="span" v-if="!isAuth">REGISTER</router-link>
        </v-app-bar>


        <v-navigation-drawer temporary v-model="drawer" app dark>

            <v-layout column align-center v-if="isAuth">
                <v-flex class="mt-5">
                    <v-list-item-avatar size="80">
                        <img src="http://bsupctech.epizy.com/images/monitor.jpeg" alt="profile">
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

            <!-- PAYMENTS -->
            <v-list-item link to="/payments" v-if="isAuth && isAdmin">
                <v-list-item-icon>
                    <v-icon>payment</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>
                        Payments
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <!-- MESSAGING -->
            <v-list-item link to="/messages" v-if="isAuth">
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
            <!-- <v-list-item link to="/lexin" v-if="isAuth && !isAdmin">
                <v-list-item-icon>
                    <v-icon>android</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>
                        LEXIN
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item> -->

            <!-- BUILDER -->
            <!-- <v-list-item link to="/builder" v-if="isAuth && !isAdmin">
                <v-list-item-icon>
                    <v-icon>build</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>
                        Builder
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item> -->

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

            <!-- HISTORY -->
            <v-list-item link to="/history" v-if="isAuth && !isAdmin">
                <v-list-item-icon>
                    <v-icon>access_time</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>
                        History
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
                
                <v-btn block icon >
                    <iframe src="https://www.facebook.com/plugins/share_button.php?href=http%3A%2F%2Flocalhost%3A8000&layout=button&size=large&appId=463329024531110&width=73&height=28" width="73" height="28" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
                </v-btn>

                <div class="pa-2 mt-2">
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

    #logo {
        max-height: 50px;
    }

    #logomobile {
        max-height: 50px;
        width: 80%;
    }

    iframe {
        margin-left: 60px;
        align-items: center;
        width: 100%;
        height: 100%;
    }

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

    #brand-name2 {
        margin-left: 70px;
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

    #share-facebook {
        background: transparent;
    }

</style>