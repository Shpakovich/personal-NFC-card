export default {
    async getShowProfile({commit}, id) {
        await this.$api.show.getShowProfile(id).then((res) => {
                commit('SET_SHOW_PROFILE_INFO', res.data);
            }
        )
    }
}
