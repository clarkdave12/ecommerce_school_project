<template>
    <v-container fluid>
        <v-row>
            <v-col sm="4">
                <v-card>
                    <img id="product-image" :src="'http://bsupctech.epizy.com/' + product.image" :alt="product.name">
                </v-card>
            </v-col>
            <v-col sm="8">
                <h3 id="product-title"> {{ product.name }} </h3>
            </v-col>
        </v-row>

        <v-row>
            <v-col sm="12">
                <v-simple-table dark>
                    <thead>
                        <tr>
                            <th class="text-left"> <strong> LABEL </strong> </th>
                            <th class="text-left"> <strong> SPECS </strong> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="spec in specs" :key="spec.id">
                            <td> <strong> {{ spec.label }} </strong> </td>
                            <td> {{ spec.specs }} </td>
                        </tr>
                    </tbody>
                </v-simple-table>
            </v-col>
        </v-row>

        <v-footer dark fixed v-if="isAdmin">
            <v-spacer></v-spacer>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <v-text-field label="Label" v-model="label" dark></v-text-field>
                <v-text-field label="Specs" v-model="spec" dark></v-text-field>
                <v-btn color="success" block @click="addSpecification">
                    add specification
                </v-btn>
            </div>
            <v-spacer></v-spacer>
        </v-footer>
    </v-container>
</template>

<script>
export default {
    
    data () {
        return {
            spec: '',
            label: '',
            isAdmin: false,
        }
    },

    computed: {
        product() {
            return this.$store.state.product
        },

        user() {
            return this.$store.state.user
        },

        specs() {
            return this.$store.state.specs
        }

    },

    created () {
        
        this.$store.dispatch('USER_DATA')
            .then(() => {
                if(this.user.role == 'User') {
                    this.isAdmin = false
                }
                else if(this.user.role == 'Admin') {
                    this.isAdmin = true
                }
                else {
                    this.isAdmin = false
                }
            })

        this.$store.dispatch('GET_SPECS', this.$route.params.product_id)
            .then(() => {
                console.log(this.specs)
            })
        
        this.$store.dispatch('GET_PRODUCT_INFO', this.$route.params.product_id)
            .catch(error => {
                console.log(error)
            })
    },

    methods: {

        addSpecification() {
            
            const data = {
                label: this.label,
                specs: this.spec,
                product_id: this.$route.params.product_id,
            }

            axios.post(api.specs, data)
                .then(response => {
                    this.$store.dispatch('GET_SPECS', this.$route.params.product_id)
                    this.spec = ''
                    this.label = ''
                })
                .catch(error => {
                    console.log(error.response)
                })
        }
    }

}
</script>

<style scoped>

    #product-image {
        width: 100%;
    }

    table {
        color: white;
    }

    #product-title {
        text-transform: uppercase;
        color: #fff;
        font-size: 1.5em;
    }

    .product-specs {
        overflow-y: scroll;
    }

</style>