<template>
    <v-container fluid>
        <h3>Cart</h3>
        <v-divider></v-divider>

        <v-expansion-panels dark>
            <v-expansion-panel v-for="cart in carts" :key="cart.id">
                <v-expansion-panel-header class="product-name">
                    {{ cart.name }}
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <v-card flat>
                        <img :src="'http://localhost:8000/' + cart.image" alt="cart.name">
                        <v-card-subtitle>
                            PHP {{ cart.price }} <br />
                        </v-card-subtitle>
                        <v-card-subtitle>
                            QTY {{ cart.quantity }} <br />
                        </v-card-subtitle>
                    
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn class="red" @click="removeItem(cart.id)">remove</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>

        <v-footer fixed dark>
            <div> <strong>Total Amount: </strong> <br> PHP {{ totalAmount }} </div>
            <v-spacer></v-spacer>
            <form :action="'http://localhost:8000/api/create-payment/' + user.id + '/' + totalAmount" method="post">
                <v-btn type="submit" color="success">
                    checkout
                </v-btn>
            </form>
            <!-- <v-btn @click="checkout">
                checkout
            </v-btn> -->
        </v-footer>
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
            axios.post('http://localhost:8000/api/create-payment')
                .then(response => {
                    console.log(response)
                })
                .catch(error => {
                    console.log(error)
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