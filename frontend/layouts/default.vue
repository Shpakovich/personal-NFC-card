<script>
  export default {
    data () {
      return {
        clipped: false,
        drawer: false,
        fixed: false,
        items: [
          {
            icon: 'mdi-apps',
            title: 'Welcome',
            to: '/'
          },
          {
            icon: 'mdi-chart-bubble',
            title: 'Inspire',
            to: '/inspire'
          }
        ],
        miniVariant: false,
        right: true,
        rightDrawer: false,
        title: 'Vuetify.js'
      }
    }
  }
</script>

<template>
  <v-app class="app-container">
    <v-main >
        <nuxt keep-alive :keep-alive-props="{include: ['registration']}" />
    </v-main>
  </v-app>
</template>

<style lang="scss">
  @import "~/assets/styles/variables.scss";

  .app-container{
      max-width: 1200px;
      margin: auto;
  }

  .font-croc {
    font-family: 'CrocWeb', sans-serif;
  }
  .font-gilroy {
    font-family: 'Gilroy', sans-serif;
  }

  .theme--light.v-application {
    color: $text-color-primary;
  }

  .text-color-secondary {
    color: $text-color-secondary;
  }
</style>
