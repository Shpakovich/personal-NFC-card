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
        await this.$api.user.addFavorite(id).then((res) => {
            commit('SET_USER_IN_FAVORITES', res.data.id);
        })
            .catch((error) => {
                console.log('addUserToFavorites error ' + error)
            })
    },
    async deleteUserFromFavorites ({commit, dispatch }, id) {
        await this.$api.user.deleteFavorite(id)
            .then(() => {
                commit('RESET_USER_IN_FAVORITES');
                dispatch('getFavoritesUsers');
            }).catch((error) => {
                console.log('addUserToFavorites error ' + error)
            })
    }
}
