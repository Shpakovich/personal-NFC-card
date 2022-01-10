<script>
    export default {
        name: "buy"
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
