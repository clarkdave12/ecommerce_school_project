<template>
    <div>
        <v-btn icon @click="modal = !modal">
            <v-icon>edit</v-icon>
        </v-btn>

        <v-dialog max-width="400" dark v-model="modal">
            <v-card dark class="py-3 px-3">
                <span class="headline">
                    <h2> Change Email </h2>
                </span>
                <div class="my-4"></div>
                <v-card-text>
                    <v-text-field label="New Email" dark v-model="email"></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="changeEmail" color="primary">Done</v-btn>
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
            email: ''
        }
    },

    methods: {
        changeEmail() {
            const data = {
                id: this.user.id,
                email: this.email
            }
            
            axios.post(api.change_email, data)
                .then(response => {
                    alert(response.data.success)
                    this.modal = false
                    bus.$emit('profile-changed')
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>