<template>
    <span>
        <v-btn text color="warning" @click="isUpdating = !isUpdating">
            <span>Edit</span>
        </v-btn>

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
                                <v-text-field label="Product Name" v-model="product.name"></v-text-field>
                                <v-text-field label="Description" v-model="product.description"></v-text-field>
                                <v-text-field label="Price" v-model="product.price" type="number"></v-text-field>
                                
                                <label class="subheading" id="label"> Category </label>
                                <select class="form-control" v-model="product.category_id" label="Categories">
                                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                                        {{ cat.name }}
                                    </option>
                                </select>

                                <v-btn class="primary my-3" small @click="updateOnPickFile">New Image</v-btn>
                                <input type="file" style="display: none" ref="updateFileInput" accept="image/*" @change="updateImageChanged">
                                <v-img :src="product.image" height="100" width="100" class="mb-3"></v-img>

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
    </span>
</template>

<script>
export default {
    props: [
        'product'
    ],

    data() {
        return {
            isUpdating: false,
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
        update() {
            this.$store.dispatch('UPDATE_PRODUCT', this.product)
                .then(() => {
                    bus.$emit('product-changed')
                    this.isUpdating = false
                })
        },

        updateOnPickFile () {
            this.$refs.updateFileInput.click()
        },

        updateImageChanged(e) {
            
            const fileReader = new FileReader()
            fileReader.readAsDataURL(e.target.files[0])
            fileReader.onload = (e) => {
                this.product.image = e.target.result
            }
        },
    }
}
</script>