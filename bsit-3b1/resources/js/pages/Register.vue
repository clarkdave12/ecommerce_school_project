<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-2"></div>

                <div class="form-group px-5 py-3 col-lg-8" id="box">
                <div class="mb-5">
                    <header>Create new Account</header>
                </div>
                    <form @submit.prevent="register()">
                        <div class="mb-5">
                            <input placeholder="First Name" type="text" v-model="user.first_name">
                            <span class="errors" v-if="errors.first_name"> {{ errors.first_name[0] }} </span>
                        </div>

                        <div class="mb-5">
                            <input placeholder="Last Name" type="text" v-model="user.last_name">
                            <span class="errors" v-if="errors.last_name"> {{ errors.last_name[0] }} </span>
                        </div>

                        <div class="mb-5">
                            <textarea placeholder="Address" rows="2" v-model="user.address"></textarea>
                            <span class="errors" v-if="errors.address"> {{ errors.address[0] }} </span>
                        </div>
   
                        <div class="mb-5">
                            <input placeholder="Email" type="text" v-model="user.email">
                            <span class="errors" v-if="errors.email"> {{ errors.email[0] }} </span>
                        </div>

                        <div class="mb-5">
                            <input placeholder="Password" type="password" v-model="user.password">
                            <span class="errors" v-if="errors.password"> {{ errors.password[0] }} </span>
                        </div>

                        <div class="mb-5">
                            <input placeholder="Confirm Password" type="password" v-model="confirmPassword">
                            <span class="confirmError" v-if="confirmError"> {{ confirmError }} </span>
                        </div>

                        <button type="submit" class="btn btn-primary mb-3">Register</button>
                    </form>
                </div>
            <div class="col-lg-2"></div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            user: {
                first_name: '',
                last_name: '',
                address: '',
                email: '',
                password: ''
            },
            confirmPassword: '',
            errors: {},
            confirmError: ''
        }
    },

    methods: {
        register () {
            axios.post(registerURL, this.user)
                .then(response => {
                    this.$router.push('/login')
                })
                .catch(error => {
                    this.errors = error.response.data.errors
                    console.log(this.errors)
                })
        }
    }
}
</script>

<style scoped>

@font-face {
    font-family: 'batmfa';
    src: url('../fonts/batmfa.ttf');
}

#box {
    max-width: 60%;
    background: #000000;
    border: 3px red solid;
}

label {
    color: #ffffff;
    font-weight: 500;
    font-size: 1.1em;
    letter-spacing: 1px;
}

header {
    font-family: 'batmfo';
    color: red;
    font-weight: 600;
    font-size: 1.8em;
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
    border-bottom: 2px solid #323334;
}
input:focus {
    color: red;
    outline: none;
    background: #000000;
    border: #000000;
    border-bottom: 2px solid #800000;
}

textarea {
    color: red;
    font-weight: 300;
    font-size: 1em;
    letter-spacing: 1px;
    background: #000000;
    border: none;
    min-width: 100%;
    border-bottom: 2px solid #323334;
}

textarea:focus {
    color: red;
    outline: none;
    background: #000000;
    border: #000000;
    border-bottom: 2px solid #800000;
}

.errors {
    color: #f0e130;
}

</style>