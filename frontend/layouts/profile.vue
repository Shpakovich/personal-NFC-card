<script>
  import profileHeader from "../components/layouts/profile/profileHeader";
  import profileFooter from "../components/layouts/profile/profileFooter";

    export default {
      name: "profile",

      components: {
        profileHeader,
        profileFooter
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
    <profileHeader />
    <v-main>
      <nuxt />
    </v-main>
    <profileFooter />
  </v-app>
</template>

<style scoped>

</style>
