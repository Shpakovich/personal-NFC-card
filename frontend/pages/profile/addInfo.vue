<script>
    import { createNamespacedHelpers } from 'vuex';
    const { mapState } = createNamespacedHelpers('profile');

    export default {
        name: "addInfo",
        layout: "createProfile",

        data: () => ({
            post: '',
            description: '',
            descriptionRules: [v => v?.length < 51 || 'Максимум 50 символов'],
            valid: false
        }),

        computed: {
            ...mapState({
                profile: (state) => state
            })
        },

        methods: {
            async addInfoInProfile() {
                const data = {
                    name: this.profile?.name,
                    nickname: this.profile?.nickname,
                    default_name: this.profile?.default_name,
                    title: this.profile?.title,
                    id: this.profile?.id, // id профиля который меняем
                    post: this.post,
                    description: this.description
                };
                await this.$store.dispatch('profile/editProfileInfo', data)
                    .then((data) => this.$router.push('/profile/choosePhoto'))
                    .catch((e) => console.log('profile/editProfileInfo error' + e));
            },
            nextStep() {
                this.$router.push('/profile/choosePhoto');
            }
        }
    }
</script>

<template>
    <v-container class="py-11 px-11">
        <img
                src="../../assets/images/myID-logo.svg"
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
                to="/"
        >
            <img src="../../assets/images/icon/icon-arrow-left.svg" alt="">
            Назад
        </v-btn>

        <v-form
                ref="form"
                class="flex flex-col"
                v-model="valid"
                lazy-validation
        >
            <v-text-field
                    v-model="post"
                    class="font-croc"
                    label="Род деятельности"
                    id="post"
                    required
                    outlined
                    placeholder="Разработчик, event-менеджер и др."
            ></v-text-field>

            <v-text-field
                    v-model="description"
                    class="font-croc"
                    label="Описание"
                    id="bio"
                    :rules="descriptionRules"
                    counter="50"
                    height="78"
                    outlined
                    placeholder="Напишите пару слов о себе"
            ></v-text-field>

            <div class="flex flex-col">
                <v-btn
                        :disabled="!valid"
                        color="secondary"
                        height="48"
                        width="155"
                        max-width="186"
                        class="m-auto w-2/5 mb-2"
                        @click="addInfoInProfile()"
                >
                    Далее
                </v-btn>
                <v-btn
                        icon
                        class="m-auto rounded-lg flex-initial font-bold w-2/5 mb-6"
                        color="primary"
                        height="48"
                        width="155"
                        max-width="186"
                        @click="nextStep()"
                >
                    Пропустить
                </v-btn>
            </div>
        </v-form>
    </v-container>
</template>

<style scoped>

</style>
