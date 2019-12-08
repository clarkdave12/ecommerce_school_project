<template>
    <div>
        <div class="row line hidden-sm-and-down" v-for="cart in carts" :key="cart.id">
            <div class="col-sm-4 col-md-3 col-lg-3 image-container">
                <img class="cart-images" :src="'http://localhost:8000/' + cart.image" alt="cart.name">
            </div>
            <div class="col-sm-3 col-md-2 col-lg-2">
                <h3><strong class="product-name">{{ cart.name }}</strong></h3>
            </div>
            <div class="col-sm-3 col-md-2 col-lg-2">
                <header>Quantity</header> <br>
                <div class="row">
                    <div class="col-sm-6 col-md-5 col-lg-4">
                        <v-text-field type="number" solo v-model="cart.quantity" @blur="changeQuantity(cart.id, cart.quantity, cart.product_price)" dark></v-text-field>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-md-2 col-lg-2">
                <header>Unit Price</header> <br>
                <h3><strong class="product-name">{{ cart.product_price }}</strong></h3>
            </div>
            <div class="col-sm-3 col-md-2 col-lg-2">
                <header>Total Price</header> <br>
                <h3><strong class="product-name">{{ cart.cart_price }}</strong></h3>
            </div>
            
            <div class="col-sm-1 col-md-1 col-lg-1 pt-10">
                <v-btn color="error" @click="removeItem(cart.id)">
                    <v-icon>delete</v-icon>
                    remove
                </v-btn>
            </div>
        </div>

        <!-- Mobile View -->
        <div class="row mobile-row hidden-md-and-up" v-for="cart in carts" :key="cart.name">
            <div class="mobile-col">
                <img class="cart-images" :src="'http://localhost:8000/' + cart.image" alt="">
                <div class="mt-2">
                    <v-text-field type="number" label="Quantity" v-model="cart.quantity" @blur="changeQuantity(cart.id, cart.quantity, cart.product_price)" dark></v-text-field>
                </div>
            </div>
            <div class="mobile-details">
                <h3> <strong> {{ cart.name }} </strong> </h3>
                <h5>Unit Price : <strong>P {{cart.product_price}}</strong></h5>
                <h5>Total Price : <strong>P {{cart.cart_price}}</strong></h5>
            </div>
            <div class="col-sm-12">
                <v-btn block color="error" @click="removeItem(cart.id)">
                    <v-icon>delete</v-icon>
                    <span>remove</span>
                </v-btn>
            </div>
            <div class="line"></div>
        </div>

        <div class="row ml-1">
            <v-spacer></v-spacer>
            <div class="col-sm-6 col-md-4 col-lg-3 px-3 py-3" id="checkout-box">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <h4>Subtotal: <strong> P {{ subTotal }} </strong> </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <h4>Tax ( {{ tax }} %): <strong>P {{ totalTax }} </strong> </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <h3><strong>Total Amount: </strong></h3>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <h1><strong>P {{ totalAmount }}</strong></h1>
                    </div>
                </div>

                <form :action="'http://localhost:8000/api/create-payment/' + user.id + '/' + totalAmount" method="post">
                    <v-btn type="submit" block color="primary">
                        checkout
                    </v-btn>
                </form>
            </div>
        </div>
    </div>
</template>


<script>
import { parse } from 'path';

export default {

    data () {
        return {
            tax: 5,
            totalTax: 0
        }
    },

    computed: {

        carts() {
            return this.$store.state.cart
        },

        subTotal() {
            const cart = this.carts
            let c = 0
            cart.forEach(ca => {
                c += parseInt(ca.cart_price)
            });

            return c
        },

        totalAmount() {
            let price = 0
            for(let i = 0; i < this.carts.length; i++) {
                price = price + this.carts[i].cart_price
            }

            let numTax = this.tax / 100
            let total = price * numTax

            this.totalTax = total
            
            let totalAmount = price + total

            return totalAmount
        },

        user() {
            return this.$store.state.user
        }
    },

    created () {
        this.$store.dispatch('USER_DATA')

        this.$store.dispatch('GET_CART', this.$store.state.user.id)
        bus.$on('itemRemoved', () => {
            this.$store.dispatch('GET_CART', this.$store.state.user.id)
        })

        bus.$on('quantity-changed', () => {
            this.$store.dispatch('GET_CART', this.$store.state.user.id)
        })
    },

    methods: {

        getTax() {
            this.tax = this.totalAmount * 0.01;
        },

        changeQuantity(id, quantity, price) {
            const data = {
                id: id,
                quantity: quantity,
                product_price: price
            }

            axios.post(api.change_quantity, data)
                .then(response => {
                    bus.$emit('quantity-changed')
                })
                .catch(error => {
                    console.log(error.response)
                })
        },

        checkout() {
            const data = {
                userId: this.user.id,
                totalAmount: this.totalAmount
            }

            axios.post('http://localhost:8000/api/create-payment', data)
                .then(response => {
                    console.log(response)
                })
                .catch(error => {
                    console.log(error.response)
                })
        },

        removeItem(id) {
            axios.delete(api.carts + '/' + id)
                .then(() => {
                    bus.$emit('itemRemoved')
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

    .mobile-row {
        margin-bottom: 10px;
        border-bottom: 1px solid #fff;
    }

    .mobile-col {
        margin-left: 10px;
        margin-bottom: 10px;
        width: 30%;
    }

    .mobile-details {
        margin-left: 10px;
        margin-bottom: 10px;
        width: 60%;
        overflow-wrap: break-word;
    }

    .cart-images {
        width: 100%;
    }

    .line {
        border-bottom: 2px solid #fff;
        margin-bottom: 30px;
    }

    .image-container {
        text-align: center;
        justify-content: center;
    }

    .product-name {
        text-transform: uppercase;
    }

    input {
        display: none;
    }

    #checkout-box {
        margin-right: 30px;
        border: 1px solid #fff;
    }

    #qty {
        max-width: 30%;
        width: 30%;
    }

</style>