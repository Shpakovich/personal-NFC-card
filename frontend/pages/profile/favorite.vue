<script>
    import plug from "../../components/plug";
    import {createNamespacedHelpers} from "vuex";
    import userField from '../../components/profile/favorites/userField';

    const userStore = createNamespacedHelpers('user');

    export default {
        name: "favorite",
        layout: "profile",

        components: {
            plug,
                userField
        },

        data: () => ({
            text: {
                title: 'Этот раздел еще в разработке',
                subTitle: 'Скоро он станет досутпен'
            }
        }),

            computed: {
                    ...userStore.mapState({
                            favorites: (state) => state.favorites
                    }),
                    getFavorites () {
                           return this.favorites;
                    }
            },

            async asyncData ({ store }) {
                    await store.dispatch('user/getFavoritesUsers')
                            .catch((e) => console.log('user/getFavoritesUsers error ' + e));
            }
    }
</script>

<template>
        <v-container class="pb-11 pt-4 px-11 watch-container" style="height: 100%; max-height: 100%; overflow: scroll;">
                <!--<plug :text="text" :btn="false" :hAuto="true" /> -->
                <v-row style="display: flex; flex-direction: column; gap: 20px;" v-if="getFavorites.length">
                        <userField
                                v-for="(favorite, index) in favorites"
                                :favorite="favorite"
                                :index="index"
                        />
                </v-row>
                <v-row
                        v-if="!getFavorites.length"
                        class="h-full">
                        <h2 class="m-auto text-center font-gilroy">
                                У вас пока нет людей в избранном, время познакомиться!
                        </h2>
                </v-row>
        </v-container>
</template>

<style scoped>

</style>
