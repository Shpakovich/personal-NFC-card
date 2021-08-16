export default {
    async createNewProfile ({ commit }, data) {
        await this.$api.profile.createProfile(data).then((res)=> {
                commit('SET_PROFILE_INFO', res.data);
            }
        )
    },
    async editProfile ({ commit }, data) {
        await this.$api.profile.createProfile(data).then((res)=> {
                commit('SET_PROFILE_INFO', res.data);
            }
        )
    },
    async getAllProfilesInfo ({ commit, dispatch }, id) {
        await this.$api.profile.getProfiles().then((res)=> {
                commit('SET_PROFILE_INFO', res.data.items[0]);
                dispatch('card/setCardInfo', res.data.items[0].card);
            }
        )
    }
    /* async getProfileInfo ({ commit }, id) {
        await this.$api.profile.getProfile(id).then((res)=> {
                console.log(res);
                commit('SET_PROFILE_INFO', res.data);
            }
        )
    } */
};
