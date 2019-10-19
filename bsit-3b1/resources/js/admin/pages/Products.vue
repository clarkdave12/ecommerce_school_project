<template>
    <div class="container">
        <h5>Search Bar</h5>
        <hr>
        <div class="row">
            <div v-for="product in products" :key="product.id" class="col-4 mt-5">
                <h4> {{ product.name }} || <small> {{ product.price }} </small> </h4>
                <small> {{ product.description }} </small>
                <div class="row">
                    <div>
                        <button class="btn btn-warning">Edit</button>
                    </div>
                    <div class="ml-3">
                        <button @click="deleteProduct(product.id)" class="btn btn-danger">Delete</button>
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