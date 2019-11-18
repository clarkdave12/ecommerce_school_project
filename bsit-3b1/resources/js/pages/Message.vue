<template>
    <v-container>
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

        <v-footer dark fixed class="py-2 mt-3">
                <v-spacer></v-spacer>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <input v-model="messageData.message" type="text" id="text-box" placeholder="Your message...">
                    <v-btn icon @click="send">
                        <v-icon>send</v-icon>
                    </v-btn>
                </div>
                <v-spacer></v-spacer>
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
                    this.messageData.message = ''
                    alert('No Connection')
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