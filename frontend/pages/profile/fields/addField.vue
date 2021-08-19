<script>
    import { createNamespacedHelpers } from 'vuex';
    const fieldsStore = createNamespacedHelpers('fields');
    const profileStore = createNamespacedHelpers( 'profile');

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

        async mounted() {
            const fieldID = this.$route.query?.id;
            if (fieldID) {
                await this.$store.dispatch('fields/getFieldInfo', fieldID)
                    .then(() => {})
                    .catch((e) => console.log('fields/getFieldInfo error' + e));
            }
        },

        methods: {
            async setFieldValue(fieldValue) {
                const fieldID = this.$route.query?.id;

                console.log(this.profile)
                const data = {
                    profile_id: this.profile.id,
                    field_id: fieldID,
                    value: fieldValue,
                    sort: 1 // TODO добавить сортировку?
                };
                await this.$store.dispatch('profile/addFieldInProfile', data)
                    .then((fieldInfo) => {
                    })
                    .catch((e) => console.log('profile/addProfile' + e));
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
                max-width="90px"
                min-width="80px"
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
                        src="../../../assets/images/icon/fi_phone.svg"
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
                    :label="filedInfo.title"
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
                    @click="setFieldValue(fieldValue)"
            >
                Сохранить
            </v-btn>
        </v-form>
    </v-container>
</template>

<style scoped>

</style>
