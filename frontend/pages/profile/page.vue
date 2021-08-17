<script>
  import socialIconsBlock from '~/components/socialIconsBlock';
  import userHead from "../../components/profile/userHead";
  import field from '../../components/profile/fields/field'
  import addTEG from '../../components/profile/fields/addTEG'

  import { createNamespacedHelpers } from 'vuex';
  const { mapState } = createNamespacedHelpers('profile');

    export default {
      name: "page",
      layout: "profile",

      components: {
        socialIconsBlock,
        userHead,
        field,
        addTEG
      },

      async mounted() { // TODO передалать на asyncData когда пойму почему не приходят данные из api
        let profile;

        await this.$store.dispatch('profile/getAllProfilesInfo')
                .then((profiles) => { console.log(profiles) })
                .catch((e) => console.log('profile/getAllProfilesInfo error' + e));
        // Получем id профиля по пользвоателю


        return profile;
      },

      computed:{
        ...mapState({
          profile: (state) => state
        })
      }
    }
</script>

<template>
  <v-container class="px-11">
    <userHead :user="profile" :edit="false" />

    <v-row class="flex flex-row justify-space-between my-4">
      <p class="mb-0">Общее</p>
      <img
              src="../../assets/images/icon/line-settings.svg"
              alt=""
      />
    </v-row>

    <v-row class="flex flex-column justify-center">
      <field />
      <addTEG class="mt-11" />
    </v-row>
  </v-container>
</template>

<style lang="scss">
    .v-card__subtitle, .v-card__text, .v-card__title {
        padding: 5px;
    }
</style>
