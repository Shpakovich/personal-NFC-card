<script>
    import { createNamespacedHelpers } from 'vuex';
    const { mapState } = createNamespacedHelpers('profile');

    export default {
        name: "watches",
        layout: "profile",

        computed: {
            ...mapState({
                profile: (state) => state
            })
        },

        async asyncData ({ store }) {
            const data = {
                profile_id: store.state.profile?.id,
                from: "2010-11-12T13:14:15Z", // TODO без филдов если за всё время, если время то дата в
                to: "2010-11-12T13:14:15Z"
            };
            await store.dispatch('metric/getMetricValue', data)
                .catch((e) => console.log('metric/getMetricValue error ' + e));
        }

    }
</script>

<template>
    <v-container class="py-11 px-11">
        <h2 class="font-croc text-center" style="font-size: 20px; line-height: 29.48px">
            Просмотры профиля
        </h2>
    </v-container>
</template>

<style scoped>

</style>
