<template>
    <div>
        <v-btn icon @click="modal = !modal">
            <v-icon>edit</v-icon>
        </v-btn>

        <v-dialog max-width="400" dark v-model="modal">
            <v-card dark class="px-3 py-3">
                <span class="headline">
                    <h3>Change Address</h3>
                </span>
                <div class="my-4"></div>
                <v-card-text>
                    <v-textarea v-model="address" dark label="New Address"></v-textarea>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="primary" @click="changeAddress()">Done</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props: ['user'],
    data () {
        return {
            modal: false,
            address: ''
        }
    },

    methods: {
        changeAddress() {
            const data = {
                id: this.user.id,
                address: this.address
            }
            axios.post(api.change_address, data)
                .then(response => {
                    alert(response.data.success)
                    bus.$emit('profile-changed')
                    this.modal = false
                })
                .catch(error => {
                    console.log(error.response)
                })
        }
    }
}
</script>