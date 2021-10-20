export default axios => ({
    getFavorites () {
        return axios.get('/user/favorites');
    },
    addFavorite (id) {
        return axios.post('/user/favorite/add', id);
    },
    deleteFavorite (id) {
        return axios.get('/user/favorite/delete', id);
    }
})
