<script>
  import socialIconsBlock from '~/components/socialIconsBlock';
  import userHead from "../../components/profile/userHead";
  import field from '../../components/profile/fields/field';
  import customField from '../../components/profile/fields/customField';
  import addTEG from '../../components/profile/fields/addTEG';

  import draggable from 'vuedraggable'

  import { createNamespacedHelpers } from 'vuex';
  const profileStore = createNamespacedHelpers('profile');
  const fieldsStore = createNamespacedHelpers('fields');

    export default {
      name: "page",
      layout: "profile",

      components: {
        socialIconsBlock,
        userHead,
        field,
        addTEG,
        draggable,
        customField
      },

      data: () => ({
        showAlert: '',
        enabled: false
      }),


      async asyncData ({ redirect, store }) {
        await store.dispatch('profile/getAllProfilesInfo')
                .then(() => {
                  if (!store.state?.profile?.id && !store.state.auth.user.length) {
                    redirect( '/profile/create' )
                  }
                })
                .catch((e) => console.log('profile/getAllProfilesInfo error' + e));

        const profileID = store.state?.profile?.id;
        const typeID = store.state?.fields?.typesID;

        if (typeID !=='1') {
          await store.dispatch('profile/getFieldsInProfileByType', profileID, typeID)
                  .catch((e) => console.log('profile/getProfileInfo error' + profileID + e));
        } else if (profileID ?? typeID === '1') {
          await store.dispatch('profile/getProfileInfo', profileID)
                  .catch((e) => console.log('profile/getProfileInfo error' + profileID + e));
        }

        await store.dispatch('fields/getAllCustomsFieldsToProfile', profileID)
                .catch((e) => console.log('fields/getAllCustomsFieldsInfo error' + e));
      },

      computed:{
        ...profileStore.mapState({
          profile: (state) => state,
          customFieldsToProfile: (state) => state.customsFields
        }),
        ...fieldsStore.mapState({
          fieldsType: (state) => state
        }),
        getDashboardIcon() {
          return this.enabled ? require("../../assets/images/icon/swap__active.svg") :  require("../../assets/images/icon/swap-black.svg")
        },
        isFieldsTypeAll () {
          return this.fieldsType.typesID === '1';
        }
      },

      async mounted() {
        if (this.fieldsType.typesID !== '1') {
          const data = {
            profileID: this.profile.id,
            typesID: this.fieldsType.typesID
          };
          await this.$store.dispatch('profile/getFieldsInProfileByType', data)
                  .catch((e) => console.log('profile/getProfileInfo error ' + e));
        }
      },

      methods: {
        async getProfileFields() {
          await this.$store.dispatch('profile/getProfileInfo', this.profile?.id)
                  .catch((e) => console.log('profile/getProfileInfo error' + e));
        },

        async getCustomProfileFields() {
          await this.$store.dispatch('fields/getAllCustomsFieldsToProfile', this.profile?.id)
                  .catch((e) => console.log('fields/getAllCustomsFieldsToProfile error' + e));
        },
        async checkMoveEnd(e) {

            const data = {
                id: e?.clone?.id,
                sort: e?.newIndex+1 //  сортировка с положительных чисел
            };

            await this.$store.dispatch('profile/editSortFieldInProfile', data)
                    .catch((e) => console.log('profile/editFieldInProfile error ' + e));
        },
        isBothTypesFields () {
          return this.profile.fields.length && this.customFields
        }
      }
    }
</script>

<template>
  <v-container class="px-11 xl:flex xl:flex-row xl:h-full xl:justify-between xl:mt-6 user-page__xl fix-page-container">
    <userHead
            class="userHead__xl m-auto__sm"
            :user="profile"
            :edit="false"
            :isShow="false"
    />

    <v-row class="flex flex-column fields-block__xl flex-nowrap m-auto__sm">
      <v-row class="flex flex-row justify-space-between my-4 max-h-7">
        <p class="mb-0 font-gilroy">{{ fieldsType.typesName }}</p>
        <div class="flex flex-row justify-end" style="max-width: 80px; margin: 0;">
          <label v-if="isFieldsTypeAll" for="disabled">
            <img
                    style="width: 24px; height: 24px;"
                    :src="getDashboardIcon"
                    alt=""
            >
          </label>
          <input
                  v-if="isFieldsTypeAll"
                  style="position: absolute; display: contents;"
                  id="disabled"
                  type="checkbox"
                  v-model="enabled"
          />
          <nuxt-link to="/profile/fields/fieldsType">
            <img
                    class="ml-4"
                    style="width: 24px; height: 24px;"
                    src="../../assets/images/icon/line-settings.svg"
                    alt=""
            />
          </nuxt-link>
        </div>
      </v-row>
      <v-row class="field-list__xl xl:overflow-scroll">
        <draggable
                :disabled="!enabled"
                style="width: 100%;"
                v-model="profile.fields"
                @end="checkMoveEnd"
        >
          <transition name="fade">
            <div v-for="(field, index) in profile.fields" :id="field.id" :key="index" class="item">
                <field
                        :field-info="field"
                        class="mb-6"
                        @updateFields="getProfileFields()"
                />
            </div>
          </transition>
        </draggable>

        <div v-if="isBothTypesFields" style="width: 100%; height: 1px; background-color: #68676C; margin: 20px 0;"></div>

        <draggable
                :disabled="!enabled"
                style="width: 100%;"
                v-model="customFieldsToProfile"
                @end="checkMoveEnd"
        >
          <transition name="fade">
            <div v-for="(customField, index) in customFieldsToProfile" :id="customField.id" :key="index" class="item">
              <customField
                      :custom-field-info="customField"
                      class="mb-6"
                      @updateFields="getCustomProfileFields()"
              />
            </div>
          </transition>
        </draggable>
        <addTEG class="mt-11" />
      </v-row>
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
  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
  }
  .fade-enter, .fade-leave-to {
    opacity: 0;
  }

    .v-card__subtitle, .v-card__text, .v-card__title {
        padding: 5px;
    }
    .flip-list-move {
      transition: transform 0.5s;
    }

  .userHead__xl {
    max-width: 447px;
    @media (min-width: 1280px) { // todo вынести в переменную
      height: max-content;
    }
  }

  .fields-block__xl {
    max-width: 448px;
    justify-content: center;
      @media (min-width: 1280px) { // todo вынести в переменную
        justify-content: flex-start !important;
      }
  }

    .user-page__xl {
      @media (min-width: 1280px) { // todo вынести в переменную
        max-width: 1085px;
        padding-bottom: 98px;
      }
    }

    /*Убрать полосу прокрутки у элемента*/
    .field-list__xl::-webkit-scrollbar {
      width: 0;
    }

  .m-auto__sm {
    @media (min-width: 640px) and (max-width: 1280px) {
      margin: auto !important;
    }
  }

  .fix-page-container {
    height: 100%;
    max-height: 100%;
    overflow: scroll;
  }
</style>
