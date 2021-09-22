<script>
    import plug from "../../components/plug";

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
    }
</script>

<template>
        <v-container style="height: 100%; max-height: 100%; overflow: scroll;">
                <plug :text="text" :btn="false" :hAuto="true" />
        </v-container>
</template>

<style scoped>

</style>
