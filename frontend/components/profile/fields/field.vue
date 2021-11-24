<script>
    export default {
        name: "field",

        props: [
            "fieldInfo"
        ],

        computed: {
            getRedirectField() {
                if (this.fieldInfo.title === 'Email') {
                    return 'mailto:' + this.fieldInfo.value;
                } else if (this.fieldInfo.title === ('Номер телефона')) {
                    return 'tel:' + this.fieldInfo.value;
                } else if (this.fieldInfo.title === ('Whatsapp')) {
                    return 'https://api.whatsapp.com/send?phone=' + this.fieldInfo.value;
                } else if (this.fieldInfo.title === 'Viber') {
                    if( this.fieldInfo.value.includes('chats.viber') ) {
                        return this.fieldInfo.value;
                    } else {
                        const userPhone = this.fieldInfo.value.replace(/\D/g, '');
                        return 'https://skobelkin.ru/viber/' + userPhone;
                    }
                } else {
                    return this.fieldInfo.value;
                }
            }
        },

        methods: {
            getFieldLink() {
                this.$router.push(`/profile/fields/editField?id=${this.fieldInfo.id}`);
            },
            getIconSrc (fieldInfo) {
                return fieldInfo?.icon?.path;
            },
            async removeField() {
                this.$store.commit('profile/SET_OVERLAY_TEXT', 'Вы точно хотите ' +
                    'удалить этот TEG?');
                this.$store.commit('profile/SET_OVERLAY_STATUS', true);

                const id = {
                    "id": this.fieldInfo?.id
                };
                this.$store.commit('profile/SET_OVERLAY_PARAMS', id);

                /* const data = {
                    id: this.fieldInfo?.id
                };
                await this.$store.dispatch('profile/deleteFieldInProfile', data)
                    .then(() => { this.$emit('updateFields'); })
                    .catch((e) => console.log('profile/deleteFieldInProfile error: ' + e)); */
            }
        }
    }
</script>

<template>
    <v-card
            v-if="fieldInfo"
            outlined
            class="mx-auto flex flex-row rounded-lg pt-5 pb-6 px-5"
            style="display: flex!important; border-radius: 20px!important; height: auto;"
            width="100%"
            color="#EEF7FE"
    >
            <div class="flex justify-center" style=" width: 36px; max-width: 36px; height: 36px;">
                <img
                        class="m-auto flex-none"
                        style="max-height: 24px; max-width: 24px"
                        :src="getIconSrc(fieldInfo)"
                        alt=""
                >
            </div>
            <div @click="getFieldLink()" style="max-width: 70%;" class="flex flex-col flex-grow my-auto ml-4">
                <v-card-subtitle class="font-gilroy" style="color: #415EB6;font-size: 15px;line-height: 18px; padding: 0">
                    {{ fieldInfo.title }}
                </v-card-subtitle>
                <v-card-subtitle class="font-gilroy" style="color: #415EB6;font-size: 12px;line-height: 140.1%; padding: 0">
                    {{ fieldInfo.value }}
                </v-card-subtitle>
            </div>
            <v-menu>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        v-bind="attrs"
                        v-on="on"
                            icon
                            class="font-bold m-auto"
                            max-width="24px"
                            min-width="24px"
                            height="24"
                    >
                        <img
                                class="m-auto flex-none"
                                style="max-height: 24px; max-width: 24px"
                                src="../../../assets/images/icon/more_option.svg"
                                alt=""
                        >
                    </v-btn>
                </template>

                <v-list>
                    <v-list-item>
                        <a
                                class="flex flex-row"
                                :href="getRedirectField"
                                target="_blank"
                        >
                            <p style="color: #FFA436;" class="my-auto mx-0">Перейти</p>
                            <img src="../../../assets/images/icon/icon-arrow-right.svg" alt="">
                        </a>
                    </v-list-item>

                    <v-list-item @click="removeField()">
                        <v-list-item-title style="color: #FF645A">
                            Удалить TAG
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
        </v-menu>
    </v-card>
</template>

<style scoped>

</style>
