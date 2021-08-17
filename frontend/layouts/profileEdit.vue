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
    <v-app>
        <v-main class="main-container">
            <nuxt />
        </v-main>
        <profileFooter />
    </v-app>
</template>

<style lang="scss">
    .main-container {
        height: calc(100% - 114px - 92px);max-height: calc(100% - 114px - 92px); overflow: scroll;
    }
</style>
