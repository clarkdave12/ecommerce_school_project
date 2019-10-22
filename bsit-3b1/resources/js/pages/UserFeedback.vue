<template>
    <div>
        <h1>User Feedback History</h1>
        <div v-for="fb in userFeedbacks" :key="fb.id" class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="image-frame">
                    <img :src="'http://localhost:8000/' + fb.image" alt="">
                    <h3> {{ fb.name }} </h3>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <header>Ratings: {{ fb.ratings }}  </header>
                <h4>Comment: </h4>
                <p> {{ fb.comment }} </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        userFeedbacks() {
            return this.$store.state.userFeedbacks
        }
    },

    created () {
        this.$store.dispatch('GET_USER_FEEDBACKS', this.$store.state.user.id)
            .catch(error => {
                console.log(error)
            })
    },
}
</script>

<style scoped>

    * {
        color: white;
    }

    .image-frame {
        max-width: 100%;
        max-height: 75%;
    }

    .image-frame img {
        width: 100%;
        height: 75%;
    }

</style>