<script>
    import {createNamespacedHelpers} from 'vuex';

    const profileStore = createNamespacedHelpers( 'profile');

    export default {
        name: "choosePhoto",
        layout: "createProfile",

        data: () => ({
            rules: [
                value => !value || value.size < 2000000 || 'Avatar size should be less than 2 MB!',
            ],
            chosenFile: {},
            valid: false
        }),

        computed: {
            ...profileStore.mapState({
                profile: (state) => state,
            })
        },

        methods: {
            async addPhotoToProfile(chosenFile) {
                let formData = new FormData();

                formData.append('file', chosenFile);
                formData.append('profile_id', 'a12524df-e7ad-45ae-810e-6e4cdb62d427');

                await this.$store.dispatch('profile/addPhotoProfile', formData)
                    .then(() => console.log(''))
                    .catch((e) => console.log('profile/addPhotoProfile error' + e));
            },
            nextStep() {
                this.$router.push('/profile/page');
            }
        }
    }
</script>

<template>
    <v-container class="py-11 px-11">
        <v-btn
                icon
                class="rounded-lg flex-initial font-bold w-4/12 mb-6 ml-1.5 btn-back"
                max-width="90px"
                min-width="80px"
                height="48"
                color="secondary"
                to="/"
        >
            <img src="../../assets/images/icon/icon-arrow-left.svg" alt="">
            Назад
        </v-btn>

        <div class="flex flex-col mt-8 mb-12">
            <img class="m-auto mb-7" src="../../assets/images/addImageIcon.svg" alt="">
            <v-file-input
                    v-model="chosenFile"
                    label="File input"
                    outlined
                    dense
            ></v-file-input>
        </div>

            <div class="flex flex-col">
                <v-btn
                        color="secondary"
                        height="48"
                        width="155"
                        max-width="186"
                        class="m-auto w-2/5 mb-2"
                        @click="addPhotoToProfile(chosenFile)"
                >
                    Сохранить
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
