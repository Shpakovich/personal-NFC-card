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
        enabled: true
      }),


      async asyncData ({ redirect, store }) {
        let profiles= {},
                profile = {};

        await store.dispatch('profile/getAllProfilesInfo')
                .then(() => {
                  if (!store.state?.profile?.id) {
                    console.log('profile not found'); // TODO роут на создание профиля
                    redirect( '/profile/create' )
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
        field: {
          get() {
            //return this.$store.state.nested.elements;
            console.log('get fields')
          },
          set(value) {
            console.log('set fields')
            //this.$store.dispatch("nested/updateElements", value);
          }
        }
      },

      mounted() {
        // this.showAlert = 'test'; TODO таймер на показ
      },

      methods: {
        async getProfileFields() {
          await this.$store.dispatch('profile/getProfileInfo', this.profile?.id)
                  .then((data) => {
                  })
                  .catch((e) => console.log('profile/editProfileInfo error' + e));
        },
        checkMove() {
          console.log('test move')
        },
        checkMoveEnd(e) {
          console.log(e)
        }
      }
    }
</script>

<template>
  <v-container class="px-11">
    <userHead :user="profile" :edit="false" />

    <v-row class="flex flex-row justify-space-between my-4">
      <p class="mb-0">Общее</p>
      <div class="flex flex-row m-auto" style="max-width: 50px; margin: 0;">
        <input
                id="disabled"
                type="checkbox"
                v-model="enabled"
                class="form-check-input mr-4"
        />
        <img
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
        <div v-for="(field, index) in profile.fields" :key="index" class="item">
          <field
                  :id="field.id"
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
