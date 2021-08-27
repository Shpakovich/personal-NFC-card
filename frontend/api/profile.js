
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
    },
    addFieldInProfile (data) {
        return axios.post('/profile/field/add', data);
    },
    addPhotoInProfile (data) {
        return axios.post('/profile/photo/add', data);
    },
    deleteProfileField (data) {
        return axios.post('/profile/field/delete', data);
    },
    editProfileField (data) {
        return axios.post('/profile/field/edit', data);
    },
    editSortProfileField (data) {
        return axios.post('/profile/field/sort', data);
    },
    getProfileField(id) {
        return axios.get(`/profile/field/${id}`);
    },
    getProfileFields(id) {
        return axios.get(`/profile/${id}/fields`);
    }
});
