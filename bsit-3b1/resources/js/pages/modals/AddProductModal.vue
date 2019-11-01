<template>
    <span>
        <v-btn outlined small dark @click="isAdding = !isAdding"> Add Product </v-btn>

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
    </span>
</template>

<script>
export default {
    data () {
        return {
            isAdding: false,
            product: {
                name: '',
                description: '',
                price: '',
                category_id: '',
                image: ''
            },
        }
    },

    computed: {
        categories() {
            return this.$store.state.categories
        }
    },

    created() {
        this.$store.dispatch('GET_CATEGORIES')
    },

    methods: {
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

        onPickFile () {
            this.$refs.fileInput.click()
        },

        imageChanged(e) {
            
            const fileReader = new FileReader()

            fileReader.readAsDataURL(e.target.files[0])
            fileReader.onload = (e) => {
                this.product.image = e.target.result
            }
        },
    }
}
</script>