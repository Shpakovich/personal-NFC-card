<script>
    export default {
        name: "createProfile",

      beforeCreate() { // TODO вынести в middleware
        if (!this.$auth.loggedIn){
          this.$router.push('/authorization');
        }
      }
    }
</script>

<template>
  <v-app>
    <v-main>
      <nuxt />
    </v-main>
  </v-app>
</template>

<style scoped>

</style>
