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
                                <button class="btn btn-warning">Edit</button>
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
    data () {
        return {
            products: []
        }
    },

    mounted () {
        this.getProducts()

        bus.$on('product-deleted', () => {
            this.getProducts()
        })
    },

    methods: {
        getProducts() {
            axios.get(productURL)
                .then(response => {
                    this.products = response.data.products
                })
                .catch(error => {
                    console.log(error)
                })
        },

        deleteProduct(id) {
            axios.delete(productURL + '/' + id)
                .then(response => {
                    bus.$emit('product-deleted')
                })
                .catch(error => {
                    console.log(error)
                })
        }
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