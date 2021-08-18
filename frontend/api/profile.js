
export default axios => ({
    createProfile (data) {
        return axios.post('/profile/create', data);
    },
    editProfile (data) {
        return axios.post('/profile/edit', data);
    },
    getProfiles () {
        return axios.get('/profiles');
    },
    getProfile (id) {
        return axios.get(`/profile/${id}`);
    },
    publishProfile (id) {
        return axios.post('/profile/publish', id);
    },
    hideProfile (id) {
        return axios.post('/profile/hide', id);
    }
});
