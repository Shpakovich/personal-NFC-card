
export default axios => ({
    createProfile (data) {
        return axios.post('/profile/create', data);
    },
    editProfile (data) {
        return axios.post('/profile/edit', data);
    }
});
