<script>
    export default {
        name: "profileHeader"
    }
</script>

<template>
    <v-container class="pt-11 pb-0 px-11">
    <v-row>
        <v-btn
                icon
                class="rounded-lg font-bold w-4/12"
                max-width="90px"
                min-width="80px"
                height="48"
                color="#FF645A"
                @click="$auth.logout()"
        >
            Выйти
        </v-btn>
        <h2 class="m-auto mt-1.5 font-gilroy text-lg ">Профиль</h2>
        <v-btn
                icon
                class="rounded-lg font-bold w-4/12"
                max-width="90px"
                min-width="80px"
                height="48"
                color="#313131"
                to="/"
        >
            QR cod
        </v-btn>
    </v-row>
    </v-container>
</template>

<style scoped>

</style>
