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
            resetShowProfile() {
                this.$router.push('/');
                let isCalled = false;

                this.$router.afterEach((to, from) => {
                    const isTrueRoute = from.name === 'alias' && to.name === 'index';
                    if (isTrueRoute && !isCalled) {
                        isCalled = true;
                        this.$store.commit('show/RESET_SHOW_PROFILE_INFO');
                    }
                });
            }
        }
    }
</script>

<template>
    <v-container class="pt-11 pb-0 px-11 header-container">
    <v-row class="flex-nowrap">
        <v-btn
                v-if="this.$auth.loggedIn"
                icon
                class="rounded-lg font-bold w-4/12"
                max-width="90px"
                min-width="80px"
                height="48"
                color="#FF645A"
                @click="logOut()"
        >
            Выйти
        </v-btn>
        <v-btn
                v-else
                icon
                class="rounded-lg font-bold w-4/12"
                max-width="90px"
                min-width="80px"
                height="48"
                color="secondary"
                to="/authorization"
        >
            Войти
        </v-btn>
        <h2 class="m-auto mt-1.5 font-gilroy text-lg ">{{ headerTitle }}</h2>
        <div

                @click="resetShowProfile()"
                style="width: 80px;"
        >
            <img
                    src="../../../assets/images/myID-logo.svg"
                    style="width: 45px; height: 45px; margin-left: auto;"
                    alt=""
            />
        </div>
    </v-row>
    </v-container>
</template>

<style lang="scss">
    .header-container {
        @media (min-width: 640px) { // todo вынести в переменную
            max-width: 415px;
        }
    }
</style>
