export default {
    async getShowProfile({commit}, id) {
        await this.$api.show.getShowProfile(id).then((res) => {
                commit('SET_SHOW_PROFILE_INFO', res.data);
                return res;
            })
            .catch((error)=> {
                /* if (error.response && error.response.status === 404) {
                    this.$router.push('/notFoundCard');
                } */
            })
    },
    async getFieldTypes({commit}) {
        await this.$api.fields.getFieldsType().then((res) => {
                commit('SET_SHOW_PROFILE_FIELDS_TYPES', res.data);
            }
        )
    }
}
