<template>
    <div class="container">
        <div class="row">

            <div class="col-lg-8 col-sm-12">
                
                <div class="col-lg-12 col-sm-12 mb-3">
                    
                    <div class="image-frame">
                        <img :src="'http://localhost:8000/' + userProfile.image">
                    </div>

                    <h4>Name: {{ userProfile.last_name }}, {{ userProfile.first_name }} </h4>
                    <h6> Email: {{ userProfile.email }} </h6>
                    <small> Address: {{ userProfile.address }} </small>
                </div>

                <!-- All Optionals Fields -->
                <div v-if="userProfile.age" class="col-lg-12 col-sm-12">
                    <h5>Age: {{ userProfile.age }} </h5>
                </div>
                <div v-if="userProfile.gender" class="col-lg-12 col-sm-12">
                    <h5>Gender: {{ userProfile.gender }} </h5>
                </div>
                <div v-if="userProfile.work" class="col-lg-12 col-sm-12">
                    <h5>Work: {{ userProfile.work }} </h5>
                </div>
                <div v-if="userProfile.religion" class="col-lg-12 col-sm-12">
                    <h5>Religion: {{ userProfile.religion }} </h5>
                </div>

                <button class="btn btn-primary"> Update Profile </button>
            </div>
        </div>
    </div>
</template>


<script>
export default {

    computed: {
        userProfile() {
            return this.$store.state.profile
        }
    },

    created () {
        this.$store.dispatch('GET_PROFILE', this.$route.params.user_id)
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

        createProfile() {
            this.$router.push('/profile/create/' + this.$route.params.user_id)
        }
    }
}
</script>

<style scoped>

    * {
        color: #ffffff;
    }

    .image-frame {
        width: 100%;
        height: 75%;
    }

    .image-frame img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
    }

</style>