<template>
    <v-container>
       <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6" v-for="order in orders" :key="order.id">
                <v-card dark>
                    <v-card-title>
                        {{ order.order_id }}
                    </v-card-title>
                    <v-card-text>
                        <h5><strong>Date: </strong>{{ order.created_at }}</h5>
                    </v-card-text>

                    <v-card-actions>
                        <v-btn @click="showProduct(order.order_id)" text color="primary">Show Products</v-btn>
                    </v-card-actions>
                </v-card>
            </div>
       </div>

       <v-dialog v-model="show" max-width="1000" class="py-3 px-3">
           <div class="row">
               <div class="col-sm-12 col-md-6 col-lg-4">
                    <v-card dark v-for="product in products" :key="product.id">
                        <img :src="'http://localhost:8000/' + product.image" alt="">
                        <v-card-title> {{ product.name }} </v-card-title>
                        <v-card-text><strong>Price: </strong> PHP {{ product.price }} </v-card-text>
                    </v-card>
               </div>
           </div>
           <v-btn @click="show = !show" class="mx-2 my-3" max-width="300" color="primary">Close</v-btn>
       </v-dialog>
    </v-container>
</template>

<script>
export default {
    
    data () {
        return {
            orders: [],
            products: [],
            show: false
        }
    },

    computed: {
        user() {
            return this.$store.state.user
        },

        purchasedHistory() {
            return this.$store.state.purchasedHistory
        }
    },

    created () {
        this.$store.dispatch('USER_DATA')
            .then(() => {
                
                axios.get(api.purchasedHistory + '/' + this.user.id)
                    .then(response => {
                        this.orders = response.data
                    })
                    .catch(error => {
                        console.log(response.error)
                    })

            })
            .catch(error => {
                console.log(error)
            })
    },

    methods: {
        showProduct(order_id) {

            axios.get('http://localhost:8000/api/get_history_products/' + order_id)
                .then(response => {
                    this.show = true
                    this.products = response.data
                })
                .catch(error => {
                    this.show = false
                    console.log(error.response)
                })
        }
    }
}
</script>

<style scoped>

    img {
        width: 100%;

    }

</style>