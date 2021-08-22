<script>
    export default {
        name: "supportedDevice"
    }
</script>

<template>
    <v-container class="py-11 px-11 flex flex-col justify-center">
        <v-btn
                icon
                class="font-bold mb-6"
                max-width="110px"
                width="80px"
                height="48"
                color="secondary"
                to="/"
        >
            <img src="../../assets/images/icon/icon-arrow-left.svg" alt="">
            Назад
        </v-btn>
        <div>
            <h1 class="font-gilroy text-xl mb-6">
                Поддерживаемые устройства
            </h1>
            <h2 class="font-gilroy text-lg mb-2">
                Android
            </h2>
            <p class="font-gilroy text-sm">
                Срабатывание в одно прикосновение
                Все модели телефонов, где есть поддержка бесконтактной оплаты (NFC)
            </p>
            <br><br>


            <h2 class="font-gilroy text-lg mb-2">
                iPhone
            </h2>
            <p class="font-gilroy text-sm">
                Срабатывание в одно прикосновение

                iPhone SE 2 gen (2020 г)
                iPhone Xs
                iPhone Xs Max
                iPhone Xr
                iPhone 11
                iPhone 11 Pro
                iPhone 11 Pro Max	iPhone 12
                iPhone 12 mini
                iPhone 12 Pro
                iPhone 12 Pro Max
                Все будущие модели
            </p>
            <br><br>

            <h2 class="font-gilroy text-lg mb-2">
                iPhone
                Срабатывание в один клик
                (только для iOS 14 и новее)
            </h2>
            <p class="font-gilroy text-sm">
                iPhone 7
                iPhone 7 Plus
                iPhone 8
                iPhone 8 Plus
                iPhone X
            </p>
        </div>
    </v-container>
</template>

<style scoped>

</style>
