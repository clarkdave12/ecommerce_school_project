<template>
    <div class="container">
        <h1>Login</h1>

        <div class="form-group">
            <form @submit.prevent="login()">
                <label>Email</label>
                <input type="text" class="form-control" v-model="user.email">

                <label>Password</label>
                <input type="password" class="form-control" v-model="user.password">

                <button type="submit" class="btn btn-success mt-3">Login</button>
            </form>
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
            }
        }
    },

    methods: {
        login() {

            console.log(this.user)

            var data = {
                client_id: 2,
                client_secret: 'yZlNOqJcI0wdZeX9rOkGPNCKWkunt2G6ChqSVutw',
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
                                    if('User' == response.data) {
                                        this.$router.push('/home')
                                    }
                                    else if('Admin' == response.data) {
                                        this.$router.push('/admin')
                                    }
                                })
                                .catch(error => {
                                    console.log(error)
                                })
                        })
                })
                .catch(error => {
                    console.log(error)
                })
        },


    }
    
}
</script>