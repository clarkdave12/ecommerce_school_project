<template>
    <div class="container">
        <h1>Create Profile</h1>
        <div class="col-lg-8 col-sm-12">
            <div class="py-2 px-3">
                <form @submit.prevent="createProfile">
                    <div class="input-group mb-3">
                        <input placeholder="Age (Optional)" type="number" class="form-control" v-model="profile.age">
                    </div>
                    <div class="form-group mb-3">
                        <label>Gender</label>
                        <select v-bind="profile.gender" class="form-control">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <input placeholder="Work (Optional)" type="text" class="form-control" v-model="profile.work">
                    </div>
                    <div class="input-group mb-3">
                        <input placeholder="Regligion (Optional)" type="text" class="form-control" v-model="profile.religion">
                    </div>

                    <input @change="imageChanged" type="file" class="form-control mb-3" >

                    <button type="submit" class="btn btn-primary">Create Profile</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            profile: {
                age: '',
                gender: '',
                work: '',
                image: '',
                religion: '',
                user_id: ''
            }
        }
    },

    mounted () {
        this.profile.user_id = this.$route.params.user_id
    },

    methods: {
        imageChanged (e) {
            const fileReader = new FileReader()
            fileReader.readAsDataURL(e.target.files[0])
            fileReader.onload = (e) => {
                this.profile.image = e.target.result
            }
        },
        
        createProfile() {
            axios.post(userProfileURL, this.profile)
                .then(response => {
                    this.$router.push('/profile/' + this.$route.params.user_id)
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>

<style scoped>
.form-inputs {
        width: 100%;
        background: black;
        border: none;
        border-bottom: 2px red solid;
        color: #ffffff;
        font-size: 1.2em;
        font-weight: 300;
        letter-spacing: 2px;
    }
</style>