<template>
    <v-container>
        <v-card max-width="500" class="mx-auto">
            <v-toolbar dark>
                <v-toolbar-title>
                    Contact
                </v-toolbar-title>
                <v-spacer></v-spacer>

                <v-btn icon>
                    <v-icon>search</v-icon>
                </v-btn>
            </v-toolbar>

            <v-list max-height="400" v-if="!isAdmin">
                <v-list-item v-for="admin in admins" :key="admin.id" @click="setReceiver(admin.id)">
                    <v-list-item-content>
                        <v-list-item-title>
                            {{ admin.last_name }}, {{ admin.first_name }}
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>

            <v-list max-height="400" v-if="isAdmin">
                <v-list-item v-for="user in users" :key="user.id" @click="setReceiver(user.id)">
                    <v-list-item-content>
                        <v-list-item-title>
                            {{ user.last_name }}, {{ user.first_name }}
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-card>
    </v-container>
</template>

<script>
export default {

    data () {
        return {
            isAdmin: false,
        }
    },

    computed: {
        admins() {
            return this.$store.state.admins
        },

        users() {
            return this.$store.state.users
        },

        user() {
            return this.$store.state.user
        }
    },

    created() {
        
        this.$store.dispatch('USER_DATA')
            .then(() => {
                if(this.user.role == 'User')
                {
                    this.isAdmin = false
                    this.$store.dispatch('GET_ADMINS')
                }
                else if(this.user.role == 'Admin')
                {
                    this.isAdmin = true
                    this.$store.dispatch('GET_USERS')
                }
            })
    },

    methods: {
        setReceiver(id) {
            this.$store.commit('SET_RECEIVER', id)

            this.$router.push('/messages')
        }   
    }
}
</script>