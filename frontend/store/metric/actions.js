export default {
    async getMetricValue({commit}, data) {
        await this.$api.metric.getMetric(data).then((res) => {
                commit('SET_METRIC_VALUE', res.data);
            }
        )
    },
    async setMetricPeriod({commit}, data) {
        commit('SET_METRIC_PERIOD', data);
    }
}
