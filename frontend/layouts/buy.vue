<script>
    export default {
        name: "buy",

        head () {
            return {
                meta: [
                    { hid: 'robots', name: 'robots', content: 'index, follow' },
                    { hid: 'og:image', property: 'og:image', content: 'https://media.myid-card.ru/2021/12/28/06928b9e-37d5-4063-8552-114ab296068b.jpg' },
                    { hid: 'og:description', property: 'og:description', content: 'myID это электронная визитка в которой можно указать ссылки на все свои соцсети и контакты.' },
                    { hid: 'og:image:width', property: 'og:image:width', content: '196' },
                    { hid: 'og:image:height', property: 'og:image:height', content: '196' }
                ]
            };
        }
    }
</script>

<template>
    <v-app class="w-full h-full app-buy" style="background-color: #87b899;">
        <v-main>
            <nuxt keep-alive :keep-alive-props="{include: ['registration']}" />
        </v-main>
    </v-app>
</template>

<style lang="scss">
    .app-buy {
        background-size: cover!important;

        @media (min-width: 640px) { // todo вынести в переменную
            background-image: url("../assets/images/buy/shiny.svg") !important;
        }

        @media (max-width: 640px) { // todo вынести в переменную
            background-image: url("../assets/images/buy/shiny_mobile.svg") !important;
        }
    }
</style>
