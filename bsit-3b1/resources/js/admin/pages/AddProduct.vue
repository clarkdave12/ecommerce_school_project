<template>
    <div class="container">
        <admin-navbar></admin-navbar>
        <div class="form-group px-5 py-3" id="form-box">

            <h3 id="form-title"> Add new product </h3>
            
            <form @submit.prevent="addProduct()">
                
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

                <button type="submit" class="btn btn-primary mt-3">Add</button>    
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            categories: [],

            product: {
                name: '',
                description: '',
                price: '',
                category_id: '',
                image: ''
            }
        }
    },

    mounted() {
        this.getCategories()
    },

    methods: {
        addProduct() {

            console.log(this.product)
            axios.post(productURL, this.product)
                .then(response => {
                    console.log(response)
                })
                .catch(error => {
                    console.log(error.response)
                })
        },

        getCategories() {
            axios.get(categoryURL)
                .then(response => {
                    this.categories = response.data
                })
                .catch(error => {
                    console.log(error)
                })
        },

        imageChanged(e) {
            
            const fileReader = new FileReader()

            fileReader.readAsDataURL(e.target.files[0])
            fileReader.onload = (e) => {
                this.product.image = e.target.result
            }

            

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