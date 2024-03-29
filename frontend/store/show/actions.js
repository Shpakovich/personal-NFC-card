export default {
    async getShowProfile({commit}, id) {
        await this.$api.show.getShowProfile(id).then((res) => {
                commit('SET_SHOW_PROFILE_INFO', res.data);
                return res;
            })
    },
    async getFieldTypes({commit}) {
        await this.$api.fields.getFieldsType().then((res) => {
                commit('SET_SHOW_PROFILE_FIELDS_TYPES', res.data);
            }
        )
    },
    async getFieldTypesToShow({commit}, showInfo) {
        await this.$api.show.getFieldsToTypeShow(showInfo).then((res) => {
                commit('SET_SHOW_PROFILE_FIELDS', res.data);
            }
        )
    }
}
