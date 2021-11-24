<script>
    export default {
        name: "fieldForShow",

        props: [
            "fieldInfo"
        ],

        computed: {
            fieldLink() {
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
            getIconSrc (fieldInfo) {
                return fieldInfo?.icon?.path;
            },
            async removeField() {
                const data = {
                    id: this.fieldInfo?.id
                };
                await this.$store.dispatch('profile/deleteFieldInProfile', data)
                    .then(() => {
                        this.$emit('updateFields');
                    })
                    .catch((e) => console.log('profile/deleteFieldInProfile error: ' + e));
            }
        }
    }
</script>

<template>
    <a
            style="max-width: 100%"
            :href="fieldLink"
        target="_blank"
    >
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
            <div style="max-width: 70%;" class="flex flex-col flex-grow my-auto ml-4">
                <v-card-subtitle class="font-gilroy" style="color: #415EB6;font-size: 15px;line-height: 18px; padding: 0">
                    {{ fieldInfo.title }}
                </v-card-subtitle>
                <v-card-subtitle class="font-gilroy" style="color: #415EB6;font-size: 12px;line-height: 140.1%; padding: 0">
                    {{ fieldInfo.value }}
                </v-card-subtitle>
            </div>
        </v-card>
    </a>
</template>

<style scoped>

</style>
