<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-6" id="product-image">
                <img :src="'http://localhost:8000/' + product.image" alt="">
                
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <form>
                            <input id="quantity" v-model="quantity" type="number" class="form-control" placeholder="Quantity">
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <button @click.prevent="order()" class="btn btn-success">Add to Cart</button>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 px-5 py-2" id="details">
                <div class="mb-3" id="head">
                    <h3> {{ product.name }} </h3>
                </div>
                <div class="mb-2" id="body">
                    <p> {{ product.description }} </p>
                </div>
                <div id="foot">
                    <span> <h3> {{ product.price }} PHP </h3> </span>
                </div>
            </div>
        </div>

        <!-- Feedbacks -->
        <div id="feedback-title">
            <h1>feedbacks</h1>
        </div>

        <span v-if="error"> <h3> {{ error }} </h3> </span>

        <div class="mb-5" id="feedbacks" v-for="feedback in feedbacks" :key="feedback.id">
            <span class="mb-2">Ratings:  {{ feedback.ratings }} </span>
            <p> {{ feedback.comment }} </p>

            <strong>By: </strong> {{ feedback.last_name }}, {{ feedback.first_name }}
        </div>

        <div class="mb-3 pb-5">
            <form @submit.prevent="postFeedback()">
                <label>Comment:</label>
                <textarea v-model="comment" rows="5" class="form-control"></textarea>
                <button type="submit" class="btn btn-success mt-3 btn-lg">Comment</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            product: [],
            feedbacks: [],
            error: '',
            quantity: '',
            comment: ''
        }
    },

    mounted() {
        axios.get(productURL + '/' + this.$route.params.id)
            .then(response => {
                this.product = response.data.product
            })
            .catch(error => {
                console.log(error)
            })

            this.getFeedbacks()

            bus.$on('load-feedbacks', () => {
                this.getFeedbacks()
            })
    },

    methods: {
        getFeedbacks() {
            axios.get(feedbackURL + '/' + this.$route.params.id)
                .then(response => {
                    this.feedbacks = response.data.feedbacks
                    console.log(this.feedbacks)
                })
                .catch(error => {
                    this.error = error.response.data.error
                })
        },

        order() {
            const data = {
                quantity: this.quantity,
                product_id: this.$route.params.id,
                user_id: window.localStorage.getItem('id')
            }

            axios.post(cartURL, data)
                .then(response => {
                    this.quantity = ''
                    alert('Added')
                })
                .catch(error => {
                    console.log(error.response)
                })
        },

        postFeedback() {
            const data = {
                ratings: 3,
                user_id: window.localStorage.getItem('id'),
                product_id: this.$route.params.id,
                comment: this.comment
            }

            axios.post(feedbackURL, data)
                .then(response => {
                    bus.$emit('load-feedbacks')
                    this.comment = ''
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

    #details #head h3{
        font-family: 'batmfa';
        font-size: 2.5em;
        font-weight: 600;
        letter-spacing: 8px;
    }

    #product-image img{
        height: 80%;
        width: 100%;
    }

    #feedback-title {
        font-family: 'batmfa';
        font-size: 2.3em;
        font-weight: 700;
    }

    #quantity {
        color: black;
        font-size: 1.2em;
        font-weight: 300;
        letter-spacing: 1px;
    }

</style>