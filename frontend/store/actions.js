const actions = {
    async nuxtServerInit ({ dispatch }) {
        if (this.$auth.loggedIn) {
            await Promise.all([
                dispatch('profile/getAllProfilesInfo'),
                // TODO получать инфу по юзеру /user/cards
            ]);
        }
    }
};

export default actions;
