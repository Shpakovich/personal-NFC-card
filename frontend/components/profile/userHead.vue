<script>
    export default {
        name: "userHead",

        props: [
            "user",
            "edit"
        ],

        computed: {
            getUserName() {
                return this.user.default_name === 1 ? this.user.name : this.user.nickname
            }
        }
    }
</script>

<template>
    <v-row>
        <v-card
                class="mx-auto flex-col pt-5 pb-6 px-5"
                style="display: flex!important; border-radius: 20px!important;"
                width="100%"
                color="#00A460"
        >
            <img
                    class="m-auto bg-white"
                    style="max-height: 120px; max-width: 120px; border-radius: 120px;"
                    src="https://i.pinimg.com/originals/b9/a8/e1/b9a8e1da698d290b043851a2ddfb05f7.png"
                    alt=""
            >
            <div class="flex flex-row inline-flex m-auto">
                <v-card-subtitle class="font-bold white--text text-white">
                    {{ getUserName }}
                </v-card-subtitle>
                <v-btn
                        v-if="!edit"
                        icon
                        class="font-bold mx-0 my-auto"
                        max-width="24px"
                        min-width="24px"
                        height="24"
                        to="/profile/editUserInfo"
                >
                    <img
                            class="m-auto flex-none"
                            style="max-height: 24px; max-width: 24px"
                            src="../../assets/images/icon/edit.svg"
                            alt=""
                    >
                </v-btn>
            </div>
            <v-row style="display: flex; margin: auto!important;" v-if="edit">
                <v-card-subtitle style="padding: 0" class="white--text text-center">
                    Добавить профиль
                </v-card-subtitle>
                <img
                        class="m-0 ml-2 flex-none"
                        style="max-height: 24px; max-width: 24px"
                        src="../../assets/images/icon/add.svg"
                        alt=""
                >
            </v-row>
            <v-card-subtitle v-if="!edit" class="white--text text-center">
                {{ user.post }}
            </v-card-subtitle>
            <v-card-text v-if="!edit" class="white--text text-center">
                {{ user.description }}
            </v-card-text>
        </v-card>
    </v-row>
</template>

<style scoped>

</style>
