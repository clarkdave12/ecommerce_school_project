<template>
    <div class="container">
        <h1>manage feedbacks</h1>
        <div v-for="feedback in feedbacks" :key="feedback.id" class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="image-frame">
                    <img :src="'http://localhost:8000/' + feedback.image" alt="">
                </div>
            </div>
             <span> {{ feedback.name }} </span>
            <div class="col-lg-6 col-sm-12">
                <header>Ratings: <span> {{ feedback.ratings }} </span> </header>
                <header> Comment: </header>
                <p> {{ feedback.comment }} </p>
                <span> By: {{ feedback.last_name }}, {{ feedback.first_name }} </span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        feedbacks() {
            return this.$store.state.allFeedbacks
        }
    },

    created () {
        this.$store.dispatch('GET_ALL_FEEDBACKS')
    }
}
</script>

<style scoped>

    * {
        color: white;
    }

    .image-frame {
        max-height: 40%;
    }

    .image-frame img {
        height: 100%;
        width: 100%;
    }

</style>