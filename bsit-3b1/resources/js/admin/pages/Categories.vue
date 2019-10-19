<template>
    <div class="container">
        <admin-navbar></admin-navbar>
        <h3 id="page-title">Categories</h3>
        <hr>

        <div class="row">
            <div class="col-lg-6">
                <!-- For adding -->
                <div class="category-controls px-5 py-3 mb-3">
                    <form @submit.prevent="addCategory()">
                        <h3 class="control-title"> Add Category </h3>
                        <input v-model="category.name" type="text" class="my-3 inputs" placeholder="Category name">

                        <button type="submit" class="btn btn-success mt-3">Create</button>
                    </form>
                </div>

                <!-- For Updating -->
                <div v-if="isUpdating" class="category-controls px-5 py-3 mb-3">
                    <form @submit.prevent="updateCategory()">
                        <h3 class="control-title"> Update Category </h3>
                        <input v-model="update.name" type="text" class="inputs" placeholder="New Category name">

                        <button type="submit" class="btn btn-success mt-3">Update</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Category List -->
                <div>
                    <table class="table">
                        <thead id="table-bar">
                            <tr>
                                <th class="table-title">Category</th>
                                <th class="table-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="cat in categories" :key="cat.id">
                                <td class="table-data"> {{ cat.name }} </td>
                                <td>
                                    <div id="table-actions" class="row">
                                        <div> <button @click="forUpdate(cat.id, cat.name)" class="btn btn-warning"> Edit </button> </div>
                                        <div> <button @click="deleteCategory(cat.id)" class="btn btn-danger ml-3"> Delete </button> </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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
                    console.log(error.response)
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



<style scoped>
    #page-title {
        font-family: 'batmfa';
        color: #800000;
        font-size: 2em;
    }

    .category-controls {
        border: 2px #800000 solid;
        background: black;
    }

    .control-title {
        font-family: 'batmfa';
        color: #ffffff;
        font-size: 1.3em;
    }

    .inputs {
        width: 100%;
        background: black;
        border: none;
        border-bottom: 2px red solid;
        color: red;
        font-size: 1em;
    }

    .inputs:focus {
        outline: none;
    }

    #table-bar {
        background: black;
    }

    .table-title {
        font-family: 'batmfa';
        font-size: 1.2em;
        letter-spacing: 4px;
        text-align: center;
        color: #ffffff;
    }

    .table-data {
        font-size: 1.2em;
        text-transform: uppercase;
        color: #ffffff;
        letter-spacing: 1px;
        font-weight: 300;
        text-align: center;
    }

    #table-actions {
        justify-content: center;
    }
</style>