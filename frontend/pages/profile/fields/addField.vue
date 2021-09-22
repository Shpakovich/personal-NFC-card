<script>
    import { createNamespacedHelpers } from 'vuex';
    const fieldsStore = createNamespacedHelpers('fields');
    const profileStore = createNamespacedHelpers( 'profile');

    import Vue from 'vue'
    import VueMask from 'v-mask'
    Vue.use(VueMask);

    export default {
        name: "addField",
        layout: "addFields",

        data: () => ({
            fieldValue: '',
            type: 'text',
            loading: false,
            valid: false,
            isContactViber: true,
            valueRules: [
                v => !!v || 'Поле не должно быть пустым'
            ],
            mask: '',
            maskContinue: 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
            isMaskOff: false,
            placeholder: ''
        }),

        computed:{
            ...profileStore.mapState({
                profile: (state) => state,
            }),

            ...fieldsStore.mapState({
                filedInfo: (state) => state.currentField,
            }),

            getPlaceholder () {
                return 'Ввведите ' + this.filedInfo?.title;
            },
            isViber () {
                return this.filedInfo.title === 'Viber';
            },
            hasMaskField() {
                return !(this.filedInfo.title === 'Email' ||
                    this.filedInfo.title === 'Ссылка на сайт' ||
                    this.filedInfo.title === 'Whatsapp');
            },
            fieldType () {
                this.isMaskOff ? this.type = 'url' : this.type = 'text';
                return this.type;
            }
        },

        async asyncData ({ route, store }) {
            const fieldID = route.query?.id;
            if (fieldID) {
                await store.dispatch('fields/getFieldInfo', fieldID)
                    .then(() => {
                    })
                    .catch((e) => console.log('fields/getFieldInfo error' + e));
            }
            if(!store.state.profile?.id) {
                await store.dispatch('profile/getAllProfilesInfo')
                    .catch((e) => console.log('profile/getAllProfilesInfo error' + e));
            }
        },

        async mounted() {
           await this.createFieldMask();
        },


        methods: {
            async setFieldValue(fieldValue) {
                this.loading = true;
                const fieldID = this.$route.query?.id;

                const data = {
                    profile_id: this.profile.id,
                    field_id: fieldID,
                    value: fieldValue,
                    sort: 1 // TODO добавить сортировку?
                };

                await this.$store.dispatch('profile/addFieldInProfile', data)
                    .then((fieldInfo) => {
                    })
                    .catch((e) => console.log('profile/addProfile ' + e))
                    .finally( () => (this.loading = false));
            },
            getIconSrc (fieldInfo) {
                return fieldInfo?.icon?.path;
            },
            changeContactStatus() {
                this.isContactViber = !this.isContactViber;
                this.createFieldMask();
            },
            changeMuskViewStatus() {
                this.isMaskOff = !this.isMaskOff;

                this.isMaskOff ?
                    this.mask = '' :
                    this.createFieldMask();
            },
            createFieldMask() {
                switch (this.filedInfo.title) {
                    case 'Номер телефона': {
                        this.type = 'tel';
                        this.placeholder = '+7 (999) 999-99-99';
                        return this.mask = '+# (###) ###-##-##'
                    }
                    case 'Email': {
                        this.type = 'email';
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
                            this.type = 'tel';
                            this.placeholder = '+7 (999) 999-99-99';
                            return this.mask = '+# (###) ###-##-##';
                        } else {
                            this.placeholder = 'https://chats.viber.com/myid-card';
                            return this.mask = 'https://chats.viber.com/' + this.maskContinue;
                        }
                    }
                    case 'Whatsapp': {
                        this.type = 'tel';
                        this.placeholder = '+7 (999) 999-99-99';
                        return this.mask = '+# (###) ###-##-##'
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
                        return this.mask = 'https://steamcommunity.com/profiles/' + this.maskContinue
                    }
                    case 'Discord': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://discord.gg/' + this.maskContinue
                    }
                }
            },
            submitForm (fieldValue) {
                this.setFieldValue(fieldValue);
            }
        }
    }
</script>

<template>
    <v-container v-if="filedInfo" class="py-11 px-11">
        <h3 style="font-size: 24px; line-height: 35px;" class="text-center font-bold font-croc mb-2">{{ filedInfo.title }}</h3>
        <v-btn
                icon
                class="rounded-lg flex-initial font-bold w-4/12 mb-3 ml-1.5 btn-back"
                max-width="110px"
                min-width="100px"
                height="48"
                color="secondary"
                to="/profile/fields/addFields"
        >
            <img src="../../../assets/images/icon/icon-arrow-left.svg" alt="">
            Назад
        </v-btn>
        <v-row class="justify-center mt-10" style="height: 50px;">
            <div class="flex justify-center" style=" width: 36px; max-width: 36px; height: 36px;">
                <img
                        class="m-auto flex-none"
                        style="max-height: 50px; height: 50px; width: 50px; max-width: 50px"
                        :src="getIconSrc(filedInfo)"
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
                @submit.prevent="submitForm(fieldValue)"
        >
            <div v-if="hasMaskField" class="flex flex-row justify-around ml-4 mb-6">
                <input @click="changeMuskViewStatus" :checked="isMaskOff" class="ml-4 font-croc custom-checkbox" type="checkbox" id="muskOn">
                <label for="muskOn">Отключить маску контакта</label>
            </div>
            <div v-if="isViber" class="flex flex-row justify-around ml-4 mb-6">
                <input @click="changeContactStatus" :checked="isContactViber" class="ml-4 font-croc custom-checkbox" type="radio" id="name" name="privacy">
                <label for="name">Контакт</label>
                <input @click="changeContactStatus" :checked="!isContactViber" class="ml-4 font-croc custom-checkbox" type="radio" id="nickname" name="privacy">
                <label for="nickname">Чат/Группа</label>
            </div>

            <v-text-field
                    v-model="fieldValue"
                    v-mask="mask"
                    class="font-croc"
                    :label="filedInfo.title"
                    :rules="valueRules"
                    :type="fieldType"
                    :id="filedInfo.title"
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
                    @click="setFieldValue(fieldValue)"
            >
                Сохранить
            </v-btn>
        </v-form>
    </v-container>
</template>

<style lang="scss">
    .custom-checkbox {
        position: absolute;
        z-index: -1;
        opacity: 0;
    }

    .custom-checkbox+label {
        display: inline-flex;
        align-items: center;
        user-select: none;
    }
    .custom-checkbox+label::before {
        content: '';
        display: inline-block;
        width: 1.5rem;
        height: 1.5rem;
        flex-shrink: 0;
        flex-grow: 0;
        border: 1px solid $secondary;
        border-radius: 4px;
        margin-right: 0.5rem;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 50% 50%;
    }

    .custom-checkbox:checked+label::before {
        border-color: $secondary;
        background-color: $secondary;
        filter: drop-shadow(0px 4px 8px rgba(50, 50, 71, 0.16));
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
    }

    label {
        font-size: 12px;
        line-height: 20px;
        color: #68676C;
    }

    .v-input__slot {
        min-height: 50px!important;
    }

    .v-text-field input{
        padding: 12px 0 0 !important;
    }
</style>
