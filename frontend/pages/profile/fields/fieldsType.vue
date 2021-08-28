<script>
    import { createNamespacedHelpers } from 'vuex';
    const fieldsType = createNamespacedHelpers('fields');


    export default {
        name: "fieldsType",
        layout: "addFields",

        data: () => ({
            selected: ''
        }),
        computed: {
            ...fieldsType.mapState({
                fieldTypes: (state) => state.fieldTypes,
            }),
            ...fieldsType.mapState({
                typeID: (state) => state.typesID,
            })
        },

        async asyncData ({ redirect, store }) {
            const fields = store.state.profile.fields;
            let sortable = [];


            for (let field in fields) {
                const types = fields[field].type;
                sortable.push(types);
            }

            const typeAllFields = {
                id: '1',
                name: 'Все',
                sort: '1'
            };

            sortable.push(typeAllFields);

            sortable.sort(function (a, b) {
                return a.sort - b.sort;
            });

            sortable = sortable.filter((type, index, self) =>
                index === self.findIndex((t) => (
                    t.id === type.id
                ))
            );

            store.commit('fields/SET_FIELDS_TYPES', sortable);

            const currentField = store.state.fields.currentField;

            if (currentField) {

            }
        },

        methods: {
            setTypesID(id) {
                this.$store.commit('fields/SET_ID_TYPES', id);
            }
        }
    }
</script>


<template>
    <v-container class="py-11 px-11">
        <h3 style="font-size: 24px; line-height: 35px;" class="text-center font-bold font-croc">Фильтр</h3>
        <v-btn
                icon
                class="rounded-lg flex-initial font-bold w-4/12 mb-3 ml-1.5 btn-back"
                max-width="110px"
                min-width="100px"
                height="48"
                color="secondary"
                to="/profile/page"
        >
            <img src="../../../assets/images/icon/icon-arrow-left.svg" alt="">
            Назад
        </v-btn>
        <v-row class="flex flex-column justify-center">
            <v-radio-group v-model="selected" >
                <v-radio
                        v-for="(fieldType, index) in fieldTypes"
                        :key="fieldType.id"
                        class="radio-btn font-croc mb-8"
                        style="font-size: 17px; line-height: 25.06px"
                        color="secondary"
                        :label="fieldType.name"
                        @change="setTypesID(fieldType.id)"
                >
                </v-radio>
            </v-radio-group>
        </v-row>
    </v-container>
</template>

<style lang="scss">
    .theme--light.v-icon {
        color: #FFA436!important;
    }
    .v-application--is-ltr .v-input--selection-controls__input {
        margin-right: 24px!important;
    }
</style>
