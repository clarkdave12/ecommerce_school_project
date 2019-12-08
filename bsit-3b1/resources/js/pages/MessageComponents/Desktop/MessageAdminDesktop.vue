<template>
    <!-- <div> -->
        <div class="row">
            <div class="col-md-5 col-lg-4">
                <v-list dark subheader>
                    <v-subheader>Registered Users</v-subheader>

                    <v-list-item class="my-2 py-2" @click="setReceiver(contact.id)" v-for="contact in contacts" :key="contact.id">
                        <v-list-item-avatar>
                            <img src="http://localhost:8000/images/monitor.jpeg" alt="">
                        </v-list-item-avatar>

                        <v-list-item-content>
                            <v-list-item-title class="contact-name" v-text="contact.first_name + ' ' + contact.last_name"></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </div>

            <div class="col-md-7 col-lg-8">
                <v-list-item v-if="message.receiver">
                    <v-list-item-avatar class="mr-3">
                        <img src="http://localhost:8000/images/monitor.jpeg" alt="">
                    </v-list-item-avatar>

                    <v-list-item-content>
                        <v-list-item-title class="contact-name" v-text="user.first_name + ' ' + user.last_name"></v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-sheet dark id="chat-box" class="px-3 py-5" v-chat-scroll>
                    <div class="bubble-container" v-for="message in messages" :key="message.id">
                        <v-card class="sender mb-5" v-if="message.receiver == 'admin'">
                            <v-card-text>
                                {{ message.message }}
                            </v-card-text>
                        </v-card>   
                        <v-card class="receiver ml-auto mb-5 primary" v-if="message.sender == 'admin'">
                            <v-card-text>
                                {{ message.message }}
                            </v-card-text>
                        </v-card>
                    </div>
                </v-sheet>

                <div class="row px-3 py-2">
                    <v-text-field placeholder="Type message here..." v-model="message.message" @click:append="send" solo dark append-icon="send"></v-text-field>
                </div>
            </div>
        </div>
    <!-- </div> -->
</template>

<script>
export default {

    data () {
        return {
            message: {
                sender: 'admin',
                receiver: '',
                message: ''
            },
            user: [],
            messages: []
        }
    },

    computed: {
        contacts() {
            return this.$store.state.users
        },
    },

    created () {

        this.$store.dispatch('GET_USERS')
            .catch(error => console.log(error))

        const channel = Echo.channel('message')
            channel.listen('.MessageSent', () => {
                this.$store.dispatch('GET_MESSAGES', this.user.id)
                    .catch(error => console.log(error))
            })

        bus.$on('sent', () => {
            this.message.message = ''
            this.setReceiver(this.message.receiver)
        })
    },

    methods: {

        setReceiver(id) {
            this.message.receiver = id
            this.getUser(id)
            axios.get('http://localhost:8000/api/get_message_history/' + id)
                .then(response => {
                    this.messages = response.data
                })
                .catch(error => console.log(error.response))
        },

        getUser(id) {

            axios.get('http://localhost:8000/api/get_user_data/' + id)
                .then(response => this.user = response.data)
                .catch(error => console.log(error.response))
        },

        send () {

            axios.post(api.message, this.message)
                .then(() => bus.$emit('sent'))
                .catch(error => console.log(error.response))
        },
    }
}
</script>

<style scoped>
#chat-box {
    height: 80%;
    width: 100%;
    min-height: 60vh;
    max-height: 80vh;
    overflow: scroll;
}

.sender {
    max-width: 60%;
    overflow-wrap: break-word;
}

.receiver {
    max-width: 60%;
    overflow-wrap: break-word;
}

.contact-name {
    color: #fff;
}
</style>