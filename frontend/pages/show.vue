<script>
    import userHead from "../components/profile/userHead";
    import fieldForShow from '../components/profile/fields/fieldForShow';
    import addTEG from '../components/profile/fields/addTEG';

    import draggable from 'vuedraggable';

    import { createNamespacedHelpers } from 'vuex';
    const { mapState } = createNamespacedHelpers('show');

    export default {
        name: "show",
        layout: "showProfile",

        components: {
            userHead,
            fieldForShow,
            addTEG,
            draggable
        },

        computed:{
            ...mapState({
                show: (state) => state
            }),
            getDashboardIcon() {
                return this.enabled ? require("../assets/images/icon/swap__active.svg") :  require("../assets/images/icon/swap-black.svg")
            }
        },

        async asyncData ({ redirect, store }) {
            const showProfile = store.state.show.profile?.id;
            if(!showProfile) {
                redirect( '/' );
            }
        }


        // TODO: если авторизованный то закрытый лэйаут, если нет, только шапка(адаптировать - сделать для авторизованного нет)
    }
</script>

<template>
    <v-container class="px-11">
        <userHead :isShow="true" :user="show.profile" :edit="false" />

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
            <fieldForShow
              v-for="(field, index) in show.sortFields"
              :field-info="field"
              class="mb-6"
              :key="index"
            />
        </v-row>
    </v-container>
</template>

<style scoped>

</style>
