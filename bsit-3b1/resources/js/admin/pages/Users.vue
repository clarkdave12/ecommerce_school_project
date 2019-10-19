<template>
    <div class="container">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Addrerss</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td> {{ user.first_name }} </td>
                    <td> {{ user.last_name }} </td>
                    <td> {{ user.address }} </td>
                    <td> {{ user.email }} </td>
                    <td>
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data () {
        return {
            users: [],
        }
    },

    mounted() {
        this.getUserList()
    },

    methods: {
        getUserList() {
            axios.get(getUserURL)
                .then(response =>{
                    this.users = response.data.users
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>