const actions = {
    async nuxtServerInit ({ dispatch }, { route, redirect }) {
        const isProfileRoute = route.path.indexOf('profile') !== -1;
        if (this.$auth.loggedIn) {
            await Promise.all([
                dispatch('profile/getAllProfilesInfo'),
                // TODO получать инфу по юзеру /user/cards
            ]);
        } else if (!this.$auth.loggedIn && isProfileRoute) {
            redirect('/authorization');
        }
    }
};

export default actions;
