export default {
    SET_SHOW_PROFILE_INFO (state, data) {
        state.profile = data?.profile;
        state.card = data?.card;
    },
    SET_SHOW_PROFILE_FIELDS (state, fields) {
        state.fields = fields;
    },
    SET_SHOW_PROFILE_SORT_FIELDS (state, sortFields) {
        state.sortFields = sortFields;
    }
}
