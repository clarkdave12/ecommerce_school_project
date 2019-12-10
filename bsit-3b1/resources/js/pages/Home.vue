<template>
    <div>
        <div class="row">
            <v-spacer></v-spacer>
            <div class="col-sm-12 col-lg-4">
                <input @keyup="searchProduct" type="text" id="search-bar" placeholder="Search Product" v-model="search">
                <v-btn id="searchButton" icon small dark @click="searchProduct">
                    <v-icon>search</v-icon>
                </v-btn>
            </div>
        </div>
        <v-row>
            <v-col>
                <AddProduct v-if="isAuth && isAdmin"></AddProduct>
            </v-col>
        </v-row>

        <!-- Hot Products -->
        <div class="row" v-if="!search && !showSearchedProducts">
            <h3 class="side-title">New Arrivals</h3>
        </div>
        <div class="row" v-if="!search && !showSearchedProducts">
            <div class="col-sm-6 col-md-4 col-lg-3" v-for="np in newProducts" :key="np.id" @click="gotoDetails(np.id)">
                <div class="hot-box">
                    <img :src="'http://bsupctech.epizy.com/' + np.image" :alt="np.name" class="hot-image">
                    <div class="hot-content">
                        <div class="hot-text">
                            <v-card-title> {{ np.name }} </v-card-title>
                        <v-card-text v-if="np.description.length > 20"> {{ np.description.slice(0, 20) }} ... </v-card-text>
                        <v-card-text v-else> {{ np.description.slice(0, 20) }} </v-card-text>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <v-divider v-if="!search && showSearchedProducts"></v-divider>

        <!-- Most Popular -->
        <div class="row" v-if="!search && populars > 0 && !showSearchedProducts">
            <h3 class="side-title">Most Popular</h3>
        </div>

        <div class="row" v-if="!search && !showSearchedProducts">
            <div class="col-sm-6 col-md-4 col-lg-3" v-for="p in popularProducts" :key="p.id">
                <v-card dark>
                    <img class="popular-image" :src="'http://bsupctech.epizy.com/' + p.image" alt="">
                    <v-card-title>
                        {{ p.name }}
                    </v-card-title>
                    <v-card-text>
                        <h4>SOLD: <strong> {{ p.sold }} </strong> </h4>
                    </v-card-text>
                </v-card>
            </div>
        </div>

        <v-divider v-if="!search && !showSearchedProducts"></v-divider>

        <!-- Categories -->
        <div class="row" v-if="!search && !showSearchedProducts">
            <h3 class="side-title">Categories</h3>
        </div>
        <div class="row" v-if="!search && !showSearchedProducts">
            <div class="col-sm-4 col-md-3 col-lg-2" v-for="category in categories" :key="category.id">
                <v-card dark @click="searchByCategory(category.id)">
                    <img class="category-image" :src="'http://bsupctech.epizy.com/' + category.image" :alt="category.name">
                    <v-card-title>
                        {{category.name}}
                    </v-card-title>
                </v-card>
            </div>
        </div>

        <v-divider v-if="!search && !showSearchedProducts"></v-divider>

        <!-- Product List -->
        <div class="row">
            <h3 class="side-title">Products</h3>
        </div> 
        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3" v-for="product in products" :key="product.id">
                <v-card dark class="product-card">
                    <img @click="gotoDetails(product.id)" height="200" class="product-image" :src="'http://bsupctech.epizy.com/' + product.image">

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
        <v-dialog dark v-model="isAddingToCart">
            <v-card>
                <img :src="'http://bsupctech.epizy.com/' + cart.image" :alt="cart.name">

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
    </div>
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
            searchedProducts: [],
            showSearchedProducts: false,
            newProducts: [],
            theProducts: [],
            populars: []
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
            return this.theProducts
        },

        categories() {
            return this.$store.state.categories
        },

        popularProducts() {
            return this.populars
        }
    },

    created() {
        this.setUser()
        this.getNewProducts()
        this.getMostPopular()
        this.$store.dispatch('GET_PRODUCTS')
            .then(() => {
                this.theProducts = this.$store.state.products
            })

        this.$store.dispatch('GET_CATEGORIES')

        bus.$on('product-changed', () => {
            this.$store.dispatch('GET_PRODUCTS')
        })
    },

    methods: {

        searchByCategory(id) {

            axios.get(api.search_by_category + '/' + id)
                .then(response => {
                    this.theProducts = response.data
                    this.showSearchedProducts = true
                    console.log(this.products)
                })
                .catch(error => console.log(error.response))
        },

        getNewProducts() {

            axios.get(api.new_products)
                .then(response => {
                    this.newProducts = response.data
                }) 
                .catch(error => {
                    console.log(error.response)
                })
        },

        getMostPopular() {

            axios.get(api.get_most_popular)
                .then(response => {
                    this.populars = response.data
                })
                .catch(error => {
                    console.log(error.response)
                })
        },

        searchProduct() {

            const data = {
                search: this.search
            }

            axios.post(api.productSearch, data)
                .then(({data}) => {
                    this.theProducts = data
                    this.showSearchedProducts = true
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

    .category-image {
        width: 100%;
        height: 200px;
    }

    .popular-image {
        width: 100%;
        height: 300px;
    }

    .side-title {
        font-family: 'batmfa';
        margin-left: 10px;
        color: #b22222;
    }

    .hot-content {
        border-radius: 5px;
        min-height: 150px;
        width: 100%;
        background: #3c3f41;
        color: #fff;
    }

    .hot-text {
        padding-top: 50px;
    }

    .hot-image {
        max-width: 150px;
        max-height: 150px;
        margin-bottom: -40px;
        z-index: 1000;
    }

    #searchButton {
        background: #3c3f41;
        width: 35px;
        height: 35px;
    }

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
        height: 100%;
    }

    #search-bar {
        background: #aaaaaa;
        padding-top: 5px;
        padding-bottom: 5px;
        padding-left: 15px;
        color: black;
        width: 85%;
        margin-right: -25px;
        caret-color: black;
        border-radius: 20px;
    }

    #search-bar:focus {
        outline: none;
    }

</style>