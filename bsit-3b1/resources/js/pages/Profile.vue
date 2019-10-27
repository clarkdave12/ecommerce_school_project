<template>
    <v-container>
            <!-- User Profile Information -->
            <v-layout column align-center>
                <v-flex>
                    <v-avatar size="100">
                        <img src="http://localhost:8000/images/monitor.jpeg" alt="profile">
                    </v-avatar>
                </v-flex>
                <v-flex>
                    <div class="mt-3" id="profile-name-container"> <h4 id="profile-name"> {{ userProfile.first_name }} {{ userProfile.last_name }} </h4> </div>
                </v-flex>
                <v-flex> <header> {{ userProfile.email }} </header> </v-flex>
                <v-flex>
                    <div> <p> {{ userProfile.address }} </p> </div>
                </v-flex>
            </v-layout>

            <v-footer fixed dark>
                <v-btn block dark color="primary" @click="profileUpdating = true"> update profile </v-btn>
            </v-footer>

            <!-- Update Profile Info Modal -->
            <v-dialog v-model="profileUpdating">
                <v-card dark>
                    <v-form @submit.prevent="updateProfile">
                        <v-card-title id="modal-title">Update Profile</v-card-title>

                        <v-card-text>
                            <v-text-field label="First Name"
                                            v-model="profileInfo.first_name"></v-text-field>

                            <v-text-field label="Last Name"
                                            v-model="profileInfo.last_name"></v-text-field>

                            <v-text-field label="Address"
                                            v-model="profileInfo.address"></v-text-field>

                            <v-text-field label="Email"
                                            v-model="profileInfo.email"></v-text-field>
                        </v-card-text>

                        <v-card-actions>
                            <v-btn text color="error" @click="profileUpdating = false">Cancel</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn color="success" type="submit">Update</v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card>
            </v-dialog>
    </v-container>
</template>


<script>
export default {

    data () {
        return {
            profileUpdating: false,
            profileInfo: {}
        }
    },

    computed: {
        userProfile() {
            return this.$store.state.profile
        }
    },

    created () {
        this.$store.dispatch('GET_PROFILE', this.$route.params.user_id)
            .then(() => {
                this.profileInfo = this.userProfile
            })
            .catch(error => {
                console.log(error)
            })
        
    },

    methods: {
        getUserProfile () {
            axios.get(userProfileURL + '/' + this.$route.params.user_id)
                .then(response => {
                    this.userProfile = response.data.profile[0]
                    
                })
                .catch(error => {
                    this.hasProfile = false
                })
        },

        updateProfile() {
            const data = {
                user_id: this.$route.params.user_id,
                first_name: this.profileInfo.first_name,
                last_name: this.profileInfo.last_name,
                address: this.profileInfo.address,
                email: this.profileInfo.email
            }

            this.$store.dispatch('UPDATE_PROFILE', data)
                .then(() => {
                    this.profileUpdating = false
                })
        }

    }
}
</script>

<style scoped>

    * {
        color: #ffffff;
    }

    #profile-name-container h4 {
        justify-content: center;
        font-family: 'batmfa';
        font-size: 1.3em;
    }

    #modal-title {
        font-family: 'batmfa';
    }

</style>