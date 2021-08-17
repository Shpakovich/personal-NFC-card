<script>
    import userHead from "../../components/profile/userHead";

    import { createNamespacedHelpers } from 'vuex';
    const { mapState } = createNamespacedHelpers('profile');

    export default {
        name: "editUserInfo",
        layout: "profileEdit",

        components: {
            userHead
        },

        data: () => ({
            nickname: '',
            name: '',
            post: '',
            nick: '',
            valid: false
        }),

        async mounted() { // TODO передалать на asyncData когда пойму почему не приходят данные из api
            let profile;

            await this.$store.dispatch('profile/getAllProfilesInfo')
                .then((profiles) => { console.log(profiles) })
                .catch((e) => console.log('profile/getAllProfilesInfo error' + e));
            // Получем id профиля по пользвоателю


            return profile;
        },

        computed:{
            ...mapState({
                profile: (state) => state
            })
        },

        methods: {
            setDefaultName() {
                this.checkbox = !this.checkbox
            }
        }
    }
</script>

<template>
    <v-container class="px-11">
        <userHead :user="profile" :edit="true" />

        <v-form
                ref="form"
                class="flex flex-col mt-6"
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
                <input @click="setDefaultName()" class="ml-4 font-croc custom-checkbox" type="radio" id="name" name="privacy">
                <label for="name">Имя</label>
                <input @click="setDefaultName()" class="ml-4 font-croc custom-checkbox" type="radio" id="nickname" name="privacy">
                <label for="nickname">Никнейм</label>
            </div>

            <v-text-field
                    v-model="post"
                    class="font-croc"
                    label="Должность"
                    required
                    outlined
                    placeholder="Напишите вашу должность"
            ></v-text-field>

            <v-text-field
                    v-model="nick"
                    v-mask="mask"
                    :error-messages="errorMessages"
                    v-on:keyup="resetError()"
                    class="font-croc"
                    label="Адрес страницы"
                    required
                    outlined
                    placeholder="https://myid-card/myNick"
            ></v-text-field>

            <v-text-field
                    v-model="description"
                    class="font-croc"
                    label="Описание"
                    outlined
                    placeholder="Напишите пару слов о себе"
            ></v-text-field>
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
