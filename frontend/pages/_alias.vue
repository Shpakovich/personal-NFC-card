<script>
    import userHead from "../components/profile/userHead";
    import fieldForShow from '../components/profile/fields/fieldForShow';
    import addTEG from '../components/profile/fields/addTEG';

    import draggable from 'vuedraggable';

    import { createNamespacedHelpers } from 'vuex';

    const showStore = createNamespacedHelpers('show');
    const fieldsStore = createNamespacedHelpers('fields');

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
            ...showStore.mapState({
                show: (state) => state
            }),
            ...fieldsStore.mapState({
                fieldsType: (state) => state
            }),
            getDashboardIcon() {
                return this.enabled ? require("../assets/images/icon/swap__active.svg") :  require("../assets/images/icon/swap-black.svg")
            },
            getShowFields() {
                const typeID = this.$store.state.show?.typesID;
                if (typeID === "1") {
                    return this.show.sortFields;
                } if (typeID === "2") {
                    return [];
                } else {
                    return this.show.fields;
                }
            },
            isShowCustomFields() {
                const typeID = this.$store.state.show?.typesID;
                return (typeID === "1" || typeID === "2") && this.getCustomShowFields.length;
            },
            getCustomShowFields() {
                return this.show?.profile.custom;
            },
            isBothTypesFields () {
                const typeID = this.$store.state.show?.typesID;
                return this.getShowFields.length && this.getCustomShowFields.length && typeID === "1";
            }
        },

        async asyncData ({ redirect, store, route }) {
            const alias = route.params?.alias;

            if (alias.includes('hash=')) {
                const clearAlias = alias.replace("hash=", "");
                await store.dispatch('show/getShowProfile', clearAlias)
                    .catch((e) => console.log('show/getShowProfile error ' + e));
            } else {
                await store.dispatch('show/getShowProfile', route.params?.alias)
                    .catch((e) => console.log('show/getShowProfile error ' + e));
            }

            function isFavorite(favorite) {
                return favorite.profile.id === store.state.show.profile?.id;
            }

            await store.dispatch('user/getFavoritesUsers').then(_ => {
                const { commit } = store;
                const favorites = store.state.user.favorites;
                const profileInFavorite = favorites.find(isFavorite);

                if ( profileInFavorite && profileInFavorite.id ) {
                    commit('user/SET_USER_IN_FAVORITES', profileInFavorite.id);
                }
            }).catch((e) => console.log('user/getFavoritesUsers error ' + e));


            if( !!store.state.show.profile?.id ) {
                const fields = store.state.show.profile?.fields;
                const sortable = [];

                for (let field in fields) {
                    const num = fields[field];
                    for (let fiel in num) {
                        sortable.push(num[fiel]);
                    }
                }

                sortable.sort(function (a, b) {
                    return a.sort - b.sort;
                });

                store.commit('show/SET_SHOW_PROFILE_SORT_FIELDS', sortable);
            }

            const showProfile = store.state.show.profile?.id;
            if(!showProfile) {
                redirect( '/' );
            }
        },

        async mounted() {
            const typeID = this.$store.state.show?.typesID;
            if (typeID !== "1" && typeID !== "2") {
                let showInfo;
                const alias = this.$route.params?.alias;

                if (alias.includes('hash=')) {
                    const clearAlias = alias.replace("hash=", "");
                    showInfo = {
                        cardID: clearAlias,
                        typeID: typeID
                    };
                } else {
                    showInfo = {
                        cardID: this.$route.params?.alias,
                        typeID: typeID
                    };
                }

                await this.$store.dispatch('show/getFieldTypesToShow', showInfo)
                    .catch((e) => console.log('show/getFieldTypesToShow error ' + e));
            }
        }
    }
</script>

<template>
    <v-container class="px-11 xl:flex xl:flex-row xl:h-full xl:justify-between  xl:mt-6 user-page__xl fix-page-container">
        <userHead
                class="userHead__xl m-auto__sm"
                style="max-width: 447px; height: max-content;"
                :isShow="true"
                :user="show.profile"
                :edit="false" />

        <v-row
                class="flex flex-column fields-block__xl flex-nowrap m-auto__sm"
                style="max-width: 448px;"
        >
            <v-row class="flex flex-row justify-space-between my-4">
                <p class="mb-0 font-gilroy">{{ show.typesName }}</p>
                <div class="flex flex-row m-auto justify-end" style="max-width: 80px; margin: 0;">
                    <nuxt-link to="/fieldsType">
                        <img
                                class="ml-4"
                                style="width: 24px; height: 24px;"
                                src="../assets/images/icon/line-settings.svg"
                                alt=""
                        />
                    </nuxt-link>
                </div>
            </v-row>

            <v-row v-if="getShowFields.length" class="flex flex-column xl:overflow-scroll field-list__xl flex-nowrap">
                <fieldForShow
                  v-for="(field) in getShowFields"
                  :is-custom="false"
                  :field-info="field"
                  class="item"
                  :key="field.id"
                />
            </v-row>

            <div v-if="isShowCustomFields && getShowFields.length" class="separation-line"/>

            <v-row v-if="isShowCustomFields" class="flex flex-column xl:overflow-scroll field-list__xl flex-nowrap">
                <fieldForShow
                        v-for="(customField) in getCustomShowFields"
                        :is-custom="true"
                        :field-info="customField"
                        class="item"
                        :key="customField.id"
                />
            </v-row>

            <v-row v-if="!getShowFields.length && !isShowCustomFields" class="flex flex-column mt-6">
                <p class="text-center font-croc">Пользователь ещё не добавил информацию о себе</p>
            </v-row>
        </v-row>
    </v-container>
</template>

<style lang="scss">
    .item {
        margin-bottom: 24px;
    }

    .item:last-of-type {
        margin-bottom: 0 !important;
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

    .fix-page-container {
        height: 100%;
        max-height: 100%;
        overflow: scroll;
    }

    .m-auto__sm {
        @media (min-width: 640px) and (max-width: 1280px) {
            margin: auto !important;
        }
    }

    .separation-line {
        width: 100%;
        height: 1px;
        background-color: rgba(104, 103, 108, 0.3);
        margin: 20px 0;
    }
</style>
