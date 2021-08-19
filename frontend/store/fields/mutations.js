export default {
    SET_ALL_FIELD_INFO (state,  fields) {
        state.fields = fields.items;
    },
    SET_CURRENT_FIEL_INFO (state,  field) {
        state.currentField = field;
    }
};
