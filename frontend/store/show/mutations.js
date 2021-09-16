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
    },
    SET_SHOW_PROFILE_FIELDS_TYPES (state, fieldTypes) {
        const typeAllFields = {
            id: '1',
            name: 'Все',
            sort: '1'
        };
        state.fieldTypes = fieldTypes.items;
        if (state.fieldTypes) {
            state.fieldTypes.unshift(typeAllFields);
        }
    },
    SET_SHOW_PROFILE_TYPE_ID (state, typesID) {
        state.typesID = typesID;
    },
    SET_SHOW_PROFILE_TYPE_NAME (state, typesName) {
        state.typesName = typesName;
    }
}
