export default axios => ({
    getAllFields() {
        return axios.get('/fields');
    },
    getField(id) {
        return axios.get(`/field/${id}`);
    }
});
