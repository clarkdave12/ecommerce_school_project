<template>
    <div>
        <v-btn icon @click="modal = !modal">
            <v-icon>edit</v-icon>
        </v-btn>

        <v-dialog dark v-model="modal" max-width="400">
            <v-card dark class="px-3 py-3">
                <span class="headline">
                    <h2>Change Last Name</h2>
                </span>
                <div class="my-4"></div>
                <v-card-text>
                    <v-text-field dark label="New First Name" v-model="firstname"></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="primary" @click="changeName()">Done</v-btn>
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
            firstname: ''
        }
    },
    
    methods: {
        changeName() {
            const data = {
                id: this.user.id,
                last_name: this.firstname
            }

            axios.post(api.change_lastname, data)
                .then(response => {
                    alert(response.data.success)
                    bus.$emit('profile-changed')
                    this.modal = false
                })
                .catch(Error => {
                    console.log(error.response)
                })
        }
    }
}
</script>