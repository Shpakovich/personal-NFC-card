<script>
    export default {
        name: "field",

        props: [
            "fieldInfo"
        ],

        computed: {
            getFieldLink() {
                // TODO сделать сборщик ссылки, если тип телефон + tel: если почта mailto: ! в просмотре а не ыв ЛК
                return `/profile/fields/editField?id=${this.fieldInfo.id}`
            }
        },

        methods: {
            getIconSrc (fieldInfo) {
                const src = "http://localhost:8083/" + fieldInfo?.icon;
                return new URL(src);
            }
        }
    }
</script>

<template>
    <v-card
            v-if="fieldInfo"
            outlined
            style="display: flex!important; border-radius: 20px!important; height: auto;"
            width="100%"
            color="#EEF7FE"
    >
        <a class="mx-auto flex flex-row rounded-lg pt-5 pb-6 px-5" :href="getFieldLink">
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
            <v-btn
                    icon
                    class="font-bold m-auto"
                    max-width="24px"
                    min-width="24px"
                    height="24"
                    to="/"
            >
                <img
                        class="m-auto flex-none"
                        style="max-height: 24px; max-width: 24px"
                        src="../../../assets/images/icon/more_option.svg"
                        alt=""
                >
            </v-btn>
        </a>
    </v-card>
</template>

<style scoped>

</style>
