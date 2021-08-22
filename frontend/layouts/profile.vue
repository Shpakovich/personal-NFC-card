<script>
  import profileHeader from "../components/layouts/profile/profileHeader";
  import profileFooter from "../components/layouts/profile/profileFooter";

    export default {
      name: "profile",

      components: {
        profileHeader,
        profileFooter
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
        Hide Overlay
      </v-btn>
    </v-overlay>
    <profileHeader />
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
