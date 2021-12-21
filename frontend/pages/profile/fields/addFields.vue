<script>
    import { createNamespacedHelpers } from 'vuex';
    const { mapState } = createNamespacedHelpers(['profile', 'fields']);

    import simpleField from '../../../components/profile/fields/simpleField';
    import createField from '../../../components/profile/fields/createField';

    export default {
        name: "addFields",
        layout: "addFields",

        components: {
            simpleField,
            createField
        },

        async asyncData ({ store }) {
            await store.dispatch('fields/getAllFieldsInfo')
                .catch((e) => console.log('fields/getAllFieldsInfo error' + e));

            await store.dispatch('fields/getAllCustomsFieldsInfo')
                .catch((e) => console.log('fields/getAllCustomsFieldsInfo error' + e));
        },

        computed:{
            ...mapState({
                profile: (state) => state,
                fields: (state) => state,
            })
        }
    }
</script>

<template>
    <v-container class="py-11 px-11" style="height: 100%; max-height: 100%; overflow: scroll;">
        <h3 style="font-size: 24px; line-height: 35px;" class="text-center font-bold font-croc">Общее</h3>
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
        <v-row class="flex flex-column justify-center">
            <transition-group name="fade" tag="div">
                <simpleField
                        v-for="(field) in fields.fields"
                        class="mb-6"
                        :key="field.id"
                        :field="field"
                        :isCustomFields="false"
                />
                <simpleField
                        v-for="(customField) in fields.customFields"
                        class="mb-6"
                        :key="customField.id"
                        :field="customField"
                        :isCustomFields="true"
                />
            </transition-group>
            <createField class="mb-6" />
        </v-row>
    </v-container>
</template>

<style scoped>

</style>
