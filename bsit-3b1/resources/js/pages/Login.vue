<template>
    <div>
        <v-container>
            <h3 class="subheading" id="page-title">
                Login
            </h3>
            <v-divider></v-divider>

            <v-form @submit.prevent="logins()">
                <v-text-field prepend-icon="email" label="Email" dark v-model="user.email"></v-text-field>
                <span class="error" v-if="errorMessage"> {{ errorMessage }} <br> </span>
                <v-text-field prepend-icon="lock" label="Password" dark v-model="user.password" type="password"></v-text-field>
                <br>
                <v-btn block color="primary" type="submit">Login</v-btn>
            </v-form>
        </v-container>
    </div>
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
                client_secret: 'gGqpMfwbKE7qW3nUuheNxku9Nr0FgAhlSW1dhukD',
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

        /* login() {

            var data = {
                client_id: 2,
                client_secret: 'gGqpMfwbKE7qW3nUuheNxku9Nr0FgAhlSW1dhukD',
                grant_type: 'password',
                username: this.user.email,
                password: this.user.password
            }

            axios.post(loginURL, data)
                .then(response => {
                   
                   const access_token = response.data.access_token;
                   const expires_in = response.data.expires_in;
                   const d = new Date();
                   d.setTime(d.getTime() + (200 * 24 * 60 * 60 * 1000));
                   const expires = d.toUTCString();

                   document.cookie = 'access_token=' + access_token + ';' + 'expires=' + expires + ';path=/';
                   
                   axios.get(userURL, {headers: getHeader()})
                        .then(response => {
                            axios.get(userRoleURL + '/' + response.data.id)
                                    .then(response => {
                                        if(response.data == 'Admin') {
                                            this.$router.replace('/admin')
                                        }
                                        else if(response.data == 'User') {
                                            this.$router.replace('/products')
                                        }
                                        bus.$emit('login')
                                    })
                                    .catch(error => {
                                        console.log(error)
                                    })
                        })
                        .catch(error => {
                            console.log(response)              
                        })
                   
                })
                .catch(error => {
                    this.errorMessage = 'The Email or Password is incorrect'
                })
        }, */

        getUserRole (id) {
            
        }
    }
    
}
</script>

<style scoped>

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