<script>
    import userHead from "../components/profile/userHead";
    import field from '../components/profile/fields/field';
    import addTEG from '../components/profile/fields/addTEG';

    import draggable from 'vuedraggable';

    import { createNamespacedHelpers } from 'vuex';
    const { mapState } = createNamespacedHelpers('profile');

    export default {
        name: "show",
        layout: "profile",

        components: {
            userHead,
            field,
            addTEG,
            draggable
        },

        computed:{
            ...mapState({
                profile: (state) => state
            }),
            getDashboardIcon() {
                return this.enabled ? require("../assets/images/icon/swap__active.svg") :  require("../assets/images/icon/swap-black.svg")
            }
        },

        async asyncData ({ route,redirect, store }) {
            await $store.dispatch('show/getShowProfile', this.profile?.id) //берём id из роута
                    .catch((e) => console.log('profile/editProfileInfo error' + e));
        },


        // TODO: если авторизованный то закрытый лэйаут, если нет, только шапка(адаптировать - сделать для авторизованного нет)
    }
</script>

<template>
    <v-container class="px-11">
        <userHead :show="true" :user="profile" :edit="false" />

        <v-row class="flex flex-row justify-space-between my-4">
            <p class="mb-0">Общее</p>
            <div class="flex flex-row m-auto justify-end" style="max-width: 80px; margin: 0;">
                <img
                        class="ml-4"
                        style="width: 24px; height: 24px;"
                        src="../assets/images/icon/line-settings.svg"
                        alt=""
                />
            </div>
        </v-row>

        <v-row class="flex flex-column justify-center">
            <field
              v-for="(field, index) in profile.fields"
              :field-info="field"
              class="mb-6"
              :key="index"
              @updateFields="getProfileFields()" <!-- брать из стора, класть встор в асиндате -->
            />
        </v-row>
    </v-container>
</template>

<style scoped>

</style>
