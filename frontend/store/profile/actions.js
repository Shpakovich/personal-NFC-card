export default {
    async createNewProfile ({ commit }, data) {
        await this.$api.profile.createProfile(data).then((res)=> {
                commit('SET_PROFILE_INFO', res.data);
            }
        )
    },
    async editProfileInfo ({ commit }, data) {
        await this.$api.profile.editProfile(data).then((res)=> {
                commit('SET_PROFILE_INFO', res.data);
            }
        )
    },
    async getAllProfilesInfo ({ commit }) {
        await this.$api.profile.getProfiles().then((res)=> {
                commit('SET_PROFILE_INFO', res.data.items[0]);
                return res.data.items[0]
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
