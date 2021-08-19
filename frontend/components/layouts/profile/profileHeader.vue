<script>
    export default {
        name: "profileHeader",

        computed: {
            headerTitle () {
                let header = '';

                switch (this.$route.name) {
                    case 'profile-favorite': {
                        return header = 'Избранное';
                    }
                    case 'profile-page': {
                        return header = 'Профиль';
                    }
                    case 'profile-watches': {
                        return header = 'Просмотры';
                    }
                    case 'profile-settings': {
                        return header = 'Настройки';
                    }
                }

                return header;
            }
        }
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
        <h2 class="m-auto mt-1.5 font-gilroy text-lg ">{{ headerTitle }}</h2>
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
