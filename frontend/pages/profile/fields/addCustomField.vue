<script>
    import { createNamespacedHelpers } from 'vuex';
    const fieldsStore = createNamespacedHelpers('fields');
    const profileStore = createNamespacedHelpers( 'profile');

    export default {
        name: "addCustomField",

        data: () => ({
            fieldValue: '',
            type: 'text',
            loading: false,
            valid: false,
            isContactViber: true,
            valueRules: [
                v => !!v || 'Поле не должно быть пустым'
            ],
            placeholder: ''
        }),

        computed:{
            ...profileStore.mapState({
                profile: (state) => state,
            }),

            ...fieldsStore.mapState({
                filedInfo: (state) => state.currentField,
            })
        },

        async asyncData ({ route, store }) {
            const fieldID = route.query?.id;

            if (fieldID) {
                await store.dispatch('fields/getCustomsFieldInfo', fieldID)
                    .catch((e) => console.log('fields/getCustomsFieldInfo error' + e));
            }
        },

        methods: {
            async setCustomFieldValue (fieldValue) {
                this.loading = true;
                const fieldID = this.$route.query?.id;

                const data = {
                    profile_id: this.profile.id,
                    field_id: fieldID,
                    value: fieldValue,
                };

                await this.$store.dispatch('fields/addCustomFieldToProfile', data)
                    .then(() => this.$router.push('/profile/page'))
                    .catch((e) => console.log('fields/addCustomFieldToProfile error ' + e))
                    .finally( () => (this.loading = false));
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
                        src="../../../assets/images/customIcon.svg"
                        alt=""
                >
            </div>
            <p class="my-auto ml-8 font-croc" style="font-size: 17px;line-height: 24px;padding: 0">
                Введите информацию<br>
                о &#171;{{ filedInfo.title }}&#187; ниже
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
                    type="text"
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
                    @click="setCustomFieldValue(fieldValue)"
            >
                Сохранить
            </v-btn>
        </v-form>
    </v-container>
</template>

<style scoped>

</style>
