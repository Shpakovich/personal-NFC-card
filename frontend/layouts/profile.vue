<script>
  import profileHeader from "../components/layouts/profile/profileHeader";
  import profileFooter from "../components/layouts/profile/profileFooter";
  import profileHeaderDesktop from "../components/layouts/profile/profileHeaderDesktop";

    export default {
      name: "profile",

      components: {
        profileHeader,
        profileFooter,
        profileHeaderDesktop
      },

      data: () => ({
        absolute: true,
        overlay: false,
      }),

      beforeCreate() {
        if (!this.$auth.loggedIn){
          this.$router.push('/authorization');
        }
      }
    }
</script>

<template>
  <v-app class="fixMainContainer">
    <v-overlay
            :absolute="absolute"
            :value="overlay"
    >
      <v-btn
              color="success"
              @click="overlay = false"
      >
        //
      </v-btn>
    </v-overlay>
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
    position: relative;
    overflow: hidden;
    max-height: 100vh;
    height: 100vh;
  }
</style>
