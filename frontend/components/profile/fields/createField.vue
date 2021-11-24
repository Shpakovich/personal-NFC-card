<script>
    export default {
        name: "createField",

        methods: {
            routeCreateTag() {
                this.$router.push(`/profile/fields/createCustomField`);
            }
        }
    }
</script>

<template>
    <v-card
            outlined
            class="mx-auto flex flex-row rounded-lg pt-5 pb-6 px-5"
            style="display: flex!important; border-radius: 20px!important;"
            height="80"
            width="100%"
            color="#EEF7FE"
            @click="routeCreateTag()"
    >
        <div class="flex justify-center" style=" width: 36px; max-width: 36px; height: 36px;">
            <img
                    class="m-auto flex-none"
                    style="max-height: 24px; max-width: 24px"
                    src="../../../assets/images/plus.svg"
                    alt=""
            >
        </div>
        <v-card-subtitle class="my-auto ml-4 font-gilroy" style="color: #415EB6;font-size: 15px;line-height: 18px; padding: 0">
            Создать свою карточку
        </v-card-subtitle>
    </v-card>
</template>

<style scoped>

</style>
