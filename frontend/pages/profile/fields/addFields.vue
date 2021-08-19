<script>
    import { createNamespacedHelpers } from 'vuex';
    const { mapState } = createNamespacedHelpers(['profile', 'fields']);

    import simpleField from '../../../components/profile/fields/simpleField'

    export default {
        name: "addFields",
        layout: "addFields",

        components: {
            simpleField
        },

        async mounted() {
            await this.$store.dispatch('fields/getAllFieldsInfo')
                .then(() => {})
                .catch((e) => console.log('fields/getAllFieldsInfo error' + e));
        },

        computed:{
            ...mapState({
                profile: (state) => state,
                fields: (state) => state
            })
        }
    }
</script>

<template>
    <v-container class="py-11 px-11">
        <h3 style="font-size: 24px; line-height: 35px;" class="text-center font-bold font-croc">Общее</h3>
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
        <v-row class="flex flex-column justify-center">
            <simpleField
                    v-for="(field, index) in fields.fields"
                    class="mb-6"
                    :key="index"
                    :filed="field"
            />
        </v-row>
    </v-container>
</template>

<style scoped>

</style>
