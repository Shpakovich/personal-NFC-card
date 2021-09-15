<script>
    export default {
        name: "nfc_on_ios14"
    }
</script>

<template>
    <v-container class="py-11 px-11 flex flex-col justify-center xl:flex xl:flex-row xl:h-full">
        <v-btn
                icon
                class="rounded-lg font-bold mb-6 btn-back"
                max-width="110px"
                min-width="100px"
                height="48"
                color="secondary"
                to="/info/supportedDevice"
        >
            <img src="../../assets/images/icon/icon-arrow-left.svg" alt="">
            Назад
        </v-btn>
        <div class="flex flex-col xl:m-auto ios14TextContainer xl:mt-12">
            <h2 class="font-bold font-gilroy text-xl mb-6">
                Как найти и использовать новый сканер тегов NFC в iOS 14
            </h2>
            <p class="font-gilroy text-lg mb-2">
                Чтобы использовать тег NFC на устройстве iOS, вам необходимо добавить его в качестве модуля центра управления,
                прежде чем вы сможете получить к нему прямой доступ. Давайте посмотрим на процедуру.
            </p>
            <p class="font-gilroy text-lg mb-2">
                Разблокируйте свое устройство iOS и откройте приложение «Настройки».
            </p>
            <img
                    class="rounded-md my-2"
                    src="../../assets/images/settings-ios.jpg"
                    alt=""
            />
            <br/>

            <p class="font-gilroy text-lg mb-2">
                Теперь нажмите «Центр управления» (Control Center).
            </p>
            <img
                    class="rounded-md my-2"
                    src="../../assets/images/control_center-ios.jpg"
                    alt=""
            />
            <br/>

            <p class="font-gilroy text-lg mb-2">
                Прокрутите вниз и найдите «Сканер тегов NFC» в разделе «Дополнительные элементы управления».
                <br />Найдя, нажмите «+», чтобы добавить его в свой центр управления.
            </p>
            <img
                    class="rounded-md my-2"
                    src="../../assets/images/NFC_tag_reader-ios.jpg"
                    alt=""
            />
            <br/>

            <p class="font-gilroy text-lg mb-2">
                Закройте приложение «Настройки». Теперь запустите центр управления (панель быстрого доступа) и коснитесь значка сканера тегов NFC.
            </p>
            <img
                    class="rounded-md my-2"
                    src="../../assets/images/panel_icon-ios.jpg"
                    alt=""
            />
            <br/>

            <p class="font-gilroy text-lg mb-2">
                Теперь просто поднесите устройство к совместимому тегу NFC, и оно должно автоматически просканировать его содержимое.
            </p>
            <img
                    class="rounded-md my-2"
                    src="../../assets/images/final_tag_reader-ios.jpg"
                    alt=""
            />
            <br/>

            <p class="font-gilroy text-lg mb-2">
                У вас появился быстрый доступ к сканеру NFC прямо из центра управления.
            </p>
        </div>
    </v-container>
</template>

<style lang="scss">
    .ios14TextContainer{
        @media (min-width: 840px) { // todo вынести в переменную
            max-width: 600px;
            margin: auto;
        }
    }
</style>
