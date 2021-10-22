<script>
    import overlayConfirm from "../../layouts/profile/overlayConfirm";

    import {createNamespacedHelpers} from "vuex";
    const profileStore = createNamespacedHelpers('profile');

    export default {
        name: "overlayConfirm",

        components: {
            overlayConfirm
        },

        data: () => ({
            absolute: true
        }),

        computed: {
            ...profileStore.mapState({
                overlay: (state) => state.overlay
            }),
            isActiveOverlay () {
                return this.overlay.status;
            },
            getOverlayText () {
                return this.overlay.text;
            }
        },

        methods: {
            closeOverlay () {
                this.$store.commit('profile/SET_OVERLAY_STATUS', false);
            },
            clickOverlayBtn (status) {
                if (status) {
                    this.$store.dispatch('profile/startOverlayAction', this.$route?.path);
                } else {
                    this.closeOverlay();
                }
            }
        }
    }
</script>

<template>
    <v-overlay
            class="p-12"
            :absolute="absolute"
            :value="isActiveOverlay"
    >
        <v-card
                width="270px"
                height="223px"
                style="border-radius: 30px;"
                class="p-4"
                color="white"
        >
            <v-row>
                <v-btn
                        class="rounded-lg ml-auto mr-0"
                        width="24"
                        height="24"
                        icon
                        @click="closeOverlay()"
                >
                    <img
                            class="m-auto flex-none"
                            style="max-height: 36px; max-width: 36px"
                            src="../../../assets/images/icon/cancel.svg"
                            alt=""
                    >
                </v-btn>
            </v-row>
            <v-card-subtitle class="mx-auto mt-4 mb-4 font-croc text-center px-4" style="color: #000; font-size: 18px;line-height: 24px; padding: 0">
                {{ getOverlayText }}
            </v-card-subtitle>
            <v-row class="flex justify-between mt-2">
                <v-btn
                        class="rounded-lg m-auto white--text"
                        width="100"
                        height="47"
                        color="#FF645A"
                        depressed
                        @click="clickOverlayBtn(true)"
                >
                    Да
                </v-btn>
                <v-btn
                        class="rounded-lg m-auto white--text"
                        width="100"
                        height="47"
                        color="#FFA436"
                        depressed
                        @click="clickOverlayBtn(false)"
                >
                    Нет
                </v-btn>
            </v-row>
        </v-card>
    </v-overlay>
</template>

<style scoped>

</style>
