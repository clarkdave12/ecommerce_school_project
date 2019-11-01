<template>
    <v-container>
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

        <v-footer dark fixed class="py-2">
                <input v-model="messageData.message" type="text" id="text-box" placeholder="Your message...">
                <v-btn icon @click="send">
                    <v-icon>send</v-icon>
                </v-btn>
        </v-footer>
    </v-container>
</template>

<script>
export default {

    data () {
        return {
            messageData: {
                message: '',
                sender: '',
                receiver: ''
            }
        }
    },
    
    created () {

        if(localStorage.getItem('token'))
        {
            this.$store.dispatch('USER_DATA')
                .then(() => {
                    
                    this.messageData.sender = this.user.id

                    this.$store.dispatch('GET_MESSAGES', this.user.id)

                    const channel = Echo.channel('message')
                        channel.listen('.MessageSent', () => {
                            this.$store.dispatch('GET_MESSAGES', this.user.id)
                        })
                })
        }

        if(this.$store.state.receiver == '')
        {
            this.$router.push('/contact')
        }
        else
        {
            this.messageData.receiver = this.$store.state.receiver
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

    methods: {
        
        send () {
            
            const data = {
                message: this.messageData.message,
                sender: this.user.id,
                receiver: this.messageData.receiver
            }

            axios.post('http://localhost:8000/api/messages', data)
                .then(response => {
                    this.messageData.message = ''
                })
                .catch(error => {
                    console.log(error.response)
                })
        }
    }
}
</script>

<style scoped>

#text-box {
    background: #a0a0a0a0;
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 15px;
    color: white;
    width: 85%;
    margin-right: 13px;
    caret-color: white;
    border-radius: 20px;
}

#text-box:focus {
    outline: none;
}

#chat-box {
    height: 100%;
    width: 100%;
    max-height: 100vh;
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