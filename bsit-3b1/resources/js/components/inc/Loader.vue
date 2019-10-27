<template>
    <v-dialog v-model="this.$store.state.loader" persistent width="300">
        <v-card dark>
            <v-card-text>Loading...</v-card-text>

            <v-progress-linear height="6" dark indeterminate></v-progress-linear>
        </v-card>
    </v-dialog>
</template>