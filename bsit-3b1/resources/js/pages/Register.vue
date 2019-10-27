<template>
    <div>
        <v-container>
            <h3 class="subheading" id="page-title">
                register
            </h3>
            <v-divider></v-divider>

            <v-form @submit.prevent="register()">
                <v-text-field dark v-model="user.first_name" label="First Name" color="red" prepend-icon="perm_identity"></v-text-field>
                <span v-if="errors.first_name" class="errors"> {{ errors.first_name[0] }} </span> <br>
                
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
                <span v-if="confirmError" class="errors"> {{ confirmError[0] }} </span> <br>

                <v-btn block color="primary" type="submit"> Register </v-btn>
            </v-form>
        </v-container>
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

v-form {
    color: white;
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