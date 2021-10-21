export default {
    async getFavoritesUsers ({commit}) {
        await this.$api.user.getFavorites().then((res) => {
            commit('SET_FAVORITES_USERS', res.data);
            return res;
        })
            .catch((error) => {
                console.log('getFavoritesUsers error ' + error)
            })
    },

    async addUserToFavorites ({commit, dispatch}, id) {
        await this.$api.user.addFavorite(id).then(() => {
            commit('SET_USER_IN_FAVORITES_STATUS', true);
            dispatch('getFavoritesUsers');
        })
            .catch((error) => {
                console.log('addUserToFavorites error ' + error)
            })
    },
    async deleteUserFromFavorites ({commit, dispatch}, id) {
        await this.$api.user.deleteFavorite(id).then(() => {
            commit('SET_USER_IN_FAVORITES_STATUS', false);
            dispatch('getFavoritesUsers');
        })
            .catch((error) => {
                console.log('addUserToFavorites error ' + error)
            })
    }
}
