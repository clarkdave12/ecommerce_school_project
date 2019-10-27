<template>
    <v-container fluid>
        <!-- For User -->
        <div v-if="!isAdmin">
            <v-card dark>
                <v-card-actions class="mx-2 py-2">
                    <v-avatar size="40" class="mr-3">
                        <img src="http://localhost:8000/images/monitor.jpeg" alt="">
                    </v-avatar>
                    <p>Chat Bot</p>
                </v-card-actions>
            </v-card> 
            <v-card dark id="box" class="px-3 py-2">
                <div v-for="message in messages" :key="message.id">
                    <v-card-actions v-if="message.sender_id == user.id">
                        <v-spacer></v-spacer>
                        <v-card color="primary" max-width="180">
                            <v-card-text class="sender-text white--text"> {{ message.message }} </v-card-text>
                        </v-card>
                        <v-avatar size="20" class="ml-3">
                            <img src="http://localhost:8000/images/monitor.jpeg" alt="">
                        </v-avatar>
                    </v-card-actions>

                    <v-card-actions v-if="message.receiver_id == user.id">
                        <v-avatar size="20" class="mr-3">
                            <img src="http://localhost:8000/images/monitor.jpeg" alt="">
                        </v-avatar>
                        <v-card color="grey lighten-3" max-width="180">
                            <v-card-text class="sender-text black--text"> {{ message.message }} </v-card-text>
                        </v-card>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </div>
            </v-card>
        </div>

        <!-- Sending Message -->
        <v-footer fixed dark height="70">
            <v-text-field dark outlined label="Message" v-model="message"></v-text-field>
            <v-spacer></v-spacer>
            <v-btn small class="mb-8" color="primary" @click="sendMessage()">send</v-btn>
        </v-footer>
    </v-container>
</template>

<script>
export default {
    
    data () {
        return {
            isAdmin: false,
            message: ''
        }
    },

    computed: {
        user() {
            return this.$store.state.user
        },

        messages() {
            return this.$store.state.messages
        }
    },

    created() {
        this.$store.dispatch('USER_DATA')
            .then(() => {
                if(this.user.role == 'Admin') {
                    this.isAdmin = true
                }
                else if(this.user.role == 'User') {
                    this.isAdmin = false
                }
            })

        this.$store.dispatch('GET_MESSAGES', this.$route.params.user_id)
    },

    methods: {
        sendMessage() {
            
            const data = {
                sender_id: this.$route.params.user_id,
                receiver_id: 1,
                message: this.message
            }

            this.$store.dispatch('SEND_MESSAGE', data)
                .then(() => {
                      this.$store.dispatch('GET_MESSAGES', this.$route.params.user_id)

                      const replyPayload = {
                          receiver_id: data.sender_id,
                          message: data.message
                      }
                      this.$store.dispatch('GET_REPLY', replyPayload)
                            .then(() => {
                                this.$store.dispatch('GET_MESSAGES', this.$route.params.user_id)
                            })
                            .catch(error => {
                                console.log(error)
                            })
                })
        }
    }
}
</script>

<style scoped>
    #box {
        height: 430px;
        width: 100%;
        max-height: 450px;
        max-width: 100%;
        overflow: scroll;
    }

</style>