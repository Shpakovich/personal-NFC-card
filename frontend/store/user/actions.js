export default {
    async getFavoritesUsers ({commit}) {
        await this.$api.user.getFavorites().then((res) => {
            commit('SET_FAVORITES_USERS', res.data);
            return res;
        })
            .catch((error) => {
                if (error.response && error.response.status === 404) {
                    this.$router.push('/notFoundCard');
                }
            })
    }
}
