<template>
    <!-- Product Details -->
    <v-container fluid>
        <v-card outlined dark>
            <img :src="'http://localhost:8000/' + product.image" alt="">
            <br>
            <v-card-title class="product-name">
                {{ product.name }}
            </v-card-title>
            <v-card-subtitle>
                <v-rating small 
                            readonly 
                            color="orange lighten-3" 
                            background-color="orange lighten-3" 
                            v-model="ratings"
                            ></v-rating>
                    <br>
                PHP {{ product.price }}
            </v-card-subtitle>
            
            <v-card-text>
                <strong>DESCRIPTION</strong> <br>
                {{ product.description }}
            </v-card-text>
            <v-card-actions>
                <v-btn :to="'/specs/' + product.id" color="success"> Show Specs </v-btn>
            </v-card-actions>
        </v-card>

        <v-btn v-if="isAuth && !isAdmin" block class="my-4" color="primary" @click="isOrdering = !isOrdering"> Add to Cart </v-btn>
        <v-btn v-else-if="!isAuth && !isAdmin" block class="my-4" color="primary" @click="notAuth"> Add to Cart </v-btn>

        <!-- Ordering Process-->
        <v-dialog v-model="isOrdering">
            <v-card>
                <img :src="'http://localhost:8000/' + product.image" :alt="product.name">

                <v-card-title> {{ product.name }} </v-card-title>

                <v-text-field class="mx-3" type="number" label="Quantity" v-model="quantity"></v-text-field>

                <v-card-actions>
                    <div>
                        <strong>Total Price</strong> <br>
                        PHP {{ getPrice }}
                    </div>
                    <v-spacer></v-spacer>

                    <v-btn class="success" @click="order()">Add</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- Feedbacks -->
        <v-card dark class="mt-3">
            <v-card-title>
                <h4 id="feedback-title"> Feedbacks </h4>
            </v-card-title>

            <v-card-text v-if="feedbacks == 0">
                <div>
                    There is no comment yet for this product
                </div>
            </v-card-text>

            <v-card-text>
                <div v-for="feedback in feedbacks" :key="feedback.id">
                    <v-divider></v-divider>
                    <div> <strong> {{ feedback.first_name }} {{ feedback.last_name }} </strong> </div>
                    <v-rating small color="orange lighten-3" background-color="orange lighten-3" v-model="feedback.ratings"></v-rating>
                    <div> {{ feedback.comment }} </div>
                </div>
            </v-card-text>
        </v-card>

        <v-textarea v-if="isAuth && !isAdmin" v-model="comment" label="Comment" class="my-3" dark></v-textarea>
        <v-btn block class="success" v-if="isAuth && !isAdmin" @click="postFeedback()">Comment</v-btn>
        <v-btn block class="success" v-else-if="!isAuth && !isAdmin" to="/login" tag="span">Comment</v-btn>

    </v-container>
</template>

<script>
export default {
    data () {
        return {
            error: '',
            quantity: 1,
            comment: '',
            ratings: 3,
            isOrdering: false,
            isAuth: false,
            isAdmin: false,
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

        if(localStorage.getItem('token')) {
            this.$store.dispatch('USER_DATA')
                .then(() => {
                    if(this.$store.state.user.role == 'User') {
                        this.isAuth = true
                        this.isAdmin = false
                    }
                    else if(this.$store.state.user.role == 'Admin') {
                        this.isAdmin = true
                    }
                })
        }
        else {
            this.isAuth = false
        }


        bus.$on('feedbackPosted', () => {
            this.comment = ''
            this.$store.dispatch('GET_FEEDBACKS', this.$route.params.id)
        })

        bus.$on('addcart', () => {
            this.isOrdering = true
        })
    },

    methods: {

        notAuth() {
            this.$router.push('/login')
        },

        order() {
            
            const data = {
                quantity: this.quantity,
                product_id: this.$store.state.product.id,
                user_id: this.$store.state.user.id,
                price: this.getPrice
            }

            this.$store.dispatch('ADD_TO_CART', data)
                .then(() => {
                    alert('Added to Cart')
                    this.isOrdering = false
                })
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
    img {
        height: 80%;
        width: 100%;
    }

    .product-name {
        font-family: 'batmfa';
        font-weight: 600;
    }

    #feedback-title {
        font-family: 'batmfa';
        font-weight: 600;
    }

</style>