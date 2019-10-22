<template>
    <div class="container">
        <h5>Search Bar</h5>
        <hr>
        <div class="row">
            <div v-for="product in products" :key="product.id" class="col-lg-4 mb-3 col-sm-12">
                <!-- Image -->
                <div id="product-image" class="mb-2">
                    <img :src="'http://localhost:8000/' + product.image" alt="">
                </div>
                <router-link :to="'product_details/' + product.id" id="product-name"><h3> {{ product.name }} </h3></router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    computed: {
        products() {
            return this.$store.state.products
        }
    },

    mounted() {
        this.getProducts()
    },

    methods: {

        getProducts() {
            this.$store.dispatch('GET_PRODUCTS')
                .catch(error => {
                    console.log(error)
                })
        },
    }
}
</script>

<style scoped>

    #product-image {
        height: 50%;
    }

    #product-image img{
        height: 100%;
        width: 100%;
    }

    #product-name {
        color: white;
        font-size: 1.5em;
        letter-spacing: 2px;
        font-weight: 300;
    }
</style>