<template>
    <v-container>
        <div class="row">
            <v-spacer></v-spacer>
            <div class="col-sm-12 col-md-8 col-lg-8">
                <h3 class="subheading" id="page-title">
                    register
                </h3>
                <br>
                <v-form @submit.prevent="register()">
                    <v-text-field dark v-model="user.first_name" label="First Name" color="red" prepend-icon="perm_identity"></v-text-field>
                    <span v-if="errors.first_name" class="errors"> {{ errors.first_name }} </span> <br>
                    
                    <v-text-field dark v-model="user.last_name" label="Last Name" color="red" prepend-icon="perm_identity"></v-text-field>
                    <span v-if="errors.last_name" class="errors"> {{ errors.last_name[0] }} </span> <br>
                    
                    <v-textarea dark v-model="user.address" label="Address" color="red" prepend-icon="place"></v-textarea>
                    <span v-if="errors.address" class="errors"> {{ errors.address[0] }} </span> <br>

                    <v-text-field dark v-model="user.email" label="Email" color="red" prepend-icon="email"></v-text-field>
                    <span v-if="errors.email" class="errors"> {{ errors.email[0] }} </span><br>

                    <v-text-field dark v-model="user.password" label="Password" color="red" prepend-icon="lock" type="password">
                    </v-text-field>
                    <span v-if="errors.password" class="errors"> {{ errors.password[0] }} </span> <br>

                    <v-text-field dark v-model="confirmPassword" label="Confirm Password" color="red" prepend-icon="lock" type="password">                    
                    </v-text-field>
                    <span v-if="confirmError" class="errors"> {{ confirmError[0] }} </span> <br> <br>

                    <!-- <vue-recaptcha ref="captcha" @verify="onVerify" sitekey="6Ld1ncAUAAAAAA6plTp_wHDP5bwIqehfUJZUBTjh"></vue-recaptcha> -->
                    <VueRecaptcha ref="captcha" @verify="onVerify" sitekey="6Ld1ncAUAAAAAA6plTp_wHDP5bwIqehfUJZUBTjh" :loadRecaptchaScript="true"></VueRecaptcha>
                    <div class="row">
                        <v-spacer></v-spacer>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <v-btn block color="primary" type="submit"> Register </v-btn>
                        </div>
                        <v-spacer></v-spacer>
                    </div>
                </v-form>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 links">
                        <router-link to="/login">Already have an account?</router-link>
                    </div>
                </div>
            </div>
            <v-spacer></v-spacer>
        </div>
    </v-container>
</template>

<script>

import VueRecaptcha from 'vue-recaptcha'

export default {

    components: {
        VueRecaptcha,
    },

    data () {
        return {
            user: {
                first_name: '',
                last_name: '',
                address: '',
                email: '',
                password: '',
                captchaToken: '',
            },
            app_key: process.env.MIX_RECAPTCHA_KEY,
            confirmPassword: '',
            errors: {},
            confirmError: ''
        }
    },

    methods: {

        onVerify(response) {
            this.user.captchaToken = response
        },

        register () {
        
            axios.post('http://bsupctech.epizy.com/api/validate', this.user)
                .then(({data}) => {
                    if(data.success) {
                        this.signup()
                    }
                    else {
                        alert('Please complete the ReCaptcha to verify that you are human')
                    }
                })
                .catch(error => {
                    console.log(error)
                })
        },

        signup() {

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
                        console.log(error.response)
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

v-form {
    color: white;
}

.links {
    text-align: center;
}

#captcha {
    height: 100%;
    width: 100%;
}

#page-title {
    font-family: 'batmfa';
    color: #ffffff;
    font-weight: 600;
    font-size: 1.8em;
    letter-spacing: 10px;
}

.errors {
    color: #f0e130;
}

</style>