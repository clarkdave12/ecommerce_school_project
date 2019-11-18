<template>
    <v-container fluid>

        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <h2> CART </h2>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="row">
                    <div class="mx-3"> <h4><strong>Total Amount: </strong> PHP {{ totalAmount }}</h4> </div>
                    <form :action="'http://localhost:8000/api/create-payment/' + user.id + '/' + totalAmount" method="post">
                        <v-btn type="submit" color="success" class="mx-3">
                            checkout
                        </v-btn>
                    </form>
                </div>
            </div>
        </div>

        <v-divider></v-divider>

        <div class="row" v-for="cart in carts" :key="cart.id">
            <div class="col-sm-5 col-md-5 col-lg-5">
                <img :src="'http://localhost:8000/' + cart.image" alt="cart.name">
            </div>
            <div class="col-sm-5 col-md-5 col-lg-5">
                <h3><strong class="product-name">{{ cart.name }}</strong></h3>
                <h5><strong>PHP {{ cart.price }}</strong></h5>
                <h5><strong>QTY. {{ cart.quantity }}</strong></h5>
                <br><br><br>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <v-btn class="red" block @click="removeItem(cart.id)">remove</v-btn>
                    </div>
                </div>
            </div>
        </div>
    </v-container>
</template>


<script>
import { parse } from 'path';

export default {

    computed: {

        carts() {
            return this.$store.state.cart
        },

        totalAmount() {
            const cart = this.carts
            let c = 0
            cart.forEach(ca => {
                c += parseInt(ca.price)
            });

            return c
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
    },

    methods: {

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

    img {
        width: 100%;
        height: 70%;
    }

    .product-name {
        text-transform: uppercase;
    }

    input {
        display: none;
    }

</style>