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

        data: () => ({
            imageCount: 0
        }),

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
            },
            isLoading() {
                return this.metric?.loading;
            },
            getImageSrc() {
                switch (this.imageCount) {
                    case 0: {
                        return require('../../assets/images/watches/day.svg' + '');
                    }
                    case 1: {
                        return require('../../assets/images/watches/week.svg' + '');
                    }
                    case 2: {
                        return require('../../assets/images/watches/month.svg' + '');
                    }
                    case 3: {
                        return require('../../assets/images/watches/all.svg' + '');
                    }
                }
            }
        },

        async asyncData ({ store }) {
            let dayMilliseconds = 24*60*60*1000;
            const currentDate = new Date();
            const isoDateString = currentDate.toISOString();
            const from = new Date(currentDate - dayMilliseconds).toISOString();
            await store.dispatch('metric/setMetricPeriod', 'day')

            const data = {
                profile_id: store.state.profile?.id,
                from: from,
                to: isoDateString
            };
            await store.dispatch('metric/getMetricValue', data)
                .catch((e) => console.log('metric/getMetricValue error ' + e));
        },

        created() {
            this.getRandomImg();
        },

        methods: {
            getRandomImg () {
                this.imageCount = Math.floor(Math.random() * 4);
            }
        }
    }
</script>

<template>
    <v-container class="pb-11 pt-4 px-11 watch-container" style="height: 100%; max-height: 100%; overflow: scroll;">
        <settingsHeader />
        <div class="flex flex-col mt-14">
            <p class="font-croc text-center" style="font-size: 20px; line-height: 29.48px; z-index: 1;">
                Просмотры профиля
            </p>
            <p
                    v-if="!isLoading"
                    class="font-bold text-center"
                    style="z-index: 1;"
                    :class="getMetricValue ? 'font-gilroy text-value mt-2' : 'font-croc text-empty mt-4'"
            >
                {{ getMetricText }}
            </p>
            <v-progress-circular
                    v-else
                    class="m-auto text-center my-4"
                    indeterminate
                    color="primary"
            ></v-progress-circular>
        </div>
        <img
                :src="getImageSrc"
                class="watch-image mt-2"
                style="z-index: 0; margin: auto;"
                alt=""
        />
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

    .watch-container {
        @media (min-width: 640px) { // todo вынести в переменную
            max-width: 447px!important;
            margin: auto !important;
        }
    }

    .watch-image {
        display: none;

        @media (min-height: 660px) and (max-height: 760px){
            display: block;
            max-width: 105px;
            bottom: 10%;
        }
        @media (min-height: 760px) {
            display: block;
            max-width: 200px;
        }
    }
</style>
