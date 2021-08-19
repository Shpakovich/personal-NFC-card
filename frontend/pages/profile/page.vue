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

      data: () => ({
        showAlert: ''
      }),

      async asyncData ({ route, store }) {
        let profiles= {},
                profile = {};

        await store.dispatch('profile/getAllProfilesInfo')
                .then((res) => { profiles = res })
                .catch((e) => console.log('profile/getAllProfilesInfo error' + e));

        const profileID = store.state?.profile?.id;

        await store.dispatch('profile/getProfileInfo', profileID)
                .then((res) => { profile = res })
                .catch((e) => console.log('profile/getProfileInfo error' + profileID + e));

        return [
          profiles,
          profile
        ];
      },

      computed:{
        ...mapState({
          profile: (state) => state
        })
      },

      mounted() {
        // this.showAlert = 'test'; TODO таймер на показ
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
      <field
        v-for="(field, index) in profile.fields"
        :field-info="field"
        class="mb-6"
        :key="index"
      />
      <addTEG class="mt-11" />
    </v-row>
    <v-alert
            v-if="showAlert"
            text
            prominent
            border="right"
            color="green"
            type="success"
            style="position: absolute; right: 15px; bottom: 0px;"
    >
      {{ showAlert }}
    </v-alert>
  </v-container>
</template>

<style lang="scss">
    .v-card__subtitle, .v-card__text, .v-card__title {
        padding: 5px;
    }
</style>
