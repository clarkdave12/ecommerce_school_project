<template>
    <div class="container">
        <h1>Register</h1>

        <!-- Registration Form -->
        <div class="fomr-group">
            <form @submit.prevent="register()">
                <label>First Name</label>
                <input type="text" class="form-control" v-model="user.first_name">

                <label for="">Last Name</label>
                <input type="text" class="form-control" v-model="user.last_name">

                <label for="">Address</label>
                <textarea class="form-control" rows="4" v-model="user.address"></textarea>

                <label for="">Email</label>
                <input type="text" class="form-control" v-model="user.email">

                <label for="">Password</label>
                <input type="password" class="form-control" v-model="user.password">

                <label for="">Confirm Password</label>
                <input type="password" class="form-control" v-model="confirmPassword">

                <button type="submit" class="btn btn-primary mt-3">Register</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            user: {
                first_name: '',
                last_name: '',
                address: '',
                email: '',
                password: ''
            },
            confirmPassword: ''
        }
    },

    methods: {
        register () {
            axios.post(registerURL, this.user)
                .then(response => {
                    this.$router.push('/login')
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>