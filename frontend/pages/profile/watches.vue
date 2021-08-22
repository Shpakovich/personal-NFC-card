<script>
    import settingsHeader from '../../components/settingsHeader';
    import { createNamespacedHelpers } from 'vuex';
    const profileStore = createNamespacedHelpers('profile');
    const metricStore = createNamespacedHelpers('metric');

    export default {
        name: "watches",
        layout: "profile",

        components: {
            settingsHeader
        },

        computed: {
            ...profileStore.mapState({
                profile: (state) => state
            }),
            ...metricStore.mapState({
                metric: (state) => state,
            }),

            getMetricValue() {
                return this.metric?.value?.value;
            },

            getMetricText() {
                return this.getMetricValue ? this.metric.value.value : 'У вас пока нет просмотров';
            }
        },

        async asyncData ({ store }) {
            let dayMilliseconds = 24*60*60*1000;
            const currentDate = new Date();
            const isoDateString = currentDate.toISOString();
            const from = new Date(currentDate - dayMilliseconds).toISOString();

            const data = {
                profile_id: store.state.profile?.id,
                from: from,
                to: isoDateString
            };
            await store.dispatch('metric/getMetricValue', data)
                .catch((e) => console.log('metric/getMetricValue error ' + e));
        }

    }
</script>

<template>
    <v-container class="pb-11 pt-4 px-11">
        <settingsHeader />
        <div class="flex flex-col mt-14">
            <p class="font-croc text-center" style="font-size: 20px; line-height:  29.48px">
                Просмотры профиля
            </p>
            <p
                    class="font-bold text-center"
                    :class="getMetricValue ? 'font-gilroy text-value mt-2' : 'font-croc text-empty mt-4'"
            >
                {{ getMetricText }}
            </p>
        </div>
    </v-container>
</template>

<style lang="scss">
    .text-value {
        font-size: 50px!important;
        line-height: 73.7px!important;
    }
    .text-empty {
        font-size: 18px!important;
        line-height: 21px!important;
    }
</style>
