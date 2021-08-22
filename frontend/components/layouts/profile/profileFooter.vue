<script>
    export default {
        name: "profileFooter",

        data: () => ({
            links: [{
                    name: 'Избранное',
                    url: 'favorite',
                    icon: 'favorite.svg',
                    iconActive: 'favorite-active.svg'
                }, {
                    name: 'Профиль',
                    url: 'page',
                    icon: 'user.svg',
                    iconActive: 'user-active.svg'
                }, {
                    name: 'Просмотры',
                    url: 'watches',
                    icon: 'eye.svg',
                    iconActive: 'eye-active.svg'
                }, {
                    name: 'Настройки',
                    url: 'settings',
                    icon: 'settings.svg',
                    iconActive: 'settings-active.svg'
                }],
        }),

        methods: {
            isActiveRoute(path) {
                return this.$route?.path?.includes(path);
            },
            getLogoSrc (index) {
                return require("../../../assets/images/icon/" + this.links[index].icon);
            },
            getActiveLogoSrc (index) {
                return require("../../../assets/images/icon/" + this.links[index].iconActive);
            }
        }
    }
</script>

<template>
    <v-footer
            class="mx-4"
            color="white"
            style="position: fixed; bottom: 0"
            padless
    >
        <v-row
                justify="center"
                no-gutters
        >
            <v-btn
                    v-for="(link, index) in links"
                    :key="link.url"
                    color="primary"
                    height="78"
                    min-height="78"
                    max-width="136"
                    active-class="test-active"
                    class="m-auto font-gilroy w-1/4 mb-9 "
                    :style="isActiveRoute(link.url) ? 'border-top: 2px solid #FFA436;' : 'border-top: 2px solid rgba(104, 103, 108, 0.3);'"
                    style="font-size: 13px!important; line-height: 15.3px!important; border-radius: 0px !important;"
                    :to="link.url"
                    text
            >
                <div class="flex flex-col">
                    <img
                            v-if="isActiveRoute(link.url)"
                            class="m-auto mb-2"
                            style="max-width: 28px; width: 28px; max-height: 28px; height: 28px;"
                            :src="getActiveLogoSrc(index)"
                            alt=""
                    >
                    <img
                            v-else
                            class="m-auto mb-2"
                            style="max-width: 28px; width: 28px; max-height: 28px; height: 28px;"
                            :src="getLogoSrc(index)"
                            alt=""
                    >
                    <p
                            style="padding: 0; margin: 0"
                       :class="{'item_active': true}"
                    >
                        {{ link.name }}
                    </p>
                </div>
            </v-btn>
        </v-row>
    </v-footer>
</template>

<style lang="scss">
    .v-btn:before {
        background: none;
    }

    .test-active {
        p {
            color: #FFA436;
        }
        svg {
            fill: #FFA436;
        }
    }

    .v-btn__content__bottom {
        position: absolute;
        bottom: 0;
    }
</style>
