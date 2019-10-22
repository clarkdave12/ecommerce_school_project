<template>
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-lg-6 col-sm-12 mb-5" id="product-image">
                <img :src="'http://localhost:8000/' + product.image" alt="">
                
                <div class="row mt-3">
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <form>
                            <input id=" " v-model="quantity" type="number" class="form-control" placeholder="Quantity">
                        </form>
                    </div>
                    <div class="col-lg-6 col-sm-12 mb-5">
                        <button @click.prevent="order()" class="btn btn-success">Add to Cart</button >
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-12" id="details">
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
            error: '',
            quantity: '',
            comment: ''
        }
    },

    computed: {
        product() {
            return this.$store.state.product
        },

        feedbacks() {
            return this.$store.state.feedbacks
        },

        getPrice() {
            const price = (this.$store.state.product.price * this.quantity)

            return price
        }
    },

    created() {
        this.$store.dispatch('GET_PRODUCT_INFO', this.$route.params.id)
        this.$store.dispatch('GET_FEEDBACKS', this.$route.params.id)

        bus.$on('feedbackPosted', () => {
            this.comment = ''
            this.$store.dispatch('GET_FEEDBACKS', this.$route.params.id)
        })
    },

    methods: {
        order() {
            
            const data = {
                quantity: this.quantity,
                product_id: this.$store.state.product.id,
                user_id: this.$store.state.user.id,
                price: this.getPrice
            }

            this.$store.dispatch('ADD_TO_CART', data)
                .catch(error => {
                    console.log(error)
                })
        },

        postFeedback() {
            const data = {
                user_id: this.$store.state.user.id,
                product_id: this.$store.state.product.id,
                comment: this.comment,
                ratings: 3
            }

            this.$store.dispatch('POST_FEEDBACK', data)
                .then(() => {
                    bus.$emit('feedbackPosted')
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>

<style scoped>

    * {
        color: white;

    }

    #details {
        overflow-wrap: break-word;
    }

    #details #head h3{
        font-family: 'batmfa';
        font-size: 1.8em;
        overflow: wrap;
        font-weight: 600;
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