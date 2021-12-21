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
    <v-app class="fixMainContainer">
        <notifications width="300px" position="left bottom"/>
        <v-main class="main-container__all-height">
            <nuxt />
        </v-main>
    </v-app>
</template>

<style scoped>

</style>
