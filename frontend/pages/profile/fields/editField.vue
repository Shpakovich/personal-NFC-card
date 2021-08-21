<script>
    import { createNamespacedHelpers } from 'vuex';
    const profile = createNamespacedHelpers('profile');

    export default {
        name: "editField",
        layout: "addFields",

        data: () => ({
            fieldValue: '',
            loading: false,
            valid: false,
            valueRules: [
                v => !!v || 'Поле не должно быть пустым'
            ]
        }),

        computed: {
            ...profile.mapState({
                profile: (state) => state,
                profileField: (state) => state.fieldToEdit,
            }),
            getPlaceholder () {
                return 'Ввведите ' + this.profileField.title;
            }
        },

        async asyncData ({ route, store }) {
            const fieldID = route.query?.id;

            await store.dispatch('profile/getFieldInProfile', fieldID)
                .then(() => {
                })
                .catch((e) => console.log('profile/getFieldInProfile error ' + e));

        },

        mounted() {
            // TODO Сделать на инпуте сброс
            this.fieldValue = this.profileField.value;
        },

        methods: {
            getIconSrc (profileField) {
                return profileField?.icon?.path;
            },
            async editProfilesField () {
                this.loading = true;
                const data = {
                    id: this.profileField.id,
                    field_id: 'f7963742-c127-452b-913c-50bf92a910f4', // TODO id самого филда, как при создании
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
            }
        }
    }
</script>

<template>
    <v-container v-if="profileField" class="py-11 px-11">
        <h3 style="font-size: 24px; line-height: 35px;" class="text-center font-bold font-croc mb-2">{{ profileField.title }}</h3>
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
            <v-text-field
                    v-model="fieldValue"
                    class="font-croc"
                    :label="profileField.title"
                    :rules="valueRules"
                    required
                    outlined
                    :placeholder="getPlaceholder"
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
