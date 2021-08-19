export default {
    SET_PROFILE_INFO (state, profile) {
        state.id = profile?.id;
        state.user = profile?.user;
        state.card = profile?.card;
        state.title = profile?.title;
        state.name = profile?.name;
        state.nickname = profile?.nickname;
        state.photo.path = profile?.photo?.path;
        state.default_name = profile?.default_name;
        state.post = profile?.post;
        state.description = profile?.description;
        state.is_published = profile?.is_published;
        state.created_at = profile?.card_id;
    }
};
