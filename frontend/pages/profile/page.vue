<script>
  import socialIconsBlock from '~/components/socialIconsBlock';
  import userHead from "../../components/profile/userHead";
  import field from '../../components/profile/fields/field'
  import addTEG from '../../components/profile/fields/addTEG'

  import draggable from 'vuedraggable'

  import { createNamespacedHelpers } from 'vuex';
  const { mapState } = createNamespacedHelpers('profile');

    export default {
      name: "page",
      layout: "profile",

      components: {
        socialIconsBlock,
        userHead,
        field,
        addTEG,
        draggable
      },

      data: () => ({
        showAlert: '',
        enabled: false
      }),


      async asyncData ({ redirect, store }) {
        let profiles= {},
                profile = {};

        await store.dispatch('profile/getAllProfilesInfo')
                .then(() => {
                  if (!store.state?.profile?.id && store.state.auth.user.length) {
                    redirect( '/profile/create' )
                  } else if (!store.state.auth.user.length) {
                    // redirect( '/card/register' ) // TODO делать проверку на наличие карт у пользователя /user/cards, если нет то редирект
                  }
                })
                .catch((e) => console.log('profile/getAllProfilesInfo error' + e));

        const profileID = store.state?.profile?.id;

        if (profileID) {
          await store.dispatch('profile/getProfileInfo', profileID)
                  .then((res) => { profile = res })
                  .catch((e) => console.log('profile/getProfileInfo error' + profileID + e));
        }

        return [
          profiles,
          profile
        ];
      },

      computed:{
        ...mapState({
          profile: (state) => state
        }),
        getDashboardIcon() {
          return this.enabled ? require("../../assets/images/icon/swap__active.svg") :  require("../../assets/images/icon/swap-black.svg")
        }
      },

      mounted() {
        // this.showAlert = 'test'; TODO таймер на показ
      },

      methods: {
        async getProfileFields() {
          await this.$store.dispatch('profile/getProfileInfo', this.profile?.id)
                  .catch((e) => console.log('profile/editProfileInfo error' + e));
        },
        async checkMoveEnd(e) {

          console.log(e.clone?.id);
          console.log(e.newIndex+1);

            const data = {
                id: e?.clone.id,
                sort: e?.newIndex+1
            };

            await this.$store.dispatch('profile/editSortFieldInProfile', data)
                    .catch((e) => console.log('profile/editFieldInProfile error ' + e));
        },
      }
    }
</script>

<template>
  <v-container class="px-11">
    <userHead :user="profile" :edit="false" />

    <v-row class="flex flex-row justify-space-between my-4">
      <p class="mb-0">Общее</p>
      <div class="flex flex-row m-auto justify-end" style="max-width: 80px; margin: 0;">
        <label for="disabled">
          <img
                  style="width: 24px; height: 24px;"
                  :src="getDashboardIcon"
                  alt=""
          >
        </label>
        <input
                style="position: absolute; display: contents;"
                id="disabled"
                type="checkbox"
                v-model="enabled"
        />
        <img
                class="ml-4"
                style="width: 24px; height: 24px;"
                src="../../assets/images/icon/line-settings.svg"
                alt=""
        />
      </div>
    </v-row>

    <v-row class="flex flex-column justify-center">
      <draggable
              :disabled="!enabled"
              style="width: 100%;"
              v-model="profile.fields"
              @end="checkMoveEnd"
      >
        <div v-for="(field, index) in profile.fields" :id="field.id" :key="index" class="item">
          <field
                  :field-info="field"
                  class="mb-6"
                  @updateFields="getProfileFields()"
          />
        </div>
      </draggable>

      <!-- <field
        v-for="(field, index) in profile.fields"
        :field-info="field"
        class="mb-6"
        :key="index"
        @updateFields="getProfileFields()"
      /> -->
      <addTEG class="mt-11" />
    </v-row>
    <v-alert
            v-if="showAlert"
            text
            prominent
            border="right"
            color="green"
            type="success"
            style="position: absolute; right: 15px; bottom: 0;"
    >
      {{ showAlert }}
    </v-alert>
  </v-container>
</template>

<style lang="scss">
    .v-card__subtitle, .v-card__text, .v-card__title {
        padding: 5px;
    }
    .flip-list-move {
      transition: transform 0.5s;
    }
</style>
