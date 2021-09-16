<script>
    export default {
        name: "emailSent"
    }
</script>

<template>
    <v-container class="py-11 px-11">
        <img
                src="../assets/images/myID-logo.svg"
                class="mx-auto pb-4"
                alt=""
        />
        <v-btn
                icon
                class="rounded-lg flex-initial font-bold w-4/12 mb-6 ml-1.5 btn-back"
                max-width="110px"
                min-width="100px"
                height="48"
                color="secondary"
                to="/authorization"
        >
            <svg class="button-svg" width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.2075 16.45H10.6925" stroke="#FFA436" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M16.45 10.6924L10.6925 16.4499L16.45 22.2074" stroke="#FFA436" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Назад
        </v-btn>

        <v-row>
            <h3 class="text-center font-gilroy mb-8">
                Письмо со сылкой для сброса пароля уже отправленно вам на почту 📩
            </h3>
            <v-btn
                    color="primary"
                    height="48"
                    max-width="136"
                    class="m-auto w-2/5"
                    to="/"
            >
                    Окей
            </v-btn>
        </v-row>
    </v-container>
</template>

<style scoped>

</style>
