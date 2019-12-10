<template>
    <v-container>
        <div class="row">
            <v-spacer></v-spacer>
            <div class="col-sm-12 col-md-6 col-lg-5">
                <h2>Reset Password</h2>
                <v-text-field dark v-model="email" label="Email"></v-text-field>
                <v-btn @click="sendCode()" color="primary">Send Reset Code</v-btn>
            </div>
            <v-spacer></v-spacer>
        </div>

        <div v-if="hasCode" class="row">
            <div class="col-sm-12">
                <h2>Enter Code</h2>
                <v-text-field dark v-model="code" label="Code"></v-text-field>
                <v-btn color="primary" @click="verifyCode()">Verify Code</v-btn>
            </div>
        </div>
    </v-container>
</template>

<script>
export default {
    data () {
        return {
            email: '',
            code: '',
            hasCode: false
        }
    },

    methods: {
        sendCode() {
            const data = {
                email: this.email
            }
            axios.post('http://bsupctech.epizy.com/api/send_code', data)
                .then(() => {
                    this.hasCode = true
                })
                .catch(error => {
                    
                    if(error.response.status == 422) {
                        alert(error.response.data.errors.email[0])
                    }

                    if(error.response.status == 401) {
                        alert(error.response.data.error)
                    }
                })
        },

        verifyCode() {
            const data = {
                email: this.email,
                code: this.code
            }

            axios.post('http://bsupctech.epizy.com/api/verify_code', data)
                .then(() => {
                    window.localStorage.setItem('email', data.email)
                    window.localStorage.setItem('code', data.code)
                    this.$router.push('/reset_password')
                })
                .catch(error => {
                    console.log(error.response)
                })
        }
    }
}
</script>

<style scoped>
* {
    color: white;
}
</style>