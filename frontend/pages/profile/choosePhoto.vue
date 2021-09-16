<script>
    import {createNamespacedHelpers} from 'vuex';

    const profileStore = createNamespacedHelpers( 'profile');

    export default {
        name: "choosePhoto",
        layout: "createProfile",

        data: () => ({
            rules: [
                value => !value || value.size < 5000000 || 'Размер фото не должен превышать 5 MB!',
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
                formData.append('profile_id', this.profile?.id);

                await this.$store.dispatch('profile/addPhotoProfile', formData)
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
                max-width="110px"
                min-width="100px"
                height="48"
                color="secondary"
                to="/"
        >
            <img src="../../assets/images/icon/icon-arrow-left.svg" alt="">
            Назад
        </v-btn>

        <div class="flex flex-col mt-8 mb-6">
            <img style="width: 150px; height: 150px;" class="m-auto mb-12" src="../../assets/images/addImageIcon.svg" alt="">
            <v-file-input
                    v-model="chosenFile"
                    label="Добавить фото"
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
    </v-container>
</template>

<style scoped>

</style>
