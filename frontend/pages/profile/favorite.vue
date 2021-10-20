<script>
    import plug from "../../components/plug";
    import {createNamespacedHelpers} from "vuex";

    const userStore = createNamespacedHelpers('user');

    export default {
        name: "favorite",
        layout: "profile",

        components: {
            plug
        },

        data: () => ({
            text: {
                title: 'Этот раздел еще в разработке',
                subTitle: 'Скоро он станет досутпен'
            }
        }),

            computed: {
                    ...userStore.mapState({
                            user: (state) => state
                    })
            },

            async asyncData ({ store }) {
                    await store.dispatch('user/getFavoritesUsers')
                            .catch((e) => console.log('user/getFavoritesUsers error ' + e));
            }
    }
</script>

<template>
        <v-container style="height: 100%; max-height: 100%; overflow: scroll;">
                <plug :text="text" :btn="false" :hAuto="true" />
        </v-container>
</template>

<style scoped>

</style>
