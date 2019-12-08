<template>
    <div>
        <div class="row">
            <v-spacer></v-spacer>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <v-sheet dark id="chat-box" class="px-3 py-5" v-chat-scroll>
                    <div class="bubble-container" v-for="message in messages" :key="message.id">
                        <v-card class="sender mb-5" v-if="message.receiver == user.id">
                            <v-card-text>
                                {{ message.message }}
                            </v-card-text>
                        </v-card>   
                        <v-card class="receiver ml-auto mb-5 primary" v-if="message.sender == user.id">
                            <v-card-text>
                                {{ message.message }}
                            </v-card-text>
                        </v-card>
                    </div>
                </v-sheet>
            </div>
            <v-spacer></v-spacer>
        </div>

        <div class="row">
            <v-spacer></v-spacer>
            <div class="col-sm col-md-6 col-lg-6">
                <v-text-field placeholder="Type message here..." @click:append="send" solo dark append-icon="send"></v-text-field>
            </div>
            <v-spacer></v-spacer>
        </div>
    </div>
</template>

<script>
export default {
    
    props: ['user'],

    data () {
        return {
            message: {
                receiver: 'admin',
                sender: 0,
                message: ''
            },
        }
    },

    computed: {
        messages() {
            return this.$store.state.messages
        }
    },

    created () {
        this.message.sender = this.user.id

        this.$store.dispatch('GET_MESSAGES', this.user.id)
            .catch(error => console.log(error))

        const channel = Echo.channel('message')
        channel.listen('.MessageSent', () => {
            this.$store.dispatch('GET_MESSAGES', this.user.id)
                .catch(error => console.log(error))
        })
    },

    methods: {
        send() {
            axios.post(api.message, this.message)
                .then(() => this.message.message = '')
                .catch(error => console.log(error))
        }
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


</style>