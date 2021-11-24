export default {
    async getAllFieldsInfo({commit}) {
        await this.$api.fields.getAllFields().then((res) => {
                commit('SET_ALL_FIELD_INFO', res.data);
            }
        )
    },
    async createCustomField ({commit, dispatch}, data) {
        await this.$api.fields.createCustomField(data).then((res) => {
                dispatch('fields/getAllCustomsFieldsInfo', null, { root: true })
            }
        )
    },
    async getAllCustomsFieldsInfo({commit}) {
        await this.$api.fields.getAllCustomsFields().then((res) => {
                commit('SET_ALL_CUSTOMS_FIELD_INFO', res.data);
            }
        )
    },
    async getFieldInfo({commit}, id) {
        await this.$api.fields.getField(id).then((res) => {
                commit('SET_CURRENT_FIELD_INFO', res.data);
            }
        )
    },
    async getFieldTypes({commit}) {
        await this.$api.fields.getFieldsType().then((res) => {
                commit('SET_FIELDS_TYPES', res.data);
            }
        )
    }
}
