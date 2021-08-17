<script>
    export default {
        name: "profileFooter",

        data: () => ({
            links: [{
                    name: 'Избранное',
                    url: 'favorite',
                    icon: 'favorits.svg'
                }, {
                    name: 'Профиль',
                    url: 'page',
                    icon: 'user.svg'
                }, {
                    name: 'Просмотры',
                    url: 'witches',
                    icon: 'eyes.svg'
                }, {
                    name: 'Настройки',
                    url: 'settings',
                    icon: 'settings.svg'
                }],
        }),

        methods: {
            getLogoSrc (index) {
                return require("../../../assets/images/icon/" + this.links[index].icon);
            }
        }
    }
</script>

<template>
    <v-footer
            class="mx-4"
            color="white"
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
                    height="54"
                    max-width="136"
                    class="m-auto font-gilroy w-1/4 mb-9"
                    style="font-size: 13px!important; line-height: 15.3px!important;"
                    :to="link.url"
                    text
            >
                <div class="flex flex-col">
                    <img
                            class="m-auto mb-2"
                            style="max-width: 28px; width: 28px; max-height: 28px; height: 28px;"
                            :src="getLogoSrc(index)"
                        alt=""
                    >
                    {{ link.name }}
                </div>
            </v-btn>
        </v-row>
    </v-footer>
</template>

<style scoped>

</style>
