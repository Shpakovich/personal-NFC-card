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
                // commit('SET_PROFILE_INFO', res.data);
            }
        )
    },
    async getAllProfilesInfo ({ commit }) {
        await this.$api.profile.getProfiles().then((res)=> {
                commit('SET_PROFILE_INFO', res.data.items[0]);
            }
        ).catch((err)=> console.log(err))
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
    async getFieldInProfile ({ commit }, fieldID) {
        await this.$api.profile.getProfileField(fieldID).then((res)=> {
                commit('SET_FIELD_TO_EDIT', res.data);
            }
        )
    },
    async getFieldsInProfile ({ commit }, profileID) {
        await this.$api.profile.getProfileFields(profileID).then((res)=> {
                commit('show/SET_SHOW_PROFILE_FIELDS', res.data, {root: true})
            }
        )
    },
    async getFieldsInProfileByType ({ commit }, data) {
        await this.$api.profile.getProfileFieldsByType(data).then((res)=> {
                commit('SET_PROFILE_FIELDS', res.data)
            }
        )
    },
    async editFieldInProfile ({ commit }, fieldInfo) {
        await this.$api.profile.editProfileField(fieldInfo).then((res)=> {
                //commit('SET_FIELD_TO_EDIT', res.data);
            }
        )
    },
    async editSortFieldInProfile ({ commit }, sortedField) {
        await this.$api.profile.editSortProfileField(sortedField).then((res)=> {
                //commit('SET_FIELD_TO_EDIT', res.data);
            }
        )
    },
    async startOverlayAction ({ commit, rootState, dispatch  }, path) {
        if (path.includes('favorite')) {
            const id = {
                "id": rootState.profile.overlay.params.id // TODO вроде был id, но сейчас так
            };
            await dispatch('user/deleteUserFromFavorites', id, { root: true })
                .then(() => commit('profile/SET_OVERLAY_STATUS', false, { root: true }))
                .catch((e) => console.log('profile/hideProfile error' + e));
        } else if (path.includes('page')) {
            const data = {
                "id": rootState.profile.overlay.params.id
            };

            await dispatch('profile/deleteFieldInProfile', data, { root: true })
                .then(() => {
                    commit('profile/SET_OVERLAY_STATUS', false, { root: true });
                    dispatch('profile/getProfileInfo', rootState.profile?.id, { root: true })
                        .catch((e) => console.log('profile/getProfileInfo error' + e));
                })
                .catch((e) => console.log('profile/deleteFieldInProfile error: ' + e));
        }
    }
};
