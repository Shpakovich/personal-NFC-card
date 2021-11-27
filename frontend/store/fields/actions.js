export default {
    async getAllFieldsInfo({commit}) {
        await this.$api.fields.getAllFields().then((res) => {
                commit('SET_ALL_FIELD_INFO', res.data);
            }
        )
    },
    async createCustomField ({commit, dispatch}, data) {
        await this.$api.fields.createCustomField(data).then((res) => {
                dispatch('fields/getAllCustomsFieldsInfo', null, { root: true });
                this.$router.push(`/profile/fields/addValueCustomField?id=${res?.data.id}`);
            })
    },
    async getAllCustomsFieldsInfo({commit}) {
        await this.$api.fields.getAllCustomsFields().then((res) => {
                commit('SET_ALL_CUSTOMS_FIELD_INFO', res.data);
            }
        )
    },
    async getAllCustomsFieldsToProfile ({commit}, idProfile) {
        await this.$api.fields.getAllCustomsFieldsToProfile(idProfile).then((res) => {
                console.log(res.data)
                commit('profile/SET_PROFILE_CUSTOMS_FIELDS', res.data, { root: true });
            }
        )
    },
    async editCustomFieldInfo ({commit}, data) {
        await this.$api.fields.editCustomField(data).then((res) => {
                this.$router.push(`/profile/page`);
                return res;
            }
        )
    },
    async addCustomFieldToProfile ({commit}, data) {
        await this.$api.fields.addCustomField(data).then((res) => {
                console.log(res);
                this.$router.push(`/profile/page`);
                return res;
            }
        )
    },
    async getLastCustomFieldInfo({commit}) {
        await this.$api.fields.getAllCustomsFields().then((res) => {
                console.log(res.data.items);
                commit('SET_LAST_CUSTOMS_FIELD_INFO', res.data.items[res.data.items.length-1]);
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
