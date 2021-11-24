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
    getField(id) {
        return axios.get(`/field/${id}`);
    },
    getFieldsType() {
        return axios.get(`/field/types`);
    }
});
