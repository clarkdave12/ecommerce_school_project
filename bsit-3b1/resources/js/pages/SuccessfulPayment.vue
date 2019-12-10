<template>
    <div>
        <h1>Successful payment</h1>
        <v-btn color="success" to="/products">
            Go Back to products
        </v-btn>
    </div>
</template>

<script>
export default {
    
    computed: {
        user() {
            return this.$store.state.user
        }
    },

    created () {
    
        this.$store.dispatch('USER_DATA')
            .then(() => {
                axios.delete('http://bsupctech.epizy.com/api/clear_cart/'+ this.user.id)
                    .then(response => {
                        console.log(response)
                    })
                    .catch(error => {
                        console.log(error.response)
                    })
            })
            .catch(error => {
                console.log(error)
            })
    }
}
</script>