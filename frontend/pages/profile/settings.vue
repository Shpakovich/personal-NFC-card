<script>
    import userHead from "../../components/profile/userHead";

    import { createNamespacedHelpers } from 'vuex';
    const { mapState } = createNamespacedHelpers('profile');

    export default {
        name: "settings",
        layout: "profile",

        components: {
            userHead
        },

        async asyncData ({ redirect, store }) {

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
        },

        computed: {
            ...mapState({
                profile: (state) => state
            }),
        }
    }
</script>

<template>
    <v-container class="px-11 settings-page-block" style="height: 100%; max-height: 100%; overflow: scroll;">
        <p class="font-croc text-center" style="font-size: 17px; line-height: 24px;">
            Чуть позже вы сможете создать карточку
            в дополнение к этой, но написать другую
            должность или любую другую информацию
        </p>
        <!-- <nuxt-link class="font-croc" style="font-size: 17px; line-height: 24px;" to="/profile/createNewProfile">
            Создать еще одну карточку
        </nuxt-link> -->
        <userHead class="my-6" :user="profile" :edit="false" />

        <nuxt-link class="font-croc" style="font-size: 17px; line-height: 24px;" to="/resetPassword">
            Поменять пароль
        </nuxt-link>
    </v-container>

</template>

<style lang="scss">
    .settings-page-block {
        @media (min-width: 1280px) {
            max-width: 700px !important;
        }

        @media (min-width: 640px) { // todo вынести в переменную
            max-width: 447px;
            margin: auto !important;
        }
    }

</style>
