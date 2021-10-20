<script>
    export default {
        name: "plug",

        props: [
            "text",
            "btn",
            "hAuto"
        ],
    }
</script>

<template>
    <v-container
            class="py-11 px-11 flex flex-col justify-center"
            :class="hAuto ? 'h-auto' : 'h-screen'"
    >
        <v-btn
                v-if="btn"
                style="position: absolute; top: 47px; left: 28px;"
                icon
                class="rounded-lg flex-initial font-bold w-4/12 mb-6 ml-1.5 btn-back"
                max-width="110px"
                min-width="100px"
                height="48"
                color="secondary"
                to="/"
        >
            <img src="../assets/images/icon/icon-arrow-left.svg" alt="">
            Назад
        </v-btn>
        <div>
            <img
                    class="pb-6 m-auto"
                    src="../assets/images/plug.svg"
                    style="max-width: 150px;"
                    alt=""
            />
            <p class="text-center text-2xl leading-10 font-bold mb-2.5" style="color: #00A460">
                {{ text.title }}
            </p>
            <p class="text-center text-xl leading-7 font-bold" style="color: #FFA436">
                {{ text.subTitle }}
            </p>
        </div>
    </v-container>
</template>

<style scoped>

</style>
