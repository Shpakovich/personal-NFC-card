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
            </p>
            <p class="font-gilroy text-sm text-center">
                iPhone SE 2 gen (2020 г)<br />
                iPhone Xs<br />
                iPhone Xs Max<br />
                iPhone Xr<br />
                iPhone 11<br />
                iPhone 11 Pro<br />
                iPhone 11 Pro Max<br />
                iPhone 12<br />
                iPhone 12 mini<br />
                iPhone 12 Pro<br />
                iPhone 12 Pro Max<br />
                Все будущие модели
            </p>
            <br><br>

            <h2 class="font-gilroy text-lg">
                iPhone
                Срабатывание в один клик
                (только для iOS 14 и новее)
            </h2>
            <nuxt-link
                    class="font-gilroy text-lg"
                    to="/info/nfc_on_ios14"
            >
                Подробная инструкция
            </nuxt-link>
            <p class="font-gilroy text-sm text-center mt-2">
                iPhone 7<br />
                iPhone 7 Plus<br />
                iPhone 8<br />
                iPhone 8 Plus<br />
                iPhone X
            </p>
        </div>
    </v-container>
</template>

<style scoped>

</style>
