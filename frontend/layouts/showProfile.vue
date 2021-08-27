<script>
    import profileHeader from "../components/layouts/profile/profileHeader";

    export default {
        name: "showProfile",

        components: {
            profileHeader
        }
    }
</script>

<template>
    <v-app class="fixMainContainer">
        <profileHeader />
        <v-main class="main-container__without-footer">
            <nuxt />
        </v-main>
    </v-app>
</template>

<style scoped>

</style>
