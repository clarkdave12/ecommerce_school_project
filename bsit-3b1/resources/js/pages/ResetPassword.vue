<template>
    <v-container>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <h2>Change Password</h2>
                <v-text-field type="password" v-model="password"></v-text-field>
                <v-text-field type="password" v-model="passwordAgain"></v-text-field>
                <v-btn color="primary" @click="resetPassword()">Reset</v-btn>
            </div>
        </div>
    </v-container>
</template>

<script>
export default {
    data () {
        return {
            email: '',
            password: '',
            passwordAgain: ''
        }
    },

    created () {
        
    },

    methods: {
        validateEmail() {

            const data = {
                email: window.localStorage.getItem('email'),
                code: window.localStorage.getItem('code')
            }

            axios.post('http://localhost:8000/api/verify_code', data)
                .then(response => {
                    this.email = data.email
                })
                .catch(error => {
                    console.log(error.response)
                    this.$router.push('/forgot_password')
                })
        },

        resetPassword() {
            if(this.email == '') {
                this.$router.push('/forgot_password')
            }

            const data = {
                email: this.email,
                password: this.password
            }

            if(this.password == this.passwordAgain) {

                axios.post('http://localhost:8000/api/reset_password', data)
                    .then(response => {
                        alert(response.data.success)
                    })
                    .catch(error => {
                        if(error.response.status == 401) {
                            alert(error.response.data.error)
                        }
                    })
            }
            else {
                alert('Passwords do not match');
            }
        }
    }
}
</script>