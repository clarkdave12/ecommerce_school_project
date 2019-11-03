<template>
    <v-container>
        <v-card dark v-for="ph in purchasedHistory" :key="ph.id">
            <v-card-title>
                <strong> ORDER ID:  </strong> {{ ph.order_id }}
            </v-card-title>
            <v-card-text>
                <v-list>
                    <v-list-item>
                        METHOD:  {{ ph.method }}
                    </v-list-item>

                    <v-list-item>
                        RECIPIENT NAME:  {{ ph.recipient_name }}
                    </v-list-item>

                    <v-list-item>
                        SHIPPING ADDRESS:  {{ ph.shipping_address }}
                    </v-list-item>

                    <v-list-item>
                        AMOUNT:  {{ ph.amount }}
                    </v-list-item>
                </v-list>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
export default {
    
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
                this.$store.dispatch('GET_PURCHASED_HISTORY', this.user.id)
                    .then(() =>{
                        console.log(this.purchasedHistory)
                    })
            })
            .catch(error => {
                console.log(error)
            })
    }
}
</script>