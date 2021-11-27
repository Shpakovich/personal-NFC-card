export default axios => ({
    getAllFields() {
        return axios.get('/fields');
    },
    createCustomField(data) {
        return axios.post('/field/custom/create', data);
    },
    getAllCustomsFields() {
        return axios.get('/field/customs');
    },
    getAllCustomsFieldsToProfile(id) {
        return axios.get(`/profile/${id}/fields/custom`);
    },
    getField(id) {
        return axios.get(`/field/${id}`);
    },
    addCustomField (data) {
        return axios.post('/profile/field/custom/add', data);
    },
    getCustomField(id) {
        return axios.get(`/field/custom/${id}`);
    },
    editCustomField(data) {
        return axios.post('/field/custom/edit', data);
    },
    getFieldsType() {
        return axios.get(`/field/types`);
    }
});
