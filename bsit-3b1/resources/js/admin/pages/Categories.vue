<template>
    <div class="container">
        <h3>Categories</h3>
        <hr>
        <!-- For adding -->
        <div class="form-group">
            <form @submit.prevent="addCategory()">
                <label>Category Name</label>
                <input v-model="category.name" type="text" class="form-control">

                <button type="submit" class="btn btn-success mt-3">Create</button>
            </form>
        </div>

        <!-- For Updating -->
        <div v-if="isUpdating" class="form-group">
            <form @submit.prevent="updateCategory()">
                <label>Category Name</label>
                <input v-model="update.name" type="text" class="form-control">

                <button type="submit" class="btn btn-success mt-3">Update</button>
            </form>
        </div>

        <!-- Category List -->
        <div>
            <h4>The list of all categories</h4>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="cat in categories" :key="cat.id">
                        <td> {{ cat.name }} </td>
                        <td>
                            <div class="row">
                                <div> <button @click="forUpdate(cat.id, cat.name)" class="btn btn-warning"> Edit </button> </div>
                                <div> <button @click="deleteCategory(cat.id)" class="btn btn-danger ml-3"> Delete </button> </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            category: {
                name: ''
            },

            isUpdating: false,

            update: {
                name: '',
                id: ''
            },
            categories: []
        }
    },

    mounted() {
        this.getCategories()

        bus.$on('category-show', () => {
            this.getCategories()
        })
    },

    methods: {
        addCategory() {
            axios.post(categoryURL, this.category)
                .then(response => {
                    bus.$emit('category-show')
                    this.category.name = ''
                })
                .catch(error => {
                    console.log(error)
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

        forUpdate (id, name) {
            this.update.id = id
            this.update.name = name
            this.isUpdating = true
        },

        updateCategory() {
            axios.put(categoryURL + '/' + this.update.id, this.update)
                .then(response => {
                    console.log(response)
                    this.update = []
                    this.isUpdating = false
                    bus.$emit('category-show')
                })
                .catch(error => {
                    console.log(error)
                })
        },

        deleteCategory(id) {

            axios.delete(categoryURL + '/' + id)
                .then(response => {
                    bus.$emit('category-show')
                })
                .catch(error => {
                    console.log(error.response)
                })
        }
    }
}
</script>
