<script>
    export default {
        name: "profileHeaderDesktop",

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

                if (this.$route.name === 'alias') {
                    return header = 'Профиль';
                }

                return header;
            }
        },

        methods: {
            async logOut () {
                await this.$auth.logout();
                this.resetProfile()
            },
            resetProfile () {
                this.$store.commit('profile/SET_PROFILE_INFO', {});
                this.$store.commit('profile/SET_PROFILE_FIELDS', {});
            },
            async resetShowProfile() {
                await this.$router.push('/');
            }
        }
    }
</script>

<template>
    <v-container class="pt-11 pb-0 px-11">
        <v-row class="xl:flex xl:flex-row xl:justify-between">
            <div class="xl:flex xl:flex-row xl:flex-nowrap">
                <div @click="resetShowProfile()">
                    <img
                            src="../../../assets/images/myID-logo.svg"
                            style="width: 109px; height: 109px;"
                            alt=""
                    />
                </div>
                <h2 class="my-auto font-gilroy text-2xl ml-12">{{ headerTitle }}</h2>
            </div>
            <v-row class="xl:justify-end">
                <v-btn
                        v-if="this.$auth.loggedIn"
                        icon
                        class="rounded-lg font-bold w-4/12 xl:my-auto header-button__xl"
                        height="48"
                        color="#FF645A"
                        @click="logOut()"
                >
                    Выйти
                </v-btn>
                <v-btn
                        v-else
                        icon
                        class="rounded-lg font-bold w-4/12 xl:my-auto header-button__xl"
                        height="48"
                        color="secondary"
                        to="/authorization"
                >
                    Войти
                </v-btn>
            </v-row>
        </v-row>
    </v-container>
</template>

<style lang="scss">
    .header-button__xl {
        max-width: 90px;
        min-width: 80px;
        @media (min-width: 1280px) { // todo вынести в переменную
            font-size: 20px!important;
            line-height: 23.86px!important;
            max-width: 150px;
            min-width: 120px;
        }
    }
</style>
