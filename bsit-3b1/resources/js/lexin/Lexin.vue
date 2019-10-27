<template>
    <v-container>
        <v-row>
            <v-spacer></v-spacer>
            <v-card max-width="200" color="primary">
                <v-card-text class="white--text">
                    {{ message }}
                </v-card-text>
            </v-card>
        </v-row>

        <v-footer dark fixed class="py-3">

            <!-- Cards of products -->
            <!-- <v-row id="product-container" class="pb-2 my-2">
                <v-card dark v-for="product in products" :key="product.id" class="mb-3 mx-2 products">
                    <img class="product-image" :src="'http://localhost:8000/' + product.image" :alt="product.name">
                    <v-card-text>
                        PHP {{ product.price }}
                    </v-card-text>
                </v-card>
            </v-row> -->

            <!-- Buttons For user intents -->

            <v-row id="product-container">
                <v-card class="mx-2 products" dark v-for="action in actions" :key="action.name" @click="actionPicked(action.name)">
                    <img class="product-image" v-if="action.image" :src="'http://localhost:8000/' + action.image" :alt="action.name">
                    
                    <v-card-actions>
                        <v-card-text>
                            {{ action.name }}
                        </v-card-text>
                    </v-card-actions>
                </v-card>
            </v-row>

            <v-row class="py-2">
            </v-row>

        </v-footer>
    </v-container>    
</template>

<script>

import lexin from './lexin.json'

export default {
    
    data () {
        return {
            theMessage: '',
            theActions: []
        }
    },

    computed: {

        message() {
            return this.theMessage
        },

        actions() {
            return this.theActions
        },
    },

    created () {

        this.$store.dispatch('GET_CATEGORIES')
            .then(() => {
                lexin.action.categories = this.$store.state.categories
                console.log(this.theActions)
            })

        this.theMessage = lexin.message.greetings
        this.theActions = lexin.action.greetings
    },

    methods: {
        actionPicked(actionName) {
            /* Ordering Action Tree */
            let categories = lexin.action.categories

            /* Checking if the actionName is a category name */
            for(let i = 0; i < categories.length; i++) {
                if(actionName == categories[i].name) {
                    
                    axios.get('http://localhost:8000/api/get_products_by_category/' + categories[i].id)
                        .then(({data}) => {
                            this.theMessage = lexin.message.products + categories[i].name + ' category, please choose one and I will tell you' +
                            ' about it'
                            lexin.action.products = data
                            this.theActions = data
                        })
                        .catch(error => {
                            console.log(error)
                        })
                }
            }
            
            const products = lexin.action.products
            for(let i = 0; i < products.length; i++) {
                if(actionName == products[i].name) {
                    
                    axios.get('http://localhost:8000/api/get_product_info/' + products[i].id)
                        .then(({data}) => {
                            this.theMessage = 
                                            'This product is called \"' + data.name + '\"'+ 
                                            ', selling for PHP ' + data.price +
                                            '. Here is the description for this product given by the owner \"' +
                                             data.description + '\"'
                        })
                        .catch(error => {
                            console.log(error)
                        })
                }
            }

            if(actionName == 'order')
            {
                this.theMessage = lexin.message.order
                this.theActions = lexin.action.categories
            }
        }
    },
}

</script>


<style scoped>

.products {
    height: 150px;
    width: 100px;
}

.product-image {
    width: 100%;
    height: 90px;
}

#product-container {
    overflow: scroll;
}
</style>