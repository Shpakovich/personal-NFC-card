<script>
    export default {
        name: "choosePhoto",
        layout: "createProfile",

        methods:{
            async addPhotoToProfile() {
                // TODO когда будет инструмент добавления фото
            },
            nextStep() {
                this.$router.push('/profile/edit');
            }
        }
    }
</script>

<template>
    <v-container class="py-11 px-11">
        <v-btn
                icon
                class="rounded-lg flex-initial font-bold w-4/12 mb-6 ml-1.5 btn-back"
                max-width="90px"
                min-width="80px"
                height="48"
                color="secondary"
                to="/"
        >
            <img src="../../assets/images/icon/icon-arrow-left.svg" alt="">
            Назад
        </v-btn>

        <div class="flex flex-col mt-8 mb-12">
            <img class="m-auto mb-7" src="../../assets/images/addImageIcon.svg" alt="">
            <p class="font-gilroy text-center font-bold px-5">
                Загрузите<br/>
                фотографию
            </p>
        </div>

        <div class="flex flex-col">
            <v-btn
                    :disabled="!valid"
                    color="secondary"
                    height="48"
                    width="155"
                    max-width="186"
                    class="m-auto w-2/5 mb-2"
                    @click="addPhotoToProfile()"
            >
                Сохранить
            </v-btn>
            <v-btn
                    icon
                    class="m-auto rounded-lg flex-initial font-bold w-2/5 mb-6"
                    color="primary"
                    height="48"
                    width="155"
                    max-width="186"
                    @click="nextStep()"
            >
                Пропустить
            </v-btn>
        </div>
    </v-container>
</template>

<style scoped>

</style>
