<template>
    <v-container>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4" v-for="order in orders" :key="order.id">
                <v-card dark>
                    <v-card-title> {{ order.order_id }} </v-card-title>
                    <v-card-text>
                        <strong>Status: </strong> {{ order.status }} <br>
                        <strong>Method: </strong> {{ order.method }} <br>
                        <strong>State: </strong> {{ order.state }} <br>
                        <strong>Date: </strong> {{ order.created_at }} <br>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn text :to="'/order_details/' + order.user_id + '/' + order.product_id + '/' + order.quantity"> Details </v-btn>
                    </v-card-actions>
                </v-card>
            </div>
        </div>
    </v-container>
</template>

<script>
export default {

    data () {
        return {
            orders: []
        }
    },

    created() {
        axios.get('http://bsupctech.epizy.com/api/getorders')
            .then(response => {
                this.orders = response.data
            })
            .catch(error => {
                console.log(error.response)
            })
    }
}
</script>