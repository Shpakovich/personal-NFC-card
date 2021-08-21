<script>
    export default {
        name: "profileEditHeader",

        methods: {
            submitEditUser(){
                this.$emit('editUser');
            }
        }
    }
</script>

<template>
    <v-container class="pt-11 pb-0 px-11">
        <v-row style="justify-content: space-between">
            <v-btn
                    icon
                    class="rounded-lg font-bold w-4/12"
                    max-width="110px"
                    min-width="100px"
                    height="48"
                    color="secondary"
                    to="/profile/page"
            >
                <img src="../../../assets/images/icon/icon-arrow-left.svg" alt="">
                Назад
            </v-btn>
            <v-btn
                    icon
                    class="rounded-lg font-bold w-4/12"
                    max-width="30px"
                    height="48"
                    color="secondary"
                    @click="submitEditUser()"
            >
                <img src="../../../assets/images/icon/done.svg" alt="">
            </v-btn>
        </v-row>
    </v-container>
</template>

<style scoped>

</style>
