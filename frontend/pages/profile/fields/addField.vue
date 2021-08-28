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
            loading: false,
            valid: false,
            valueRules: [
                v => !!v || 'Поле не должно быть пустым'
            ],
            mask: '',
            maskContinue: 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
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
                    .catch((e) => console.log('profile/addProfile ' + e));
            },
            getIconSrc (fieldInfo) {
                return fieldInfo?.icon?.path;
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
                        return this.mask = 'https://instagram.com/'
                    }
                    case 'Telegram': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://t.me/'
                    }
                    case 'VK': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://vk.com/'
                    }
                    case 'Linkedin': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://www.linkedin.com/'
                    }
                    case 'Twitter': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://twitter.com/'
                    }
                    case 'TikTok': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://vm.tiktok.com/'
                    }
                    case 'Pinterest': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://www.pinterest.ru/'
                    }
                    case 'Youtube': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://www.youtube.com/channel/'
                    }
                    case 'Twitch': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://www.twitch.tv/user/'
                    }
                    case 'Apple Music': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://music.apple.com/ru/playlist/'
                    }
                    case 'Spotify': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://open.spotify.com/user/'
                    }
                    case 'Yandex music': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://music.yandex.ru/users/'
                    }
                    case 'GitHub': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'http://githab.com/'
                    }
                    case 'GitLab': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'http://gitlab.com/'
                    }
                    case 'Habr': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'http://habrahabr.ru/'
                    }
                    case 'Steam': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'http://steamcommunity.com/id/'
                    }
                    case 'Discord': {
                        this.placeholder = this.getPlaceholder;
                        return this.mask = 'https://discord.gg/'
                    }
                }
            }
        }
    }
</script>

<template>
    <v-container v-if="filedInfo" class="py-11 px-11">
        <h3 style="font-size: 24px; line-height: 35px;" class="text-center font-bold font-croc mb-2">{{ filedInfo.title }}</h3>
        <p class="text-center text-sm font-croc mb-2">Укажи ссылку, начиная с https<br/>(например,
            <a href="https://Instagram.com/crocinc" target="_blank">
                https://Instagram.com/crocinc
            </a>)</p>
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
        >
            <v-text-field
                    v-model="fieldValue"
                    v-mask="mask"
                    class="font-croc"
                    :label="filedInfo.title"
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
                    @click="setFieldValue(fieldValue)"
            >
                Сохранить
            </v-btn>
        </v-form>
    </v-container>
</template>

<style scoped>

</style>
