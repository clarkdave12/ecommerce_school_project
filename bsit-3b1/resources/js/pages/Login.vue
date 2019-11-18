<template>
    <v-container>
            <div class="row">
                <v-spacer></v-spacer>
                <div class="col-sm-12 col-md-6 col-lg-">
                    <h3 class="subheading" id="page-title">Login </h3>
                    <br>
                     <v-form @submit.prevent="logins()">
                        <v-text-field prepend-icon="email" label="Email" dark v-model="user.email"></v-text-field>
                        <span class="error" v-if="errorMessage"> {{ errorMessage }} <br> </span>
                        <v-text-field prepend-icon="lock" label="Password" dark v-model="user.password" type="password"></v-text-field>
                        <br>
                        <div class="row">
                            <v-spacer></v-spacer>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <v-btn block color="primary" type="submit">Login</v-btn>
                            </div>
                            <v-spacer></v-spacer>
                        </div>
                    </v-form>
                    <div class="row">
                        <v-spacer></v-spacer>
                        <div class="col-sm-12 col-md-6 col-lg-6" id="link">
                            <router-link to="/register">Don't have an account?</router-link>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 links">
                            <router-link to="/forgot_password">Forgot Password?</router-link>
                        </div>
                        <v-spacer></v-spacer>
                    </div>
                </div>
                <v-spacer></v-spacer>
            </div>

    </v-container>
</template>

<script>
export default {
    data () {
        return {
            user: {
                email: '',
                password: ''
            },
            errorMessage: ''
        }
    },

    methods: {

        logins() {
            var data = {
                client_id: 2,
                client_secret: 'qCcqqT9MNWGgIpkMeC8XOdq8BQMTwIekpOcAubQX',
                grant_type: 'password',
                username: this.user.email,
                password: this.user.password
            }

            this.$store.dispatch('LOGIN', data)
                .then(response => {
                    localStorage.setItem('token', this.$store.state.token.access_token)

                    this.$store.dispatch('USER_DATA')
                        .then(() => {
                            if(this.$store.state.user.role == 'Admin') {
                                console.log(this.$store.state.user.role)
                                bus.$emit('login')
                                this.$router.replace('/admin')
                            }
                            else if(this.$store.state.user.role == 'User') {
                                console.log(this.$store.state.user.role)
                                bus.$emit('login')
                                this.$router.replace('/products')
                            }
                        })
                        .catch(error => {
                            console.log(error)
                        })

                })
                .catch(error => {
                    console.log(error)
                })
        },
    }
    
}
</script>

<style scoped>

#link {
    text-align: center;
}

#box {
    border: 3px #800000 solid;
    background: #000000;
}

#page-title {
    font-family: 'batmfa';
    color: #ffffff;
    font-size: 1.8em;
}

input {
    color: red;
    font-weight: 300;
    font-size: 1em;
    letter-spacing: 1px;
    background: #000000;
    border: none;
    min-width: 100%;
    border-bottom: 2px solid #800000;
}

input:focus {
    color: red;
    outline: none;
    background: #000000;
    border: #000000;
    border-bottom: 2px solid #800000;
}

.error {
    color: #f0e130;
}

#mybtn {
    width: 100%;
}

</style>