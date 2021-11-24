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
                    this.$router.push(`/profile/fields/addCustomField`);
                } else {
                    this.$router.push(`/profile/fields/addField?id=${this.field.id}`);
                }
            },
            getIconSrc (fieldInfo) {
                    return fieldInfo?.icon?.path;
            }
        }
    }
</script>

<template>
    <v-card
            v-if="field"
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
</template>

<style scoped>

</style>
