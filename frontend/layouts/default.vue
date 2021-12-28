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
    },

      head () {
          return {
              meta: [
                  { hid: 'description', name: 'description', content: '' },
                  { hid: 'robots', name: 'robots', content: 'index, follow' },
                  { hid: 'og:image', property: 'og:image', content: 'https://media.myid-card.ru/2021/12/28/06928b9e-37d5-4063-8552-114ab296068b.jpg' },
                  { hid: 'og:description', property: 'og:description', content: 'myID это электронная визитка в которой можно указать ссылки на все свои соцсети и контакты.' },
                  { hid: 'og:image:width', property: 'og:image:width', content: '196' },
                  { hid: 'og:image:height', property: 'og:image:height', content: '196' }
              ]
          };
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
