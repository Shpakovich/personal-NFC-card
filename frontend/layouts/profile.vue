<script>
  import profileHeader from "../components/layouts/profile/profileHeader";
  import profileFooter from "../components/layouts/profile/profileFooter";
  import profileHeaderDesktop from "../components/layouts/profile/profileHeaderDesktop";
  import overlayConfirm from "../components/layouts/profile/overlayConfirm";
  import overlayNewFunc from "../components/layouts/profile/overlayNewFunc";

    export default {
      name: "profile",

      components: {
        profileHeader,
        profileFooter,
        profileHeaderDesktop,
        overlayConfirm,
        overlayNewFunc
      },

      beforeCreate() {
        if (!this.$auth.loggedIn){
          this.$router.push('/authorization');
        }
      },

      head () {
        return {
          meta: [
            { hid: 'robots', name: 'robots', content: 'noindex, nofollow' },
            { hid: 'og:description', property: 'og:description', content: 'myID это электронная визитка в которой можно указать ссылки на все свои соцсети и контакты.' },
            { hid: 'og:image:width', property: 'og:image:width', content: '196' },
            { hid: 'og:image:height', property: 'og:image:height', content: '196' }
          ]
        };
      }
    }
</script>

<template>
  <v-app class="fixMainContainer">
    <overlayConfirm />
    <overlayNewFunc />
    <profileHeader class="block xl:hidden" />
    <profileHeaderDesktop class="hidden xl:block" />
    <notifications width="300px" position="left bottom"/>
    <v-main class="main-container">
      <nuxt />
    </v-main>
    <profileFooter />
  </v-app>
</template>

<style lang="scss">
  .main-container {
    height: 100%!important;
    max-height: 100%!important;
    padding-top: 92px!important;
    padding-bottom: 98px!important;
    overflow: hidden!important;
    z-index: 30;
  }

  .fixMainContainer {
    position: relative;
    overflow: hidden;
    max-height: 100%;
    height: 100%;
  }
</style>
