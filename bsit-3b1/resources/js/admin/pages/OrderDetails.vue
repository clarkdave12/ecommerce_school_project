<template>
    <v-container>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <img :src="'http://localhost:8000/' + product.image">
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <h3><strong> {{ product.name }} </strong></h3>
                <br>
                <h3> <strong>Quantity: </strong> {{ this.$route.params.quantity }} </h3> <br>
                <h3> <strong>Price: </strong> PHP {{ product.price }} </h3> <br>
            </div>
        </div>
        <v-divider></v-divider>
        <h3> Shipping Informations </h3>

        <v-card dark>
            <v-card-title> <h2><strong id="name">{{ user.last_name }}, {{ user.first_name }}</strong></h2> </v-card-title>
            <v-card-text>
                <h5><strong>Shipping Address: </strong> {{ user.address }} <br>
                <strong>Contact: </strong> {{ user.email }}</h5>
            </v-card-text>
            <v-card-actions>
                <v-btn color="primary"> Dispatch Order </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script>
export default {

    data () {
        return {
            product: [],
            user: []
        }
    },

    created() {
        axios.get('http://localhost:8000/api/products/' + this.$route.params.product_id)
            .then(response => {
                this.product = response.data.product

            })
            .catch(error => {
                console.lgo(error.response)
            })

        axios.get('http://localhost:8000/api/shipping_info/' + this.$route.params.user_id)
            .then(response => {
                this.user = response.data
            })
            .catch(error => {
                console.log(error.response)
            })
    }
}
</script>

<style scoped>

    #name {
        text-transform: uppercase;
    }

    img {
        height: 100%;
        width: 100%;
    }

    * {
        color: white;
    }

</style>