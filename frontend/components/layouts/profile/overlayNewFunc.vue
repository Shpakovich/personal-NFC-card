<script>
    import {createNamespacedHelpers} from "vuex";
    const profileStore = createNamespacedHelpers('profile');
    import { universalStorage } from '../../../utils/helpers';

    export default {
        name: "overlayNewFunc",

        computed: {
            ...profileStore.mapState({
                overlayNew: (state) => state.overlayNew
            })
        },

        beforeMount() {
            const hasOverlayInStorage = universalStorage.getItem('newFavorites');
            if (hasOverlayInStorage) {
                this.$store.commit('profile/SET_OVERLAY_NEW_SHOULD', false);
            }
            const should = this.$store.state.profile.overlayNew.should;
            if (should) {
                this.setOverlayTimerToShow();
            }
        },

        methods: {
            setOverlayTimerToShow () {
                setTimeout(this.showNewOverlay(), 1000);
            },
            showNewOverlay () {
                this.$store.commit('profile/SET_OVERLAY_NEW_STATUS', true);
            },
            closeNewOverlay() {
                this.$store.commit('profile/SET_OVERLAY_NEW_STATUS', false);
                universalStorage.setItem('newFavorites', true);
            },
            routeToFavorite () {
                this.closeNewOverlay();
                this.$router.push('/profile/favorite');
            }
        }
    }
</script>

<template>
    <v-overlay
            class="p-12"
            :absolute="true"
            :value="overlayNew.status"
            opacity="0.8"
            color="black"
    >
        <v-row class="mb-4">
            <v-btn
                    class="rounded-lg ml-auto mr-0"
                    width="36"
                    height="36"
                    icon
                    @click="closeNewOverlay()"
            >
                <img
                        class="m-auto flex-none"
                        style="max-height: 36px; max-width: 36px"
                        src="../../../assets/images/icon/cancel.svg"
                        alt=""
                >
            </v-btn>
        </v-row>
        <p class="text-center font-croc text-lg">
            Привет! Мы рады что ты с нами.<br>
            Хотим рассказать про новый функционал.
        </p>
        <img
                class="mx-auto my-6 flex-none"
                style="max-height: 240px; max-width: 240px; border-radius: 30px;"
                src="../../../assets/images/addFavorite.gif"
                alt=""
        >
        <p class="text-center font-croc text-lg">
            В личном кабинете стал доступен раздел "Избранное", там можно увидеть сохранённые контакты.
            Сохранить контакт легко, просто нажмите на&nbsp;⭐&nbsp;при просмотре профиля.
        </p>
        <v-btn
                icon
                style="font-size: 15px!important; line-height: 21px!important;"
                block
                height="48"
                class="rounded-lg"
                color="secondary"
                @click="routeToFavorite()"
                to="/profile/favorite"
        >
            Ура! Перейти
            <img src="../../../assets/images/icon/icon-arrow-right.svg" alt="">
        </v-btn>
    </v-overlay>
</template>

<style scoped>

</style>
