<script>
    export default {
        name: "userField",

        props: [
            "favorite",
            "index"
        ],

        computed: {
            getUserName () {
                return this.favorite?.profile?.name;
            },
            getUserPost () {
                return this.favorite?.profile?.post;
            },
            getFieldColor () {
                const order = this.index % 3;
                if (order === 0) {
                    return '#EEF7FE';
                } else if (order === 1) {
                    return '#F6FEEE';
                } else if (order === 2) {
                    return '#FEF3EE';
                }
                return '#EEF7FE';
            }
        },

        methods: {
            routeToUser () {
                if ( this.favorite.card?.alias ) {
                    return this.$router.push(`/${this.favorite.card?.alias}`);
                } else {
                    return this.$router.push(`/${this.favorite.card?.id}`);
                }
            },
            async deleteUserFromFavorite() {
                this.$store.commit('profile/SET_OVERLAY_TEXT', 'Вы точно хотите ' +
                    'удалить из избранного этого человека?');
                this.$store.commit('profile/SET_OVERLAY_STATUS', true);

                const id = {
                    "id": this.favorite?.id
                };
                this.$store.commit('profile/SET_OVERLAY_PARAMS', id);

            }
        }
    }
</script>

<template>
    <transition name="fade">
        <v-card
                v-if="favorite"
                outlined
                class="mx-auto flex flex-row rounded-lg pt-5 pb-6 px-5"
                style="display: flex!important; border-radius: 20px!important;"
                height="80"
                width="100%"
                :color="getFieldColor"
        >
            <div
                    class="flex justify-center"
                    style=" width: 36px; max-width: 36px; height: 36px;"
                    @click="routeToUser()"
            >
                <img
                        class="m-auto flex-none"
                        style="max-height: 24px; max-width: 24px"
                        src="./../../../assets/images/icon/user-green.svg"
                        alt=""
                >
            </div>
            <div
                    class="user-fields__text-block"
                    @click="routeToUser()"
            >
                <v-card-subtitle class="my-auto ml-4 font-gilroy font-bold user-fields__text-title">
                    {{ getUserName }}
                </v-card-subtitle>
                <v-card-subtitle class="my-auto ml-4 font-gilroy user-fields__text-subtitle">
                    {{ getUserPost }}
                </v-card-subtitle>
            </div>
            <v-btn
                    icon
                    class="font-bold ml-auto"
                    max-width="36px"
                    min-width="36px"
                    height="36"
                    @click="deleteUserFromFavorite()"
            >
                <img
                        class="m-auto flex-none"
                        style="max-height: 36px; max-width: 36px"
                        src="../../../assets/images/icon/Delete.svg"
                        alt=""
                >
            </v-btn>
        </v-card>
    </transition>
</template>

<style lang="scss">
    .user-fields__text-block {
        display: flex;
        flex-direction: column;
        flex-wrap: nowrap;
        max-width: 70%;
        width: 70%;
    }

    .user-fields__text-title {
        color: #415EB6!important;
        font-size: 15px!important;
        line-height: 18px!important;
        padding: 0!important;
    }

    .user-fields__text-subtitle {
        color: #415EB6!important;
        font-size: 12px!important;
        line-height: 16px!important;
        padding: 0!important;
    }
</style>
