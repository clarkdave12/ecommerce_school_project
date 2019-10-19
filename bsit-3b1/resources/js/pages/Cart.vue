<template>
    <div class="container">
        <h1>Cart</h1>

        <div v-for="cart in carts" :key="cart.id" class="row">
            <!-- product image -->
            <div class="col-lg-4 col-sm-12">
                <img :src="'http://localhost:8000/' + cart.image" alt="">
            </div>

            <!-- Product Info -->
            <div class="col-lg-4 col-sm-12">
                <h3> {{ cart.name }} </h3>
                <h5> Adding Date: {{ cart.created_at }} </h5>
            </div>

            <!-- Quantity -->
            <div class="col-lg-2 col-sm-12">
                <h3> QTY </h3>
                <h5> {{ cart.quantity }} </h5>
            </div>

            <div class="col-lg-2 col-sm-12 mb-5">
                <h3> {{ cart.price }} PHP </h3>
                <button @click="removeItem(cart.id)" class="btn btn-danger"> Remove </button>
            </div>
            <hr>
        </div>
    </div>
</template>


<script>
export default {
    data () {
        return {
            carts: []
        }
    },

    mounted () {
        this.getCart()

        bus.$on('item-deleted', () => {
            this.getCart()
        })
    },

    methods: {
        getCart () {
            axios.get(cartURL + '/' + window.localStorage.getItem('id'))
                .then(response => {
                    this.carts = response.data
                    console.log(this.cart)
                })
                .catch(error => {
                    console.log(error.response)
                })
        },

        removeItem (id) {
            axios.delete(cartURL + '/' + id)
                .then(response => {
                    console.log(response)
                    bus.$emit('item-deleted')
                })
                .catch(error => {
                    console.log(error.response)
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
</style>