<template>
    <div class="container">
        <div class="form-group px-5 py-3" id="form-box">

            <h3 id="form-title"> Update Product </h3>
            
            <form @submit.prevent="updateProduct()">
                
                <input v-model="product.name" type="text" class="form-inputs my-4" placeholder="Product Name">

                <textarea v-model="product.description" rows="4" class="form-inputs my-4" placeholder="Product Description"></textarea>

                <input v-model="product.price" type="number" class="form-inputs my-4" placeholder="Price">

                <div class="my-4">
                    <label>Category</label>
                    <select class="form-control" v-model="product.category_id">
                        <option  v-for="category in categories" :key="category.id" :value="category.id"> {{ category.name }} </option>
                    </select>
                </div>
                <input @change="imageChanged" type="file" class="form-inputs my-4">

                <button type="submit" class="btn btn-primary mt-3">Update</button>    
            </form>
        </div>
    </div>
</template>

<script>
export default {
    
    data () {
        return {
            image: ''
        }
    },

    computed: {
        product() {
            return this.$store.state.product
        },

        categories() {
            return this.$store.state.categories
        }
    },

    created () {
        this.$store.dispatch('GET_PRODUCT_INFO', this.$route.params.product_id)
        this.$store.dispatch('GET_CATEGORIES')
    },

    methods: {
        imageChanged(e) {
            
            const fileReader = new FileReader()

            fileReader.readAsDataURL(e.target.files[0])
            fileReader.onload = (e) => {
                this.image = e.target.result
            }
        },

        updateProduct() {
            const data = {
                product_id: this.$route.params.product_id,
                name: this.product.name,
                description: this.product.description,
                price: this.product.price,
                category_id: this.product.category_id,
                image: this.image
            }

            this.$store.dispatch('UPDATE_PRODUCT', data)
                .then(() => {

                    this.$router.push('/admin/products')
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>

<style scoped>
    #form-box {
        background: black;
        border: 2px #800000 solid;
    }

    #form-title {
        font-family: 'batmfa';
        font-size: 2em;
        font-weight: 700;
        letter-spacing: 2px;
    }

    label {
        color: #ffffff;
        font-size: 1.2em;
        font-weight: 300;
        letter-spacing: 2px;
    }

    .form-inputs {
        width: 100%;
        background: black;
        border: none;
        border-bottom: 2px red solid;
        color: #ffffff;
        font-size: 1.2em;
        font-weight: 300;
        letter-spacing: 2px;
    }

    .form-inputs:focus {
        outline: none;
    }
</style>