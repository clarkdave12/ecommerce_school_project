<template>
    <div id="wrapper">
        <div class="row hidden-sm-and-down" id="header-box">
            <div>
                <v-avatar size="100px" class="ml-8 mt-5">
                    <img src="http://localhost:8000/images/monitor.jpeg" alt="">
                </v-avatar>
            </div>
            <div class="pt-8 ml-4">
                <h2 id="profile-name" class="mt-4">Clark Dave Ibarreta</h2>
            </div>
            <v-spacer></v-spacer>

            <div class="pt-8 mr-4">
                <v-btn class="mt-3" x-large icon dark to="/change_profile">
                    <v-icon>settings</v-icon>
                </v-btn>
            </div>
        </div>

        <!-- Mobile view -->
        <v-list-item class="hidden-md-and-up">
                <v-list-item-avatar>
                    <img src="http://localhost:8000/images/monitor.jpeg" alt="">
                </v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title v-text="profileInfo.first_name + ' ' + profileInfo.last_name"></v-list-item-title>
                </v-list-item-content>

                <v-list-item-icon>
                    <v-btn dark icon small to="/change_profile">
                        <v-icon>
                            settings
                        </v-icon>
                    </v-btn>
                </v-list-item-icon>
            </v-list-item>

        <div id="history-title">
            <h3>
                My Purchased History
            </h3>
        </div>

        <!-- Purchased History -->
        <div class="row">
            <div class="col-sm-4 col-md-2 col-lg-2" v-for="history in histories" :key="history.id">
                <v-card dark>
                    <img class="images" :src="'http://localhost:8000/' + history.image" :alt="history.name">
                    <v-card-title>
                        {{ history.name }}
                    </v-card-title>
                    <v-card-text>
                       Quantity:  <strong>{{ history.quantity }}</strong> <br>
                       Price:  <strong>{{ history.price }}</strong> <br>
                       Status:  <strong> {{ history.status }} </strong>
                    </v-card-text>
                </v-card>
            </div>
        </div>
    </div>    
</template>


<script>
export default {

    data () {
        return {
            profileUpdating: false,
            profileInfo: {},
            histories: []
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
                this.getProfileHistory()
            })
            .catch(error => {
                console.log(error)
            })


        
    },

    methods: {

        getProfileHistory () {
            axios.get(api.profile_history + '/' + this.profileInfo.id)
                .then(response => {
                    this.histories = response.data
                })
                .catch(error => {
                    console.log(error.response)
                })
        },

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

    #history-title {
        font-family: 'batmfa';
        margin-top: 30px;
    }

    .images {
        width: 100%;
    }

    #line {
        margin-bottom: 20px;
        width: 100%;
        height: 5px;
        background: #fff;
    }

    * {
        color: #ffffff;
    }

    #profile-name {
        font-weight: 800;
        font-family: 'batmfa';
        font-size: 1.8rem;
    }

    #modal-title {
        font-family: 'batmfa';
    }

    #header-row {
        margin-bottom: 20px;
    }

    #header-box {
        padding-bottom: 20px;
        border-bottom: 1px solid white;
    }

</style>