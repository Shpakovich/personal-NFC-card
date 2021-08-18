export default {
    async getAllFieldsInfo({commit}) {
        await this.$api.fields.getAllFields().then((res) => {
                commit('SET_ALL_FIELD_INFO', res.data);
            }
        )
    }
}
