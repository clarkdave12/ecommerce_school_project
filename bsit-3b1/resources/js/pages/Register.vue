<template>
    <div class="container mt-2">
        <div class="row mt-5">
            <div class="col-lg-2 col-sm-0"></div>

                <div class="form-group pl-2 pr-3 py-3 col-lg-8 col-sm-12" id="box">
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
                            <span class="errors" v-if="confirmError"> {{ confirmError }} </span>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-sm-12">
                                <button type="submit" class="btn btn-primary mb-3" id="button-control">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            <div class="col-lg-2 col-sm-0"></div>
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
            if(this.user.password !== this.confirmPassword) {
                this.confirmError = 'The password do not matched'
            }
            else {
                this.confirmError = ''

                this.$store.dispatch('REGISTER', this.user)
                    .then(() => {
                        this.$router.push('/login')
                    })
                    .catch(error => {
                        console.log(error)
                        this.errors = error.errors
                    })
            }
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
    font-family: 'batmfa';
    color: #ffffff;
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

#button-control {
    width: 100%;
    justify-content: center;
    text-align: center;
}

</style>