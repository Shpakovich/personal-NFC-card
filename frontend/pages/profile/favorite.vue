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
        <plug :text="text" :btn="false" :hAuto="true" />
</template>

<style scoped>

</style>
