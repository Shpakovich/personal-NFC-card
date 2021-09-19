<script>
    import { createNamespacedHelpers } from 'vuex';
    const profile = createNamespacedHelpers('profile');

    import Vue from 'vue'
    import VueMask from 'v-mask'
    Vue.use(VueMask);

    export default {
        name: "editField",
        layout: "addFields",

        data: () => ({
            fieldValue: '',
            loading: false,
            valid: false,
            isContactViber: true,
            valueRules: [
                v => !!v || 'Поле не должно быть пустым'
            ],
            mask: '',
            placeholder: ''
        }),

        computed: {
            ...profile.mapState({
                profile: (state) => state,
                profileField: (state) => state.fieldToEdit,
            }),
            getPlaceholder () {
                return 'Ввведите ' + this.profileField.title;
            },
            isViber () {
                return this.filedInfo.title === 'Viber';
            }
        },

        async asyncData ({ route, store }) {
            const fieldID = route.query?.id;

            await store.dispatch('profile/getFieldInProfile', fieldID)
                .then(() => {
                })
                .catch((e) => console.log('profile/getFieldInProfile error ' + e));

        },

        async mounted() {
            // TODO Сделать на инпуте сброс
            this.fieldValue = this.profileField.value;
            await this.createFieldMask();
        },

        methods: {
            getIconSrc (profileField) {
                return profileField?.icon?.path;
            },
            async editProfilesField () {
                this.loading = true;
                const data = {
                    id: this.profileField.id,
                    field_id: this.profileField.field_id,
                    value: this.fieldValue,
                    sort: this.profileField.sort
                };

                await this.$store.dispatch('profile/editFieldInProfile', data)
                    .then(() => {
                        this.$router.push('/profile/page')
                    })
                    .catch((e) => console.log('profile/editFieldInProfile error ' + e))
                .finally(() =>
                    this.loading = false
                );
            },
            changeContactStatus() {
                this.isContactViber = !this.isContactViber;
                this.createFieldMask();
            },
            createFieldMask() {
                switch (this.filedInfo.title) {
                    case 'Номер телефона': {
                        this.placeholder = '+7 (999) 999-99-99';
                        return this.mask = '+# (###) ###-##-##'
                    }
                    case 'Email': {
                        return this.placeholder = 'myid-card.ru@gmail.com';
                    }
                    case 'Ссылка на сайт': {
                        return this.placeholder = 'https://myid-card.ru/';
                    }
                    case 'Facebook': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://www.facebook.com/' + this.maskContinue
                    }
                    case 'Instagram': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://instagram.com/' + this.maskContinue
                    }
                    case 'Telegram': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://t.me/' + this.maskContinue
                    }
                    case 'VK': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://vk.com/' + this.maskContinue
                    }
                    case 'Viber': {
                        this.placeholder = this.getPlaceholder;
                        if (this.isContactViber) {
                            this.placeholder = '+7 (999) 999-99-99';
                            return this.mask = '+# (###) ###-##-##';
                        } else {
                            this.placeholder = 'https://chats.viber.com/myid-card';
                            return this.mask = 'https://chats.viber.com/' + this.maskContinue;
                        }
                    }
                    case 'Linkedin': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://www.linkedin.com/' + this.maskContinue
                    }
                    case 'Twitter': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://twitter.com/' + this.maskContinue
                    }
                    case 'TikTok': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://vm.tiktok.com/' + this.maskContinue
                    }
                    case 'Pinterest': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://www.pinterest.ru/' + this.maskContinue
                    }
                    case 'Youtube': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://www.youtube.com/channel/' + this.maskContinue
                    }
                    case 'Twitch': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://www.twitch.tv/user/' + this.maskContinue
                    }
                    case 'Apple Music': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://music.apple.com/ru/playlist/' + this.maskContinue
                    }
                    case 'Spotify': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://open.spotify.com/user/' + this.maskContinue
                    }
                    case 'Yandex music': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://music.yandex.ru/users/' + this.maskContinue
                    }
                    case 'GitHub': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://githab.com/' + this.maskContinue
                    }
                    case 'GitLab': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://gitlab.com/' + this.maskContinue
                    }
                    case 'Habr': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://habrahabr.ru/' + this.maskContinue
                    }
                    case 'Steam': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'http://steamcommunity.com/profiles/' + this.maskContinue
                    }
                    case 'Discord': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://discord.gg/' + this.maskContinue
                    }
                }
            }
        }
    }
</script>

<template>
    <v-container v-if="profileField" class="py-11 px-11">
        <h3 style="font-size: 24px; line-height: 35px;" class="text-center font-bold font-croc mb-2">{{ profileField.title }}</h3>
        <!-- <p class="text-center text-sm font-croc mb-2">Укажи ссылку, начиная с https<br/>(например,
            <a href="https://Instagram.com/crocinc" target="_blank">
                https://Instagram.com/crocinc
            </a>)</p> -->
        <v-btn
                icon
                class="rounded-lg flex-initial font-bold w-4/12 mb-3 ml-1.5 btn-back"
                max-width="90px"
                min-width="80px"
                height="48"
                color="secondary"
                to="/profile/page"
        >
            <img src="../../../assets/images/icon/icon-arrow-left.svg" alt="">
            Назад
        </v-btn>
        <v-row class="justify-center mt-10" style="height: 50px;">
            <div class="flex justify-center" style=" width: 36px; max-width: 36px; height: 36px;">
                <img
                        class="m-auto flex-none"
                        style="max-height: 50px; height: 50px; width: 50px; max-width: 50px"
                        :src="getIconSrc(profileField)"
                        alt=""
                >
            </div>
            <p class="my-auto ml-8 font-croc" style="font-size: 17px;line-height: 24px;padding: 0">
                Введите информацию<br>
                о себе ниже
            </p>
        </v-row>
        <v-form
                ref="form"
                class="flex flex-col mt-14"
                v-model="valid"
        >
            <div v-if="isViber" class="flex flex-row justify-around ml-4 mb-6">
                <input @click="changeContactStatus" :checked="isContactViber" class="ml-4 font-croc custom-checkbox" type="radio" id="name" name="privacy">
                <label for="name">Контакт</label>
                <input @click="changeContactStatus" :checked="!isContactViber" class="ml-4 font-croc custom-checkbox" type="radio" id="nickname" name="privacy">
                <label for="nickname">Чат/Группа</label>
            </div
            <v-text-field
                    v-model="fieldValue"
                    v-mask="mask"
                    class="font-croc"
                    :label="profileField.title"
                    :rules="valueRules"
                    required
                    outlined
                    :placeholder="placeholder"
            ></v-text-field>

            <v-btn
                    :disabled="!valid"
                    :loading="loading"
                    color="secondary"
                    class="rounded-lg flex-initial m-auto w-8/12"
                    max-width="225px"
                    min-width="150px"
                    height="48"
                    @click="editProfilesField()"
            >
                Сохранить
            </v-btn>
        </v-form>
    </v-container>
</template>

<style scoped>

</style>
