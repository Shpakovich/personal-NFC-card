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
        <notifications width="300px" position="left bottom"/>
        <v-main class="main-container__without-header">
            <nuxt />
        </v-main>
        <profileFooter />
    </v-app>
</template>

<style lang="scss">
    .main-container__without-header {
        height: calc(100% - 98px);
        max-height: calc(100% - 98px);
        overflow: scroll;
    }
    .main-container__without-footer {
        height: 100%!important;
        max-height: 100%!important;
        padding-top: 92px!important;
        overflow: hidden;
    }
    .main-container__all-height {
        height: 100%;
        max-height: 100%;
        overflow: hidden;
    }
</style>
