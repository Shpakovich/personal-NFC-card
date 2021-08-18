export default axios => ({
    getAllFields() {
        return axios.get('/fields');
    }
});
