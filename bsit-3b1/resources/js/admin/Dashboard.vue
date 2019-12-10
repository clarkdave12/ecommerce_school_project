<template>
    <v-container>
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-3">
                <v-text-field dark type="number" v-model="year" label="Year"></v-text-field>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-3">
                <v-text-field dark type="number" v-model="month" label="Month"></v-text-field>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-3">
                <v-btn block color="primary" class="mt-3" @click="getSales"> Show Sales </v-btn>
            </div>
        </div>

        <v-simple-table dark>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="sale in sales" :key="sale.id">
                    <td> {{ sale.order_id }} </td>
                    <td> PHP {{ sale.amount }} </td>
                    <td> {{ sale.created_at }} </td>
                </tr>
            </tbody>
        </v-simple-table>

        <v-btn v-if="sales.length > 0" color="primary" class="mt-5" @click="printPDF">Print PDF</v-btn>
    </v-container>
</template>

<script>
export default {
    data () {
        return {
            year: '',
            month: '',
            sales: []
        }
    },

    methods: {
        getSales() {
            axios.get('http://bsupctech.epizy.com/api/get_sales/' + this.month + '/' + this.year)
                .then(response => {
                    this.sales = response.data
                })
                .catch(error => {
                    console.log(error.response)
                })
        },

        printPDF() {
            window.print();
        }
    }
}
</script>

<style scoped>

</style>