<script>
    import profileEditHeader from "../components/layouts/profile/profileEditHeader";
    import profileFooter from "../components/layouts/profile/profileFooter";

    export default {
        name: "profileEdit",

        components: {
            profileFooter,
            profileEditHeader
        },

        beforeCreate() {
            if (!this.$auth.loggedIn){
                this.$router.push('/authorization');
            }
        }
    }
</script>

<template>
    <v-app>
        <profileEditHeader />
        <v-main>
            <nuxt />
        </v-main>
        <profileFooter />
    </v-app>
</template>

<style scoped>

</style>
