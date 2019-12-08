<template>
    <div>
        <v-btn @click="checkPassword = !checkPassword" color="error" small class="px-2">
            <span>Change</span>
        </v-btn>

        <v-dialog v-model="checkPassword" dark max-width="400">
            <v-card dark class="px-3 py-3">
                <span>
                    <h2>Enter Password</h2>
                </span>
                <div class="my-4">
                    <v-card-text>
                        <v-text-field label="Password" type="password" v-model="password"></v-text-field>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn @click="confirmPassword()" color="primary">
                            Done
                        </v-btn>
                    </v-card-actions>
                </div>
            </v-card>
        </v-dialog>

        <v-dialog v-model="passwordChange" dark max-width="400">
            <v-card dark class="px-3 py-3">
                <span>
                    <h2>Change Password</h2>
                </span>
                <div class="my-4"></div>
                <v-card-text>
                    <v-text-field v-model="cred.pass" dark type="password" label="New Password"></v-text-field>
                    <v-text-field v-model="cred.pass2" dark type="password" label="Confirm Password"></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="changePassword" color="primary">Change Password</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props: ['user'],
    data () {
        return {
            checkPassword: false,
            passwordChange: false,
            password: '',
            cred: {
                pass: '',
                pass2: ''
            }
        }
    },

    methods: {
        confirmPassword() {
            const data = {
                client_id: 2,
                client_secret: 'qCcqqT9MNWGgIpkMeC8XOdq8BQMTwIekpOcAubQX',
                grant_type: 'password',
                username: this.user.email,
                password: this.password
            }

            axios.post(api.login, data)
                .then(response => {
                    this.checkPassword = false
                    this.passwordChange = true

                })
                .catch(error => {
                    if(error.response.status == 401) {
                        alert('Invalid Password')
                    }
                })
        },

        changePassword() {
            const data = {
                id: this.user.id,
                password: this.cred.pass
            }

            if(this.cred.pass == this.cred.pass2) {
                axios.post(api.change_password, data)
                    .then(response => {
                        alert(response.data.success)
                        this.passwordChange = false
                        this.checkPassword = false
                    })
                    .catch(error => {
                        if(error.response.status == 422) {
                            console.log(error.response)
                            alert(error.response.data.errors.password[0])
                        }
                    })
            }
            else {
                alert('Password do not match')
            }
        }
    }
}
</script>