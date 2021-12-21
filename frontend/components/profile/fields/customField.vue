<script>
    export default {
        name: "customField",

        props: [
            "customFieldInfo"
        ],

        methods: {
            async removeField() {
                const data = {
                    id: this.customFieldInfo?.id
                };
                await this.$store.dispatch('profile/deleteCustomFieldInProfile', data)
                    .then(() => { this.$emit('updateFields'); })
                    .catch((e) => console.log('profile/deleteCustomFieldInProfile error: ' + e));
            }
        }
    }
</script>

<template>
    <v-card
            v-if="customFieldInfo"
            outlined
            class="mx-auto flex flex-row rounded-lg pt-5 pb-6 px-5"
            style="display: flex!important; border-radius: 20px!important; height: auto;"
            width="100%"
            color="#EEF7FE"
    >
        <a :href="customFieldInfo.value" target="_blank" class="flex justify-center" style="width: 36px; max-width: 36px; height: 36px;">
            <img
                    class="m-auto flex-none"
                    style="max-height: 24px; max-width: 24px"
                    src="../../../assets/images/customIcon.svg"
                    alt=""
            >
        </a>
        <a :href="customFieldInfo.value" target="_blank" style="max-width: 70%;" class="flex flex-col flex-grow my-auto ml-4">
            <v-card-subtitle class="font-gilroy" style="color: #415EB6;font-size: 15px;line-height: 18px; padding: 0">
                {{ customFieldInfo.title }}
            </v-card-subtitle>
            <v-card-subtitle class="font-gilroy" style="color: #415EB6;font-size: 12px;line-height: 140.1%; padding: 0">
                {{ customFieldInfo.value }}
            </v-card-subtitle>
        </a>
        <v-btn
                icon
                class="font-bold ml-auto"
                max-width="36px"
                min-width="36px"
                height="36"
                @click="removeField()"
        >
            <img
                    class="m-auto flex-none"
                    style="max-height: 36px; max-width: 36px"
                    src="../../../assets/images/icon/Delete.svg"
                    alt=""
            >
        </v-btn>
    </v-card>
</template>

<style scoped>

</style>
