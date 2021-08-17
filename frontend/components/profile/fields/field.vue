<script>
    export default {
        name: "field"
    }
</script>

<template>
    <v-card
            class="mx-auto flex flex-row rounded-lg pt-5 pb-6 px-5"
            style="display: flex!important; border-radius: 20px!important;"
            height="80"
            width="100%"
            color="#EEF7FE"
    >
        <div class="flex justify-center" style=" width: 36px; max-width: 36px; height: 36px;">
            <img
                    class="m-auto flex-none"
                    style="max-height: 24px; max-width: 24px"
                    src="../../../assets/images/icon/fi_phone.svg"
                    alt=""
            >
        </div>
        <div class="flex flex-col flex-grow my-auto ml-4">
            <v-card-subtitle class="font-gilroy" style="color: #415EB6;font-size: 15px;line-height: 18px; padding: 0">
                Номер телефона
            </v-card-subtitle>
            <v-card-subtitle class="font-gilroy" style="color: #415EB6;font-size: 12px;line-height: 140.1%; padding: 0">
                + 7 (123) 456 78 91
            </v-card-subtitle>
        </div>
        <v-btn
                icon
                class="font-bold m-auto"
                max-width="24px"
                min-width="24px"
                height="24"
                to="/"
        >
            <img
                    class="m-auto flex-none"
                    style="max-height: 24px; max-width: 24px"
                    src="../../../assets/images/icon/more_option.svg"
                    alt=""
            >
        </v-btn>
    </v-card>
</template>

<style scoped>

</style>
