<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-2 col-lg-2">
                <div class="row pl-4">
                    <strong class="mt-2 mr-3">Email: </strong> <ChangeName class="hidden-md-and-up" :user="userInfo" />
                </div>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-8">
                <h5 class="mt-2">{{user.email}}</h5>
            </div>
            <div class="col-sm-1 col-md-2 col-lg-2">
                <ChangeName class="hidden-sm-and-down" :user="userInfo" />
            </div>
        </div>
        <v-divider></v-divider>

        <div class="row">
            <div class="col-sm-3 col-md-2 col-lg-2">
                <div class="row pl-4">
                    <strong class="mt-2 mr-3">First Name: </strong> <ChangeFirstName class="hidden-md-and-up" :user="userInfo" />
                </div>
            </div>
            <div class="col-sm-5 col-md-8 col-lg-8">
                <h5>{{user.first_name}}</h5>
            </div>
            <div class="col-sm-1 col-md-2 col-lg-2">
                <ChangeFirstName class="hidden-sm-and-down" :user="userInfo" />
            </div>
        </div>
        <v-divider></v-divider>

        <div class="row">
            <div class="col-sm-3 col-md-2 col-lg-2">
                <div class="row pl-4">
                    <strong class="mt-2 mr-3">Last Name: </strong> <ChangeLastname class="hidden-md-and-up" :user="userInfo" />
                </div>
            </div>
            <div class="col-sm-5 col-md-8 col-lg-8">
                <h5>{{user.last_name}}</h5>
            </div>
            <div class="col-sm-1 col-md-2 col-lg-2">
                <ChangeLastname class="hidden-sm-and-down" :user="userInfo" />
            </div>
        </div>
        <v-divider></v-divider>

        <div class="row">
            <div class="col-sm-3 col-md-2 col-lg-2">
                <div class="row pl-4">
                    <strong class="mt-2 mr-3">Address: </strong>  <ChangeAddress class="hidden-md-and-up" :user="userInfo" />
                </div>
            </div>
            <div class="col-sm-5 col-md-8 col-lg-8">
                {{user.address}}
            </div>
            <div class="col-sm-1 col-md-2 col-lg-2">
                <ChangeAddress class="hidden-sm-and-down" :user="userInfo" />
            </div>
        </div>
        <v-divider></v-divider>

        <div class="row">
            <div class="col-sm-3 col-md-5 col-lg-5">
                <strong>Change Password: </strong>
            </div>
            <div class="col-md-5 col-lg-5"></div>

            <div class="col-sm-1 col-md-2 col-lg-2">
                <ChangePassword :user="userInfo" />
            </div>
        </div>
    </div>
</template>

<script>
import ChangeName from './modals/ChangeName.vue'
import ChangeFirstName from './modals/ChangeFirstname.vue'
import ChangeLastname from './modals/ChangeLastname.vue'
import ChangeAddress from './modals/ChangeAddress.vue'
import ChangePassword from './modals/ChangePassword.vue'

export default {

    components: {
        ChangeName,
        ChangeFirstName,
        ChangeLastname,
        ChangeAddress,
        ChangePassword
    },

    data () {
        return {
            userInfo: []
        }
    },

    computed: {
        user() {
            return this.userInfo
        }
    },  

    created () {
        this.getUserInfo()

        bus.$on('profile-changed', () => {
            this.getUserInfo()
        })
    },

    methods: {
        getUserInfo() {
            this.$store.dispatch('USER_DATA')
                .then(() => {
                    axios.get(api.change_profile + '/' + this.$store.state.user.id)
                        .then(response => {
                            this.userInfo = response.data
                        })
                        .catch(error => {
                            console.log(error.response)
                        })
                })
        }
    }
}
</script>

<style scoped>
* {
    color: #fff;
}

strong {
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
}
</style>