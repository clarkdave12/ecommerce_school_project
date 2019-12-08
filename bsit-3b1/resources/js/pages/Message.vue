<template>
    <div>
        <MessageUser v-if="user.role == 'User'" :user="user" />
        <MessageAdmin class="hidden-md-and-up" v-if="user.role == 'Admin'" />
        <MessageAdminDesktop class="hidden-sm-and-down" v-if="user.role == 'Admin'" />
    </div>
</template>

<script>

import MessageUser from './MessageComponents/Mobile/MessageUser'
import MessageAdmin from './MessageComponents/Mobile/MessageAdmin'
import MessageAdminDesktop from './MessageComponents/Desktop/MessageAdminDesktop'

export default {

    components: {
        MessageUser,
        MessageAdmin,
        MessageAdminDesktop
    },
    
    created () {
        this.$store.dispatch('USER_DATA')
    },

    computed: {
        user() {
            return this.$store.state.user
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