<script>
  import socialIconsBlock from '~/components/socialIconsBlock'
    export default {
      name: "page",
      layout: "profile",

      components: {
        socialIconsBlock
      },

      async mounted() {
        let profile;

        await this.$store.dispatch('profile/getAllProfilesInfo')
                .then((profiles) => { console.log(profiles) })
                .catch((e) => console.log('profile/getAllProfilesInfo error' + e));
        // Получем id профиля по пользвоателю


        return profile;
      }
    }
</script>

<template>
  <v-container>
    <v-row justify="space-around">
      <v-card width="400">
        <v-img
          height="300px"
          src="https://images.pexels.com/photos/2404554/pexels-photo-2404554.jpeg?cs=srgb&dl=pexels-rizwan-malik-2404554.jpg&fm=jpg"
        >
          <v-app-bar
            flat
            color="rgba(0, 0, 0, 0)"
          >
            <v-app-bar-nav-icon color="white"></v-app-bar-nav-icon>

            <v-toolbar-title class="title white--text pl-0">
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn
              color="white"
              icon
            >
              <v-icon @click="$auth.logout()">mdi-exit-to-app</v-icon>
            </v-btn>
          </v-app-bar>

          <v-card-title class="absolute bottom-0 white--text">
            <p class="ml-3">
              John Doe
            </p>
          </v-card-title>
        </v-img>

        <v-card-text>
          <div class="font-weight-bold ml-8 mb-2">
            <socialIconsBlock />
          </div>
        </v-card-text>
      </v-card>
    </v-row>
  </v-container>
</template>

<style scoped>

</style>
