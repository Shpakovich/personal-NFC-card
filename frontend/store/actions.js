const actions = {
    async nuxtServerInit ({ dispatch }) {
        await Promise.all([
            // dispatch('profile/getAllProfilesInfo'),
            // TODO получать инфу по юзеру /user/cards
        ]);
    }
};

export default actions;
