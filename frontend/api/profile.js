
export default axios => ({
    createProfile (data) {
        return axios.post('/profile/create', data);
    }
});
