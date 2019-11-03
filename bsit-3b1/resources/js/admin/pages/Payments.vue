<template>
    <v-container>
        <header>Payments</header>
        <v-card dark v-for="payment in payments" :key="payment.id">
            <v-card-title>
                {{ payment.order_id }}
            </v-card-title>
            <v-card-text>
                Mode of payment: {{ payment.method }} <br>
                Customer Name: {{ payment.recipient_name }} <br>
                Address: {{ payment.shipping_address }} <br>
                State: {{ payment.state }}
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
export default {
    
     computed: {

         payments() {
             return this.$store.state.payments
         }
     },

    created () {
        this.$store.dispatch('GET_PAYMENTS')
    }
}
</script>