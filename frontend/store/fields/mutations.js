export default {
    SET_ALL_FIELD_INFO (state,  fields) {
        state.fields = fields.items;
    },
    SET_CURRENT_FIELD_INFO (state,  field) {
        state.currentField = field;
    },
    SET_FIELDS_TYPES (state,  types) {
        state.fieldTypes = types;
    },
    SET_ID_TYPES (state, id) {
        state.typesID = id;
    },
    SET_NAME_TYPES (state, name) {
        state.typesName = name;
    }
};
