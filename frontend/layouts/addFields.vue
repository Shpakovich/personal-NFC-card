<script>
    export default {
        name: "addFields",

        beforeCreate() {
            if (!this.$auth.loggedIn){
                this.$router.push('/authorization');
            }
        }
    }
</script>

<template>
    <v-app>
        <v-main class="main-container">
            <nuxt />
        </v-main>
    </v-app>
</template>

<style scoped>

</style>
