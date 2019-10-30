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

        <!-- Dialog for Adding to Cart -->
        <v-dialog v-model="addingToCart">
            <v-card>
                <img id="cart-image" :src="'http://localhost:8000/' + product.image" :alt="product.name">

                <v-card-title> {{ product.name }} </v-card-title>

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

        <!-- Users Choice -->
            <v-row id="product-container" class="mt-5" v-if="showChoice">
                <v-card class="mx-2 products" dark v-for="c in choice" :key="c.id">
                    <img class="product-image" :src="'http://localhost:8000/' + c.image" :alt="c.name">
                    
                    <v-card-actions>
                        <v-card-text>
                            {{ c.name }}
                        </v-card-text>
                    </v-card-actions>
                </v-card>
            </v-row>

        <!-- User Controls -->
        <v-footer dark fixed class="py-3">

            <!-- For Buttons Control Only -->
            <v-row id="product-container">
                <v-btn small v-for="action in actions" :key="action.name" color="primary mx-2 my-2" @click="actionPicked(action.name)">
                    {{ action.name }}
                </v-btn>

                <v-btn small color="primary mx-2 my-2">
                    Back
                </v-btn>
            </v-row>

        </v-footer>
    </v-container>    
</template>

<script>

export default {
    
    data () {
        return {
            actions: [
                'order',
            ],

            showChoice: false,
            choice: [],

            category: '',
            product: ''
        }
    },

    methods: {

        processOutput() {
            
        },

        order() {
        const data = {
            quantity: this.quantity,
            product_id: this.iproduct.id,
            user_id: this.$store.state.user.id,
            price: this.getPrice
        }

        this.$store.dispatch('ADD_TO_CART', data)
            .then(() => {
                this.theMessage = 'You have successfully added \"' + lexin.customer.product.name + '\" ' + 
                                    'to your cart'
                this.theActions = lexin.action.done
                alert('Added to Cart')
                this.addingToCart = false
            })
            .catch(error => {
                console.log(error.response)
            })
        },
    }
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

#cart-image {
    width:100%;
}


</style>