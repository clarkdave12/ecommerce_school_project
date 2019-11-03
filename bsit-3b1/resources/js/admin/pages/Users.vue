<template>
    <div>
        <h1>Manage Users</h1>

        <v-simple-table dark>
            <thead>
                <th> NAME </th>
                <th> EMAIL </th>
                <th>ACTIONS</th>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td> {{ user.last_name }}, {{ user.first_name }} </td>
                    <td> {{ user.email }} </td>
                    <td>
                        <v-btn small block color="error" @click="removeUser(user.id)">
                            Remove
                        </v-btn>
                    </td>
                </tr>
            </tbody>
        </v-simple-table>

    </div>
</template>

<script>
export default {
    
    computed:
    {
        users()
        {
            return this.$store.state.usersManage
        }
    },

    created ()
    {
        this.$store.dispatch('GET_USERS_MANAGE')
            .then(() => {
                console.log(this.users)                
            })
            .catch(error => {
                console.log(error)
            })
    },

    methods: 
    {
        removeUser(id)
        {
            this.$store.dispatch('REMOVE_USER', id)
                .then(() => {
                    this.$store.dispatch('GET_USERS_MANAGE')
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>