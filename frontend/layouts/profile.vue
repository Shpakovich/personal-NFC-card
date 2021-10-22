<script>
  import profileHeader from "../components/layouts/profile/profileHeader";
  import profileFooter from "../components/layouts/profile/profileFooter";
  import profileHeaderDesktop from "../components/layouts/profile/profileHeaderDesktop";
  import overlayConfirm from "../components/layouts/profile/overlayConfirm";

    export default {
      name: "profile",

      components: {
        profileHeader,
        profileFooter,
        profileHeaderDesktop,
        overlayConfirm
      },

      beforeCreate() {
        if (!this.$auth.loggedIn){
          this.$router.push('/authorization');
        }
      }
    }
</script>

<template>
  <v-app class="fixMainContainer">
    <overlayConfirm />
    <profileHeader class="block xl:hidden" />
    <profileHeaderDesktop class="hidden xl:block" />
    <v-main class="main-container">
      <nuxt />
    </v-main>
    <profileFooter />
  </v-app>
</template>

<style lang="scss">
  .fixMainContainer {
    overflow: hidden;
    max-height: 100vh;
    height: 100vh;
  }
</style>
