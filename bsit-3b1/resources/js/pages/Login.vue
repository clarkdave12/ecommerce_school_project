<template>
    <div class="container mt-2">
        <div class="row mt-5">
            <div class="col-lg-3"></div>

            <div class="form-group pl-2 pr-3 py-3 col-lg-6 col-sm-12" id="box">
                <div class="mb-3">
                    <header>Login</header>
                </div>
                <form @submit.prevent="login()">
                    <div class="mb-5">
                        <input placeholder="Email Address" type="text" class="inp" v-model="user.email">
                        <span class="error" v-if="errorMessage"> {{ errorMessage }} </span>
                    </div>

                    <input placeholder="Password" type="password" class="inp mb-5" v-model="user.password">

                    <div class="row">
                        <div class="col-lg-4 col-sm-12">
                            <button type="submit" class="btn btn-success" id="mybtn">Login</button>
                        </div>
                    </div>
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

    mounted () {

        bus.$on('login', () => {
            axios.get(userURL, {headers: getHeader()})
            .then(response => {
                this.getUserRole(response.data.id)
            })
            .catch(error => {
                console.log(response)              
            })
        })
    },

    methods: {

        login() {

            var data = {
                client_id: 2,
                client_secret: 'R7wCkSwzME4gyI9OnbbEdTIPQ0uv6e3bfVnB7SXr',
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
                    
                   bus.$emit('login')
                   
                })
                .catch(error => {
                    this.errorMessage = 'The Email or Password is incorrect'
                })
        },

        getUserRole (id) {
            axios.get(userRoleURL + '/' + id)
                .then(response => {
                    if(response.data == 'Admin') {
                        this.$router.push('/admin')
                    }
                    else if(response.data == 'User') {
                        this.$router.push('/products')
                    }
                })
                .catch(error => {
                    console.log(error)
                })
        }
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