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
    },

    SET_PROFILE_FIELDS (state, fields) {
        state.fields = fields;
    },
    SET_FIELD_TO_EDIT (state, field) {
        state.fieldToEdit = field;
    },
    SET_OVERLAY_STATUS (state, status) {
        state.overlay.status = status;
    },
    SET_OVERLAY_TEXT (state, text) {
        state.overlay.text = text;
    },
    SET_OVERLAY_PARAMS (state, params) {
        state.overlay.params = params;
    },
    SET_OVERLAY_NEW_STATUS (state, status) {
        state.overlayNew.status = status;
    },
    SET_OVERLAY_NEW_SHOULD (state, should) {
        state.overlayNew.should = should;
    },
};
