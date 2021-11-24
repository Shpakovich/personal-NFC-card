<script>
    import { createNamespacedHelpers } from 'vuex';
    const profileStore = createNamespacedHelpers( 'profile');

    export default {
        name: "createCustomField",
        layout: "addFields",

        data: () => ({
            customField: {
                id: 'custom',
                title: 'Личная карточка'
            },
            customFieldTitle: '',
            customFieldValue: '',
            type: 'text',
            loading: false,
            valid: false,
            valueRules: [
                v => !!v || 'Поле не должно быть пустым'
            ],
        }),

        computed: {
            ...profileStore.mapState({
                profile: (state) => state,
            })
        },

        methods: {
            async createCustomField(fieldTitle) {
                const data = {
                    "title": fieldTitle,
                    "bg_color": "#fff",
                    "text_color": "#000"
                };

                await this.$store.dispatch('fields/createCustomField', data)
                    // then прокидываем на заполнение значения карточки
                .catch((err)=> { console.log('error ields/createCustomField ' + err) })
            }
        }
    }
</script>

<template>
    <v-container class="py-11 px-11">
        <h3 style="font-size: 24px; line-height: 35px;" class="text-center font-bold font-croc mb-2">{{ customField.title }}</h3>
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
                Введите назание<br>
                вашей карточки ниже
            </p>
        </v-row>
        <v-form
                ref="form"
                class="flex flex-col mt-14"
                v-model="valid"
                @submit.prevent="createCustomField(customFieldTitle)"
        >
            <v-text-field
                    v-model="customFieldTitle"
                    class="font-croc"
                    :label="customField.title"
                    :rules="valueRules"
                    :type="type"
                    :id="customField.title"
                    required
                    outlined
            ></v-text-field>

            <v-btn
                    :disabled="!valid"
                    :loading="loading"
                    color="secondary"
                    class="rounded-lg flex-initial m-auto w-8/12"
                    max-width="225px"
                    min-width="150px"
                    height="48"
                    @click="createCustomField(customFieldTitle)"
            >
                Создать
            </v-btn>
        </v-form>
    </v-container>
</template>

<style scoped>

</style>
