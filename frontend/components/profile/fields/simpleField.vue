<script>
    export default {
        name: "simpleField",

        props: [
            "field",
            "isCustomFields"
        ],

        methods: {
            routeAddTag() {
                if (this.isCustomFields) {
                    this.$router.push(`/profile/fields/addCustomField?id=${this.field.id}`);
                } else {
                    this.$router.push(`/profile/fields/addField?id=${this.field.id}`);
                }
            },
            getIconSrc (fieldInfo) {
                    return fieldInfo?.icon?.path;
            },

            async deleteCustomFiled () {
                const data = {
                    "id": this.field.id
                };

                await this.$store.dispatch('fields/deleteCustomField', data)
                    .then(() => { this.$emit('updateFields') })
                    .catch((err) => {
                        let userMessageTitle = 'Ошибка сервера';
                        let userMessageText = 'Попробуйте позже';

                        if (err.response && err.response.status === 500) {
                            const errorDetail = err?.response?.data?.detail;

                            if ( errorDetail && errorDetail.includes('while executing') ) {
                                userMessageTitle = 'Данная категория используется';
                                userMessageText = 'Удалите все карточки этой группы';
                            }
                        }

                        this.showAlert('error', userMessageTitle, userMessageText);
                    });
            },

            showAlert (type, title, text) {
                this.$notify({
                    type: type,
                    title: title,
                    text: text
                })
            }
        }
    }
</script>

<template>
    <div>
        <v-card
                v-if="field && !isCustomFields"
                outlined
                class="mx-auto flex flex-row rounded-lg pt-5 pb-6 px-5"
                style="display: flex!important; border-radius: 20px!important;"
                height="80"
                width="100%"
                color="#EEF7FE"
                @click="routeAddTag()"
        >
                <div class="flex justify-center" style=" width: 36px; max-width: 36px; height: 36px;">
                    <img
                            class="m-auto flex-none"
                            style="max-height: 24px; max-width: 24px"
                            :src="getIconSrc(field)"
                            alt=""
                    >
                </div>
                <v-card-subtitle class="my-auto ml-4 font-gilroy" style="color: #415EB6;font-size: 15px;line-height: 18px; padding: 0">
                    {{ field.title }}
                </v-card-subtitle>
        </v-card>
        <v-card
                v-if="field && isCustomFields"
                outlined
                class="mx-auto flex flex-row rounded-lg pt-5 pb-6 px-5"
                style="display: flex!important; border-radius: 20px!important;"
                height="80"
                width="100%"
                color="#EEF7FE"
        >
            <div
                    class="flex justify-center"
                    style=" width: 36px; max-width: 36px; height: 36px;"
                    @click="routeAddTag()"
            >
                <img
                        class="m-auto flex-none"
                        style="max-height: 24px; max-width: 24px"
                        src="../../../assets/images/customIcon.svg"
                        alt=""
                >
            </div>
            <v-card-subtitle @click="routeAddTag()" class="my-auto ml-4 font-gilroy" style="color: #415EB6;font-size: 15px;line-height: 18px; padding: 0">
                {{ field.title }}
            </v-card-subtitle>
            <v-btn
                    v-if="isCustomFields"
                    icon
                    class="font-bold ml-auto"
                    max-width="36px"
                    min-width="36px"
                    height="36"
                    @click="deleteCustomFiled()"
            >
                <img
                        class="m-auto flex-none"
                        style="max-height: 36px; max-width: 36px"
                        src="../../../assets/images/icon/Delete.svg"
                        alt=""
                >
            </v-btn>
        </v-card>
    </div>
</template>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
