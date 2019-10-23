<template>
    <div class="container">
        <h5>Search Bar</h5>
        <hr>
        <div class="row">
            <div v-for="product in products" :key="product.id" class="col-lg-4 col-sm-12">
                <div class="row box mb-3">
                    <div class="image-frame col-lg-12 col-sm-12">
                        <img :src="'http://localhost:8000/' + product.image" :alt="product.name">
                    </div>

                    <div class="details mb-3 col-lg-12 col-sm-12">
                        <h3> {{ product.name }} </h3>
                        <h6> {{ product.price }} PHP </h6>
                        <p> {{ product.description }} </p>

                        <div class="row">
                            <div class="col-6 col-sm-6">
                                <router-link :to="'/admin/product/' + product.id" class="btn btn-warning">Edit</router-link>
                            </div>
                            <div class="col-6 col-sm-6">
                                <button @click="deleteProduct(product.id)" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
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