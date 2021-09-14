<script>
    import profileFooter from "../components/layouts/profile/profileFooter";

    export default {
        name: "profileEdit",

        components: {
            profileFooter
        },

        beforeCreate() {
            if (!this.$auth.loggedIn){
                this.$router.push('/authorization');
            }
        },

        methods: {
            setEditUser() {
                this.$refs.someVue.alertOn()
            },
        }
    }
</script>

<template>
    <v-app class="fixMainContainer">
        <v-main class="main-container__without-header">
            <nuxt />
        </v-main>
        <profileFooter />
    </v-app>
</template>

<style lang="scss">
    .main-container {
        height: calc(100% - 114px - 92px);max-height: calc(100% - 114px - 92px);
        overflow: scroll;
        @media (min-width: 1280px) { // todo вынести в переменную
            overflow: hidden;
        }
    }
    .main-container__without-header {
        height: calc(100% - 114px);
        max-height: calc(100% - 114px);
        overflow: scroll;
    }
    .main-container__without-footer {
        height: calc(100% - 92px);
        max-height: calc(100% - 92px);
        overflow: scroll;
    }
    .main-container__all-height {
        height: 100%;
        max-height: 100%;
        overflow: scroll;
    }
</style>
