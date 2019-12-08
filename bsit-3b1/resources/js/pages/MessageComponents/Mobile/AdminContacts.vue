<template>
    <div>
        <v-list dark subheader>
            <v-subheader>Registered Users</v-subheader>

            <v-list-item class="my-2 py-2" @click="message(contact.id)" v-for="contact in contacts" :key="contact.id">
                <v-list-item-avatar>
                    <img src="http://localhost:8000/images/monitor.jpeg" alt="">
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title v-text="contact.first_name + ' ' + contact.last_name"></v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </div>
</template>

<script>
export default {
    
    computed: {
        contacts() {
            return this.$store.state.users
        }
    },

    created () {
        this.$store.dispatch('GET_USERS')
            .catch(error => console.log(error))
    },

    methods: {
        message(id) {
            this.$store.commit('SET_RECEIVER', id)
            
            this.$router.push('/messages')
        }
    }

}
</script>