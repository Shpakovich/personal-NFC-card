const actions = {
    async nuxtServerInit ({ dispatch }, { redirect }) {
        if (this.$auth.loggedIn) {
            await Promise.all([
                dispatch('profile/getAllProfilesInfo'),
                // TODO получать инфу по юзеру /user/cards
            ]);
        } else {
            redirect('/authorization');
        }
    }
};

export default actions;
