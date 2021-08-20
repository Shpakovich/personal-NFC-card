export default {
    async createNewProfile ({ commit }, data) {
        await this.$api.profile.createProfile(data).then((res)=> {
                commit('SET_PROFILE_INFO', res.data);
            }
        )
    },
    async editProfileInfo ({ commit }, data) {
        await this.$api.profile.editProfile(data).then((res)=> {
                this.$router.push('/profile/page');
                commit('SET_PROFILE_INFO', res.data);
            }
        )
    },
    async getAllProfilesInfo ({ commit }) {
        await this.$api.profile.getProfiles().then((res)=> {
                commit('SET_PROFILE_INFO', res.data.items[0]);
            }
        )
    },
    async publishProfile ({ commit }, data) {
        await this.$api.profile.publishProfile(data).then((res)=> {
                this.$router.push('/profile/page'); // TODO Добавить уведомлялку что мы опубликовали профиль
                return res?.data?.items[0]
            }
        )
    },
    async hideProfile ({ commit }, data) {
        await this.$api.profile.hideProfile(data).then((res)=> {
                this.$router.push('/profile/page'); // TODO Добавить уведомлялку что мы скрыли профиль
                return res?.data?.items[0]
            }
        )
    },

    async addFieldInProfile ({ commit }, data) {
        await this.$api.profile.addFieldInProfile(data).then((res)=> {
                this.$router.push('/profile/page');
            }
        )
    },

    async addPhotoProfile ({ commit }, data) {
        await this.$api.profile.addPhotoInProfile(data).then((res)=> {
                this.$router.push('/profile/page');
                return res?.data?.items[0]
            }
        )
    },
    async getProfilesFields ({ commit }, cardID) {
        await this.$api.show.getShowProfile(cardID).then((res)=> {
                return res?.data?.items[0]
            }
        )
    },
    async getProfileInfo ({ commit }, id) {
        await this.$api.profile.getProfile(id).then((res)=> {
                commit('SET_PROFILE_FIELDS', res.data?.fields);
            }
        )
    },
    async deleteFieldInProfile ({ commit }, fieldInfo) {
        await this.$api.profile.deleteProfileField(fieldInfo).then((res)=> {
                // commit('SET_PROFILE_FIELDS', res.data?.fields);
            }
        )
    },
    async editFieldInProfile ({ commit }, fieldInfo) {
        await this.$api.profile.editProfileField(fieldInfo).then((res)=> {
                // commit('SET_PROFILE_FIELDS', res.data?.fields);
            }
        )
    }
};
