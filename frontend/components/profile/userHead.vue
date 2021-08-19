<script>
    export default {
        name: "userHead",

        props: [
            "user",
            "edit"
        ],

        data () {
            return {
                show: false,
            }
        },

        computed: {
            getUserName() {
                return this.user.default_name === 1 ? this.user.name : this.user.nickname
            },
            getUserPhoto() {
                console.log(this.user)
                return this.user?.photo?.path ? this.user.photo.path : 'https://i.pinimg.com/originals/b9/a8/e1/b9a8e1da698d290b043851a2ddfb05f7.png'
            },
            isPublished() {
                return this.user.is_published
            }
        },

        methods: {
            async changeVisibilityProfile (status) {
                const data = {
                    id: this.user.id
                };
                if (status) {
                    await this.$store.dispatch('profile/publishProfile', data)
                        .then(() => this.$router.push('/profile/page'))
                        .catch((e) => console.log('profile/publishProfile error' + e));
                } else {
                    await this.$store.dispatch('profile/hideProfile', data)
                        .then(() => this.$router.push('/profile/page'))
                        .catch((e) => console.log('profile/hideProfile error' + e));
                }
            },
            routerToChoosePhoto() {
                if (this.edit) {
                    this.$router.push('/profile/choosePhoto')
                }
            }
        }
    }
</script>

<template>
    <v-row :style="edit ? 'border: 3px solid #00A460;' : ''" style="flex-direction: column!important; border-radius: 20px;">
        <v-card
                class="mx-auto flex-col pt-5 pb-6 px-5"
                style="display: flex!important; border-radius: 15px!important;"
                width="100%"
                color="#00A460"
        >
            <img
                    class="m-auto bg-white"
                    style="max-height: 120px; max-width: 120px; border-radius: 120px;"
                    :src="getUserPhoto"
                    alt=""
                    @click="routerToChoosePhoto()"
            >
            <div v-if="!isPublished">
                <v-tooltip
                        v-model="show"
                        top
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                                style="position: absolute; left: 12px; top: 8px;"
                                icon
                                v-bind="attrs"
                                @click="show = !show"
                        >
                            <img src="../../assets/images/icon/eye-off-red.svg" alt="">
                        </v-btn>
                    </template>
                    <span>Профиль не опубликован</span>
                </v-tooltip>
            </div>
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
        <div style="display: flex;flex-direction: column!important;">
            <v-btn
                    v-if="edit && !isPublished"
                    plain
                    color="#FFA436"
                    style="font-size: 15px!important; line-height: 17.89px!important;"
                    class="font-bold mx-auto mt-5 mb-4"
                    @click="changeVisibilityProfile(true)"
            >
                <img class="mr-3" src="../../assets/images/icon/u_create-dashboard.svg" alt="">
                Опубликовать профиль
            </v-btn>
            <v-btn
                    v-if="edit && isPublished"
                    plain
                    color="#475DEB"
                    style="font-size: 15px!important; line-height: 17.89px!important;"
                    class="font-bold mx-auto mt-5 mb-4"
                    @click="changeVisibilityProfile(false)"
            >
                <img class="mr-3" src="../../assets/images/icon/eye-off.svg" alt="">
                Скрыть профиль
            </v-btn>
        </div>
    </v-row>
</template>

<style scoped>

</style>
