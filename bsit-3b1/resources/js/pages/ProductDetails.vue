<template>
    <!-- Product Details -->
    <div>
        <div class="row hidden-sm-and-down" id="details-row">
            <div class="col-sm-12 col-md-5 col-lg-4">
                <img :src="'http://localhost:8000/' + product.image" alt="">
            </div>
            <div class="col-sm-12 col-md-1 col-lg-1" id="small-img">
                <img class="s-img" :src="'http://localhost:8000/' + product.image" alt="">
                <img class="s-img" :src="'http://localhost:8000/' + product.image" alt="">
                <img class="s-img" :src="'http://localhost:8000/' + product.image" alt="">
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 ml-3">
                <h3 class="product-name"> {{ product.name }} </h3>
                <p> [Few Description] </p>
                <v-rating small 
                            readonly 
                            color="orange lighten-3" 
                            background-color="orange lighten-3" 
                            v-model="ratings"
                            ></v-rating>

                <div class="line"></div>

                <h4><strong>Price: </strong> PHP {{ product.price }} </h4>
                <h4><strong>Stocks: </strong> [123] </h4>

                <div class="line"></div>

                <div class="row hidden-md-and-down" id="cart">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <v-btn v-if="isAuth && !isAdmin" dark @click="isOrdering = !isOrdering"> Add to Cart </v-btn>
                        <v-btn v-else-if="!isAuth && !isAdmin" dark @click="notAuth"> Add to Cart </v-btn>
                    </div>
                    <v-spacer></v-spacer>
                </div>
            </div>
        </div>

        <div class="row hidden-md-and-up"> <!-- Mobile View -->
            <v-carousel hide-delimiters>
                <v-carousel-item>
                    <img :src="'http://localhost:8000/' + product.image" alt="">
                </v-carousel-item>
            </v-carousel>

            <div class="col-sm-5">
                <h3> {{ product.name }} </h3>
                <v-rating small 
                    readonly 
                    color="orange lighten-3" 
                    background-color="orange lighten-3" 
                    v-model="ratings"
                    ></v-rating>
            </div>

             <div class="col-sm-5">
                <h4><strong>P {{ product.price }} </strong></h4>
                <h4><strong>Stocks:  [123] </strong></h4>
            </div>
        </div>

        <div class="row hidden-md-and-up">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <v-btn v-if="isAuth && !isAdmin" block color="primary" @click="isOrdering = !isOrdering"> Add to Cart </v-btn>
                <v-btn v-else-if="!isAuth && !isAdmin" block color="primary" @click="notAuth"> Add to Cart </v-btn>
            </div>
        </div>

        <!-- Ordering Process-->
        <v-dialog max-width="600" v-model="isOrdering" dark>
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

        <div class="col-md-8 col-lg-6 hidden-sm-and-down">
            <v-tabs dark v-model="tab">
                <v-tab href="#description">DESCRIPTION</v-tab>
                <v-tab href="#product_info">PRODUCT INFO</v-tab>
                <v-tab href="#specs">SPECIFICATION</v-tab>

                <v-tabs-items v-model="tab">
                    <v-tab-item value="description">
                        <v-card dark>
                            <v-card-text> {{ product.description }} </v-card-text>
                        </v-card>
                    </v-tab-item>
                    <v-tab-item value="product_info">
                        <div class="row">
                            <v-spacer></v-spacer>
                            <div class="col-sm-12 col-md-5 col-lg-4">
                                <img :src="'http://localhost:8000/' + product.image" :alt="product.name">
                            </div>
                            <v-spacer></v-spacer>
                        </div>
                    </v-tab-item>
                    <v-tab-item value="specs">
                        <v-card dark>
                            <v-card-text>Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque dolorum earum exercitationem vitae aliquam voluptate nisi asperiores doloribus tempore? Adipisci, explicabo reprehenderit. Accusamus, necessitatibus! Saepe velit ratione ea rerum numquam.</v-card-text>
                        </v-card>
                    </v-tab-item>
                </v-tabs-items>
            </v-tabs>
        </div>

        <div class="col-md-8 col-lg-6 hidden-md-and-up">
            <v-tabs dark v-model="tab">
                <v-tab href="#description">DESCRIPTION</v-tab>
                <v-tab href="#product_info">PRODUCT INFO</v-tab>
                <v-tab href="#specs">SPECIFICATION</v-tab>

                <v-tabs-items v-model="tab">
                    <v-tab-item value="description">
                        <v-card dark>
                            <v-card-text> {{ product.description }} </v-card-text>
                        </v-card>
                    </v-tab-item>
                    <v-tab-item value="product_info">
                        <div class="row">
                            <v-spacer></v-spacer>
                            <div class="col-sm-12 col-md-5 col-lg-4">
                                <img :src="'http://localhost:8000/' + product.image" :alt="product.name">
                            </div>
                            <v-spacer></v-spacer>
                        </div>
                    </v-tab-item>
                    <v-tab-item value="specs">
                        <v-simple-table dark>
                            <thead>
                                <tr>
                                    <th>
                                        <header> LABEL </header>
                                    </th>
                                    <th>
                                        <header> SPECS </header>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="spec in specs" :key="spec.id">
                                    <td> {{ spec.label }} </td>
                                    <td> {{ spec.specs }} </td>
                                </tr>
                            </tbody>
                        </v-simple-table>
                    </v-tab-item>
                </v-tabs-items>
            </v-tabs>
        </div>

        <div class="tab-line"></div>

        <!-- Feedbacks -->
        <v-card dark class="mt-3">
            <v-card-title>
                <h4 id="feedback-title"> Ratings and Reviews </h4>
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
                    
                    <v-row class="mt-2" v-if="isAuth && isAdmin">
                        <v-btn color="error" small @click="removeComment(feedback.id)">
                            remove comment
                        </v-btn>
                    </v-row>
                </div>
            </v-card-text>
        </v-card>

        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-8">
                <v-textarea v-if="isAuth && !isAdmin" v-model="comment" label="Comment" class="my-3" dark></v-textarea>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <v-btn block class="success hidden-md-and-up" v-if="isAuth || isAdmin" @click="postFeedback()">Comment</v-btn>
                <v-btn id="comment-button" block class="success hidden-sm-and-down" v-if="isAuth || isAdmin" @click="postFeedback()">Comment</v-btn>
            </div>
        </div>

    </div>
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
            tab: null
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
        },

        specs() {
            return this.$store.state.specs
        }
    },

    created() {
        this.$store.dispatch('GET_PRODUCT_INFO', this.$route.params.id)
            .then(() => {
                this.$store.dispatch('GET_SPECS', this.product.id)
                    .catch(error => console.log(error.response))
            })
            .catch(error => error.response)

        this.$store.dispatch('GET_FEEDBACKS', this.$route.params.id)

        if(localStorage.getItem('token')) {
            this.$store.dispatch('USER_DATA')
                .then(() => {
                    if(this.$store.state.user.role == 'User') {
                        this.isAuth = true
                        this.isAdmin = false
                    }
                    else if(this.$store.state.user.role == 'Admin') {
                        this.isAuth = true
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
        },

        removeComment(id) {

            this.$store.dispatch('REMOVE_COMMENT', id)
                .then(() => {
                     this.$store.dispatch('GET_FEEDBACKS', this.$route.params.id)
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

    #comment-button {
        margin-top: 17%;
    }

    #big-img {
        height: 450px;
    }

    .line {
        margin-top: 20px;
        margin-bottom: 20px;
        width: 100%;
        height: 5px;
        background: #fff;
    }

    #big-line {
        margin-top: -55px;
        margin-bottom: 20px;
        width: 100%;
        height: 5px;
        background: #fff;
    }

    .s-img {
        height: 100px;
        width: 100%;
        margin-bottom: 20px;
    }

    #details-row {
        padding-top: 75px;
        padding-left: 75px;
    }

    #small-img {
        height: 300px;
    }

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