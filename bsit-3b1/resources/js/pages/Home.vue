<template>
    <v-container>

        <h3 id="page-title">Products</h3>
        <v-divider></v-divider>

        <v-btn v-if="isAuth && isAdmin" outlined small dark @click="isAdding = !isAdding"> Add Product </v-btn>

        <!-- Adding a Product Modal -->
        <v-dialog v-model="isAdding" dark>
            <v-card id="adding-card">
                <v-card-title>
                    <span class="headline">
                        Add Product
                    </span>
                </v-card-title>

                <v-container>
                    <v-row>
                        <v-col cols="12" sm="6" md="4">
                            <v-form @submit.prevent="addProduct()">
                                <v-text-field label="Product Name" v-model="product.name"></v-text-field>
                                <v-text-field label="Description" v-model="product.description"></v-text-field>
                                <v-text-field label="Price" v-model="product.price" type="number"></v-text-field>
                                <label class="subheading" id="label"> Category </label>
                                <!-- <v-btn-toggle id="category">
                                    <v-btn v-for="cat in categories" :key="cat.id" small text class="mx-2 sm-4" @click="product.category_id = cat.id">
                                        <span> {{ cat.name }} </span>
                                    </v-btn>
                                </v-btn-toggle> -->

                                <select class="form-control" v-model="product.category_id" label="Categories">
                                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                                        {{ cat.name }}
                                    </option>
                                </select>
                                <v-btn class="primary my-3" @click="onPickFile">Choose Image</v-btn>
                                <input type="file" style="display: none" ref="fileInput" accept="image/*" @change="imageChanged">
                                <v-img :src="product.image" height="100" width="100" class="mb-3"></v-img>

                                <v-card-actions>
                                    <v-btn type="submit" color="primary">Add Product</v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn text color="red" @click="isAdding = !isAdding">Cancel</v-btn>
                                </v-card-actions>
                            </v-form>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card>
        </v-dialog>

        <!-- Updating a Product Modal -->
        <v-dialog v-model="isUpdating" dark>
            <v-card>
                <v-card-title>
                    <span class="headline">
                        Update Product
                    </span>
                </v-card-title>

                <v-container>
                    <v-row>
                        <v-col cols="12" sm="6" md="4">
                            <v-form @submit.prevent="update()">
                                <v-text-field label="Product Name" v-model="updateProduct.name"></v-text-field>
                                <v-text-field label="Description" v-model="updateProduct.description"></v-text-field>
                                <v-text-field label="Price" v-model="updateProduct.price" type="number"></v-text-field>
                                <label class="subheading" id="label"> Category </label>
                                <v-btn-toggle>
                                    <v-btn v-for="cat in categories" :key="cat.id" small text class="mx-2" @click="updateProduct.category_id = cat.id">
                                        <span> {{ cat.name }} </span>
                                    </v-btn>
                                </v-btn-toggle>
                                <v-btn class="primary my-3" @click="updateOnPickFile">New Image</v-btn>
                                <input type="file" style="display: none" ref="updateFileInput" accept="image/*" @change="updateImageChanged">
                                <v-img :src="updateProduct.image" height="100" width="100" class="mb-3"></v-img>

                                <v-card-actions>
                                    <v-btn type="submit" color="primary">Update Product</v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn text color="red" @click="isUpdating = !isUpdating">Cancel</v-btn>
                                </v-card-actions>
                            </v-form>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card>
        </v-dialog>

        <!-- Product List -->
        <v-row dense>
            <v-col v-for="product in products" :key="product.id" sm="12" md="6" lg="4" xl="3">
                <v-card dark hover class="ma-3">
                    <v-img height="200" :src="'http://localhost:8000/' + product.image"></v-img>

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
                        <v-btn text color="warning" v-if="isAuth && isAdmin"
                                @click="forUpdate(product.id, product.name, product.description, product.price)">
                            <span>Edit</span>
                        </v-btn>

                        <v-btn text color="red" v-if="isAuth && isAdmin">
                            <span>Delete</span>
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>

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
export default {

    data () {
        return {
            isAuth: false,
            isAdmin: false,
            user_id: '',
            isAdding: false,
            product: {
                name: '',
                description: '',
                price: '',
                category_id: '',
                image: ''
            },
            quantity: 1,
            isAddingToCart: false,
            isUpdating: false,
            updateProduct: {
                id: '',
                name: '',
                description: '',
                price: '',
                category_id: '',
                image: ''
            },

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

        categories() {
            return this.$store.state.categories
        }
    },

    mounted() {
        
        this.getProducts()
        this.setUser()

        this.$store.commit('SET_LOADER', true)
        this.$store.dispatch('GET_CATEGORIES')
            .then(() => {
                this.$store.commit('SET_LOADER', false)
            })

        bus.$on('product-changed', () => {
            this.getProducts()
        })
    },

    methods: {

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

        onPickFile () {
            this.$refs.fileInput.click()
        },

        updateOnPickFile () {
            this.$refs.updateFileInput.click()
        },

        imageChanged(e) {
            
            const fileReader = new FileReader()

            fileReader.readAsDataURL(e.target.files[0])
            fileReader.onload = (e) => {
                this.product.image = e.target.result
            }
        },

        updateImageChanged(e) {
            
            const fileReader = new FileReader()

            fileReader.readAsDataURL(e.target.files[0])
            fileReader.onload = (e) => {
                this.updateProduct.image = e.target.result
            }
        },

        addProduct() {
            this.$store.dispatch('ADD_PRODUCT', this.product)
                .then(() => {
                    this.product.name = ''
                    this.product.description = ''
                    this.product.price = ''
                    this.product.category_id = ''
                    this.isAdding = false

                    bus.$emit('product-changed')
                    window.alert('Product Added')
                })
                .catch(error => {
                    console.log(error.response)
                })
        },

        forUpdate (id, name, description, price) {
            this.updateProduct.id = id
            this.updateProduct.name = name
            this.updateProduct.description = description
            this.updateProduct.price = price

            this.isUpdating = true
        },

        update() {
            this.$store.dispatch('UPDATE_PRODUCT', this.updateProduct)
                .then(() => {
                    bus.$emit('product-changed')
                    this.isUpdating = false
                })
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

        getProducts() {
            this.$store.commit('SET_LOADER', true)
            this.$store.dispatch('GET_PRODUCTS')
                .then(() => {
                    this.$store.commit('SET_LOADER', false)
                })
                .catch(error => {
                    console.log(error)
                })
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

    #page-title {
        font-family: 'batmfa';
        color: #fff;
    }

    .form-control {
        background: grey;
        color: white;
    }

</style>