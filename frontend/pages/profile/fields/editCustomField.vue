<script>
    import { createNamespacedHelpers } from 'vuex';
    const fieldsStore = createNamespacedHelpers('fields');
    const profile = createNamespacedHelpers('profile');

    export default {
        name: "editCustomField",

        data: () => ({
            fieldValue: '',
            type: 'text',
            loading: false,
            valid: false,
            valueRules: [
                v => !!v || 'Поле не должно быть пустым'
            ],
            placeholder: ''
        }),

        computed: {
            ...profile.mapState({
                profile: (state) => state,
                profileField: (state) => state.fieldToEdit,
            }),
            ...fieldsStore.mapState({
                filedInfo: (state) => state.currentField,
            }),
            getPlaceholder () {
                return 'Ввведите ' + this.profileField.title;
            },
            fieldType () {
                this.isMaskOff ? this.type = 'url' : this.type = 'text';
                return this.type;
            }
        },

        async asyncData ({ route, store }) {
            const fieldID = route.query?.id;

            if (fieldID) {
                await store.dispatch('fields/getCustomsFieldInfo', fieldID)
                    .catch((e) => console.log('fields/getCustomsFieldInfo error' + e));
            }

        },

        async mounted() {
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
                    field_id: this.profileField.field_id,
                    value: this.fieldValue,
                };

                await this.$store.dispatch('fields/editCustomFieldInProfile', data)
                    .catch((e) => console.log('fields/editCustomFieldInProfile error ' + e))
                    .finally(() => this.loading = false);
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
                max-width="110px"
                min-width="100px"
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
                        src="../../../assets/images/customIcon.svg"
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
            <v-text-field
                    v-model="fieldValue"
                    class="font-croc"
                    :label="profileField.title"
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
                    @click="editProfilesField()"
            >
                Сохранить
            </v-btn>
        </v-form>
    </v-container>
</template>

<style scoped>

</style>
