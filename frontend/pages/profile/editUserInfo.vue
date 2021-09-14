<script>
    import Vue from 'vue'
    import VueMask from 'v-mask'
    Vue.use(VueMask);
    import userHead from "../../components/profile/userHead";
    import profileEditHeader from "../../components/layouts/profile/profileEditHeader";

    import { createNamespacedHelpers } from 'vuex';
    const { mapState } = createNamespacedHelpers('profile');

    export default {
        name: "editUserInfo",
        layout: "profileEdit",

        components: {
            userHead,
            profileEditHeader
        },

        data: () => ({
            nickname: '',
            name: '',
            post: '',
            nick: '',
            default_name: 1,
            description: '',
            errorMessages: '',
            mask: 'https://myid-card.ru/NNNNNNNNNNNN',
            valid: false
        }),

        computed:{
            ...mapState({
                profile: (state) => state
            })
        },

        async asyncData ({ route, store }) {
            await store.dispatch('profile/getAllProfilesInfo')
                .catch((e) => console.log('profile/getAllProfilesInfo error' + e));

        },

        async mounted() {
            this.nickname = this.profile.nickname; // добавляем в инпуты значения профиля
            this.name = this.profile.name;
            this.default_name = this.profile.default_name;
            this.post = this.profile?.post;
            this.nick = this.profile.card?.alias ? 'https://myid-card.ru/' + this.profile.card?.alias : 'https://myid-card.ru/';
            this.description = this.profile.description;
        },

        methods: {
            setDefaultName() {
                if(this.default_name === 2) {
                    this.default_name = 1
                } else {
                    this.default_name = 2
                }
            },
            resetError () {
                this.errorMessages = '';
            },
            async editInfoInProfile() {
                const data = {
                    name: this.name,
                    title: this.name,
                    nickname: this.nickname ?? '',
                    default_name: this.default_name,
                    id: this.profile?.id, // id профиля который меняем
                    post: this.post ?? '',
                    nick: this.nick ?? '',
                    description: this.description ?? ''
                };
                await this.$store.dispatch('profile/editProfileInfo', data)
                    .then((data) => {})
                    .catch((e) => console.log('profile/editProfileInfo error' + e));
            },
            copyToClipboard() {
                const textBox = document.getElementById("alias");
                textBox.select();
                document.execCommand("copy");
            }
        }
    }
</script>

<template>
    <div>
        <profileEditHeader @editUser="editInfoInProfile" />
        <v-container class="px-11 xl:flex xl:flex-row xl:h-full xl:justify-between xl:mt-6">
            <userHead
                    class="userHead__xl"
                    :isShow="false"
                    :user="profile"
                    :edit="true"
            />

            <v-form
                    ref="form"
                    class="flex flex-col mt-6 fields-block__xl"
                    v-model="valid"
                    lazy-validation
            >
                <v-text-field
                        v-model="name"
                        class="font-croc"
                        label="Имя"
                        required
                        outlined
                        placeholder="Ваше имя"
                ></v-text-field>

                <v-text-field
                        v-model="nickname"
                        class="font-croc"
                        label="Никнейм"
                        outlined
                        hint="Можно использовать вместо имени"
                        placeholder="my-Nick"
                ></v-text-field>

                <div class="flex flex-row justify-around ml-4 mb-6">
                    <input @click="setDefaultName()" :checked="default_name === 1" class="ml-4 font-croc custom-checkbox" type="radio" id="name" name="privacy">
                    <label for="name">Имя</label>
                    <input @click="setDefaultName()" :checked="default_name === 2" class="ml-4 font-croc custom-checkbox" type="radio" id="nickname" name="privacy">
                    <label for="nickname">Никнейм</label>
                </div>

                <v-text-field
                        v-model="post"
                        class="font-croc"
                        label="Род деятельности"
                        required
                        outlined
                        placeholder="Разработчик, event-менеджер и др."
                ></v-text-field>

                <div class="relative">
                    <v-text-field
                            readonly
                            v-model="nick"
                            v-mask="mask"
                            :error-messages="errorMessages"
                            v-on:keyup="resetError()"
                            class="font-croc"
                            id="alias"
                            label="Адрес страницы"
                            required
                            outlined
                            placeholder="https://myid-card.ru/myNick"
                    >
                    </v-text-field>
                    <v-btn
                            icon
                            class="rounded-lg"
                            max-width="24px"
                            min-width="24px"
                            height="24"
                            style="right: 25px; top: 15px; position: absolute!important;"
                            @click="copyToClipboard()"
                    >
                        <img
                                style="width: 24px; height: 24px;"
                                src="../../assets/images/icon/copy_to_clipboard.svg"
                                alt="copy"
                        />
                    </v-btn>
                </div>

                <v-text-field
                        v-model="description"
                        class="font-croc"
                        label="Описание"
                        height="78"
                        outlined
                        placeholder="Напишите пару слов о себе"
                ></v-text-field>
            </v-form>
        </v-container>
    </div>
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
