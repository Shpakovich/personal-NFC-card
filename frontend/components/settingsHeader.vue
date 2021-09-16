<script>
    import { createNamespacedHelpers } from 'vuex';
    const metricStore = createNamespacedHelpers('metric');
    const profileStore = createNamespacedHelpers('profile');

    export default {
        name: "settingsHeader",

        data: () => ({
            links: [{
                name: 'День',
                title: 'day'
            }, {
                name: 'Неделя',
                title: 'week'
            }, {
                name: 'Месяц',
                title: 'month'
            }, {
                name: 'Все',
                title: 'all'
            }],
        }),

        computed: {
            ...metricStore.mapState({
                metric: (state) => state,
            }),
            ...profileStore.mapState({
                profile: (state) => state,
            })
        },

        methods: {
            isActiveButton (period) {
                return this.metric.period === period;
            },
            async changePeriodOfMetric(period) {
                this.$store.commit('metric/SET_LOADING_STATUS', true);
                await this.$store.dispatch('metric/setMetricPeriod', period)
                    .catch((e) => console.log('metric/setMetricPeriod error ' + e));

                let data;
                const currentDate = new Date();
                const isoDateString = currentDate.toISOString();
                let dayMilliseconds = 24*60*60*1000;
                let weekMilliseconds = 7*dayMilliseconds;
                let monthMilliseconds = 31*dayMilliseconds;

                if (period === 'day'){
                    const from = new Date(currentDate - dayMilliseconds).toISOString();
                    data = {
                        profile_id: this.profile?.id,
                        from: from,
                        to: isoDateString
                    }
                } else if(period === 'week') {
                    const from = new Date(currentDate - weekMilliseconds).toISOString();
                    data = {
                        profile_id: this.profile?.id,
                        from: from,
                        to: isoDateString
                    }
                } else if(period === 'month') {
                    const from = new Date(currentDate - monthMilliseconds).toISOString();
                    data = {
                        profile_id: this.profile?.id,
                        from: from,
                        to: isoDateString
                    }
                } else if (period === 'all'){
                    data = {
                        profile_id: this.profile?.id
                    }
                }

                await this.$store.dispatch('metric/getMetricValue', data)
                    .catch((e) => console.log('metric/getMetricValue error ' + e));

                this.$store.commit('metric/SET_LOADING_STATUS', false);
            }
        }
    }
</script>

<template>
    <v-row
            justify="center"
            no-gutters
    >
        <v-btn
                v-for="(link, index) in links"
                :key="index"
                height="32"
                min-height="32"
                max-width="256"
                class="m-auto font-gilroy w-1/4 pb-2"
                :class="isActiveButton(link.title) ? 'active_period' : 'period'"
                style="font-size: 13px!important; line-height: 15.3px!important; border-radius: 0 !important;"
                @click="changePeriodOfMetric(link.title)"
                text
        >
            <div class="flex flex-col">
                <p
                        style="padding: 0; margin: 0"
                        :class="{'item_active': true}"
                >
                    {{ link.name }}
                </p>
            </div>
        </v-btn>
    </v-row>
</template>

<style lang="scss">
    .active_period {
        border-bottom: 2px solid #FFA436;
        color: #FFA436 !important;
    }

    .period {
        border-bottom: 2px solid rgba(104, 103, 108, 0.3);
    }

</style>
