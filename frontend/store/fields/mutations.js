export default {
    SET_ALL_FIELD_INFO (state, fields) {
        state.fields = fields.items;
    },
    SET_ALL_CUSTOMS_FIELD_INFO (state, customFields) {
        state.customFields = customFields.items;
    },
    SET_CURRENT_FIELD_INFO (state,  field) {
        state.currentField = field;
    },
    SET_FIELDS_TYPES (state, types) {
        const typeAllFields = {
            id: '1',
            name: 'Все',
            sort: '1'
        };
        state.fieldTypes = types.items;
        if (state.fieldTypes) {
            state.fieldTypes.unshift(typeAllFields);
        }
    },
    SET_ID_TYPES (state, id) {
        state.typesID = id;
    },
    SET_NAME_TYPES (state, name) {
        state.typesName = name;
    }
};
