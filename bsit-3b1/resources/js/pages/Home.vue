<template>
    <v-container>
        <div class="row">
            <div class="col-sm-12 col-lg-8">
                <h3 id="page-title">Products</h3>
            </div>
            <div class="col-sm-12 col-lg-4">
                <input @keyup="searchProduct" type="text" id="search-bar" placeholder="Search Product" v-model="search">
                <v-btn icon small dark @click="searchProduct">
                    <v-icon>search</v-icon>
                </v-btn>
            </div>
        </div>
        <v-row>
            <v-col>
                <AddProduct v-if="isAuth && isAdmin"></AddProduct>
            </v-col>
        </v-row>

        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4" v-for="product in products" :key="product.id">
                <v-card dark class="product-card">
                    <img @click="gotoDetails(product.id)" height="200" class="product-image" :src="'http://localhost:8000/' + product.image">

                    <v-card-title>
                        <router-link class="product-name" :to="'/product_details/' + product.id" tag="span" style="cursor: pointer">
                            {{ product.name }}
                        </router-link>
                    </v-card-title>

                    <v-card-text>
                        PHP {{ product.price }}
                    </v-card-text>
                    <v-card-actions>
                        
                        <v-spacer></v-spacer>
                        <!-- For User -->
                        <v-btn icon v-if="isAuth && !isAdmin">
                            <v-icon>favorite</v-icon>
                        </v-btn>

                        <v-btn icon v-if="isAuth && !isAdmin" @click="addToCart(product.id)">
                            <v-icon>shopping_cart</v-icon>
                        </v-btn>

                        <v-btn icon v-if="isAuth && !isAdmin">
                            <v-icon>share</v-icon>
                        </v-btn>

                        <!-- For Admin -->
                        <v-btn text color="info" v-if="isAuth && isAdmin" :to="'/specs/' + product.id">
                            <span>Specs</span>
                        </v-btn>

                        <!-- Edit Button -->
                        <UpdateProduct v-if="isAuth && isAdmin" :product="product"></UpdateProduct>

                        <v-btn text color="red" v-if="isAuth && isAdmin">
                            <span>Delete</span>
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </div>
        </div>

        <!-- Adding to Cart Modal -->
        <v-dialog v-model="isAddingToCart">
            <v-card>
                <img :src="'http://localhost:8000/' + cart.image" :alt="cart.name">

                <v-card-title> {{ cart.name }} </v-card-title>

                <v-text-field class="mx-3" type="number" label="Quantity" v-model="quantity"></v-text-field>

                <v-card-actions>
                    <div>
                        <strong>Total Price</strong> <br>
                        PHP {{ getPrice }}
                    </div>
                    <v-spacer></v-spacer>

                    <v-btn class="success" @click="order()">Add</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </v-container>
</template>

<script>

import AddProduct from './modals/AddProductModal'
import UpdateProduct from './modals/UpdateProductModal'

export default {

    components: {
        AddProduct,
        UpdateProduct,
    },

    data () {
        return {
            isAuth: false,
            isAdmin: false,
            user_id: '',
            quantity: 1,
            isAddingToCart: false,
            search: '',
        }
    },

    computed: {
        cart () {
            return this.$store.state.product
        },

        getPrice() {
            const price = (this.$store.state.product.price * this.quantity)

            return price
        },

        products() {
            return this.$store.state.products
        },
    },

    created() {
        this.setUser()
        this.$store.dispatch('GET_PRODUCTS')

        bus.$on('product-changed', () => {
            this.$store.dispatch('GET_PRODUCTS')
        })
    },

    methods: {


        searchProduct() {

            const data = {
                search: this.search
            }

            axios.post(api.productSearch, data)
                .then(({data}) => {
                    this.$store.commit('SET_PRODUCTS', data)
                })
                .catch(error => {
                    console.log(error.response)
                })
        },

        gotoDetails(id) {
            this.$router.push('/product_details/' + id)
        },

        addToCart (id) {
            this.$store.dispatch('GET_PRODUCT_INFO', id)
                .then(() => {
                    this.isAddingToCart = true
                })
        },

        order() {
            
            const data = {
                quantity: this.quantity,
                product_id: this.$store.state.product.id,
                user_id: this.$store.state.user.id,
                price: this.getPrice
            }

            this.$store.dispatch('ADD_TO_CART', data)
                .then(() => {
                    alert('Added to Cart')
                    this.isAddingToCart = false
                })
                .catch(error => {
                    console.log(error)
                })
        },

        forUpdate (id, name, description, price) {
            this.updateProduct.id = id
            this.updateProduct.name = name
            this.updateProduct.description = description
            this.updateProduct.price = price

            this.isUpdating = true
        },

        

        setUser() {
            if(localStorage.getItem('token')) {
                
                this.$store.commit('SET_LOADER', true)
                this.$store.dispatch('USER_DATA')
                    .then(() => {
                        
                        if(this.$store.state.user.role == 'Admin') {
                            this.isAuth = true
                            this.isAdmin = true
                            this.user_id = this.$store.state.user.id
                            this.$store.commit('SET_LOADER', false)
                        }
                        else if(this.$store.state.user.role == 'User') {
                            this.isAuth = true
                            this.isAdmin = false
                            this.user_id = this.$store.state.user.id
                            this.$store.commit('SET_LOADER', false)
                        }
                        else {
                            this.isAuth = false
                            this.isAdmin = false
                            this.$store.commit('SET_LOADER', false)
                        }
                    })
            }
        },
    }
}
</script>

<style scoped>

    img {
        width: 100%;
    }

    #label {
        color: white;
    }

    .product-name {
        font-family: 'batmfa';
        font-weight: 600;
    }

    .product-card {
        width: 100%;
    }

    #page-title {
        font-family: 'batmfa';
        color: #fff;
    }

    .form-control {
        background: grey;
        color: white;
    }

    .product-image {
        width: 100%;
    }

    #search-bar {
        background: #aaaaaa;
        padding-top: 5px;
        padding-bottom: 5px;
        padding-left: 15px;
        color: black;
        width: 85%;
        margin-right: 13px;
        caret-color: black;
        border-radius: 20px;
    }

    #search-bar:focus {
        outline: none;
    }

</style>