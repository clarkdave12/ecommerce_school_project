<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-3"></div>

            <div class="form-group px-5 py-3 col-lg-6" id="box">
                <div class="mb-3">
                    <header>Login</header>
                </div>
                <form @submit.prevent="login()">
                    <div class="mb-5">
                        <input placeholder="Email Address" type="text" class="inp" v-model="user.email">
                        <span class="error" v-if="errorMessage"> {{ errorMessage }} </span>
                    </div>

                    <input placeholder="Password" type="password" class="inp mb-5" v-model="user.password">

                    <button type="submit" class="btn btn-success">Login</button>
                </form>
            </div>

            <div class="col-lg-3"></div>
        </div>
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
        login() {

            console.log(this.user)

            var data = {
                client_id: 2,
                client_secret: 'R7wCkSwzME4gyI9OnbbEdTIPQ0uv6e3bfVnB7SXr',
                grant_type: 'password',
                username: this.user.email,
                password: this.user.password
            }

            axios.post(loginURL, data)
                .then(response => {
                    window.localStorage.setItem('token', response.data.access_token)
                    
                    axios.get(userURL, {headers: getHeader()})
                        .then(response => {
                            window.localStorage.setItem('id', response.data.id)
                            window.localStorage.setItem('name', response.data.first_name + ' ' + response.data.last_name)
                            window.localStorage.setItem('address', response.data.address)
                            window.localStorage.setItem('email', response.data.email)

                            axios.get(userRoleURL + '/' + window.localStorage.getItem('id'))
                                .then(response => {
                                    bus.$emit('login')
                                    if('User' == response.data) {
                                        window.localStorage.setItem('role', response.data)
                                        this.$router.push('/products')
                                    }
                                    else if('Admin' == response.data) {
                                        window.localStorage.setItem('role', response.data)
                                        this.$router.push('/admin')
                                    }
                                })
                                .catch(error => {
                                    console.log(error)
                                })
                        })
                })
                .catch(error => {
                    this.errorMessage = 'The Email or Password is incorrect'
                })
        },


    }
    
}
</script>

<style scoped>

#box {
    border: 3px #800000 solid;
    background: #000000;
}

header {
    font-family: 'batmfa';
    color: red;
    font-size: 2.5em;
    letter-spacing: 10px;
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

</style>