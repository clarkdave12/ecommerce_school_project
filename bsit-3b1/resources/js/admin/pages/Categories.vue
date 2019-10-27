
<template>
    <v-container>
        <h3 class="subheading" id="page-title">
            categories
        </h3>
        <v-divider></v-divider>

        <v-btn @click="add = !add" small right outlined class="pa-2" dark>Add Category</v-btn>
                

        <v-layout row wrap>
            <v-flex xs12 sm6 md4 lg3 v-for="cat in categories" :key="cat.id">
                
                <v-card dark class="pa-3 ma-3">
                    <v-card-text>
                        <div class="subheading white--text category-name"> {{ cat.name }} </div>
                    </v-card-text>

                    <v-card-actions>
                        <v-btn small color="warning" @click="forUpdate(cat.id, cat.name)"> edit </v-btn>
                        <v-btn small color="red" @click="deleteCategory(cat.id)">delete</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>

        <div v-if="categories == 0" class="mt-3">
            <h4> No categories yet </h4>
        </div>

        <!-- For Adding Category -->
        <v-dialog v-model="add" scrollable>
            <v-card dark>
                <form @submit.prevent="addCategory()">
                    <v-card-title>
                        <span class="headline"> Add Category </span>
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12" sm="6" md="4">
                                    <v-text-field v-model="category.name" dark label="Category Name"></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text type="submit"> save </v-btn>
                    </v-card-actions>
                </form>
            </v-card>
        </v-dialog>

        <!-- For Updating Category -->
        <v-dialog v-model="isUpdating" scrollable>
            <v-card dark>
                <form @submit.prevent="updateCategory()">
                    <v-card-title>
                        <span class="headline"> Update Category </span>
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12" sm="6" md="4">
                                    <v-text-field v-model="update.name" dark label="Category Name"></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text type="submit"> save </v-btn>
                    </v-card-actions>
                </form>
            </v-card>
        </v-dialog>

    </v-container>
</template>

<script>
export default {
    data () {
        return {
            category: {
                name: ''
            },
            add: false,
            isUpdating: false,

            update: {
                name: '',
                id: ''
            },
        }
    },

    computed: {
        categories() {
            return this.$store.state.categories
        }
    },

    created () {
        this.$store.dispatch('GET_CATEGORIES')

        bus.$on('category-show', () => {
            this.$store.dispatch('GET_CATEGORIES')
        })
    },

    methods: {
        addCategory() {
            this.$store.dispatch('ADD_CATEGORY', this.category)
                .then(() => {
                    this.category.name = ''
                    bus.$emit('category-show')
                    this.add = false
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
            
            this.$store.dispatch('UPDATE_CATEGORY', this.update)
                .then(() => {
                    this.isUpdating = false
                    bus.$emit('category-show')
                })
                .catch(error => {
                    console.log(error)
                })
        },

        deleteCategory(id) {

            this.$store.dispatch('DELETE_CATEGORY', id)
                .then(() => {
                    bus.$emit('category-show')
                })
                .catch(error => {
                    console.log(error)
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
        max-width: 50%;
    }

    #table-actions {
        justify-content: center;
    }

    #add-btn {
        width: 100%;
    }

    .btn-controls {
        width: 100%;
    }

    .category-name {
        text-transform: uppercase;
        color: #ffffff;
        overflow-wrap: break-word;
    }
</style>