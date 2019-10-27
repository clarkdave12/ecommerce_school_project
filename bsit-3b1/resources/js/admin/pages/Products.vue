<template>
    <v-container fluid>
          
    </v-container>
</template>

<script>
export default {

    data () {
        return {
            price: 'PHP 2000',
        }
    },

    computed: {
        products() {
            return this.$store.state.products
        }
    },

    created () {

        this.$store.dispatch('GET_PRODUCTS')
            .catch(error => {
                console.log(error)
            })

        bus.$on('product-updated', () => {
            this.$store.dispatch('GET_PRODUCTS')
                .catch(error => {
                    console.log(error)
                })
        })
    },

    methods: {
        
        

        deleteProduct(id) {
            this.$store.dispatch('DELETE_PRODUCT', id)
                .then(() => {
                    bus.$emit('product-updated')
                })
                .catch(error => {
                    console.log(error)
                })
        },
    }
}
</script>

<style scoped>

    .image-frame {
        max-height: 40%;
    }

    .image-frame img {
        width: 100%;
        height: 100%;
    }

    .details {
        color: white;
    }

    .box {
        border-bottom: 1px red solid;
    }

</style>