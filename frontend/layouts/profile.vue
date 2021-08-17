<script>
  import profileHeader from "../components/layouts/profile/profileHeader";

    export default {
      name: "profile",

      components: {
        profileHeader
      },

      beforeCreate() {
        if (!this.$auth.loggedIn){
          this.$router.push('/authorization');
        }
      },

      data: () => ({
        links: [
          'Home',
          'About Us',
          'Team',
          'Services',
          'Blog',
          'Contact Us',
        ],
      })
    }
</script>

<template>
  <v-app>
    <profileHeader />
    <v-main>
      <nuxt />
    </v-main>
    <v-footer
      color="primary lighten-1"
      padless
    >
      <v-row
        justify="center"
        no-gutters
      >
        <v-btn
          v-for="link in links"
          :key="link"
          color="white"
          text
          rounded
          class="my-2"
        >
          {{ link }}
        </v-btn>
        <v-col
          class="primary lighten-2 py-4 text-center white--text"
          cols="12"
        >
          {{ new Date().getFullYear() }} — <strong>myID</strong>
        </v-col>
      </v-row>
    </v-footer>
  </v-app>
</template>

<style scoped>

</style>
