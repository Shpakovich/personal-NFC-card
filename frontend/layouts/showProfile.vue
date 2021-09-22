<script>
    import profileHeader from "../components/layouts/profile/profileHeader";
    import profileHeaderDesktop from "../components/layouts/profile/profileHeaderDesktop";

    export default {
        name: "showProfile",

        components: {
            profileHeader,
            profileHeaderDesktop
        }
    }
</script>

<template>
    <v-app class="fixMainContainer">
        <profileHeader class="block xl:hidden" />
        <profileHeaderDesktop class="hidden xl:block" />
        <v-main class="main-container__without-footer">
            <nuxt />
        </v-main>
    </v-app>
</template>

<style lang="scss">
    .v-main__wrap {
        overflow: hidden;
    }
</style>
