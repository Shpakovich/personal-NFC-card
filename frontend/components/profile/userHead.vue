<script>
    export default {
        name: "userHead",

        props: [
            "user",
            "edit",
            "isShow"
        ],

        data () {
            return {
                show: false,
            }
        },

        computed: {
            getUserMock() {
              if ( !this.user.name && !this.user.nickname && !this.user?.description && !this.user?.post )  {
                  return 'Ваш профиль не заполнен'
              }
            },
            getUserName() {
                return this.user.default_name === 2 ? this.user.nickname : this.user.name
            },
            getUserPhoto() {
                return this.user?.photo?.path ? `background-image: url(${this.user.photo.path});border-radius: 50px;` : ''
            },
            isPublished() {
                return this.user?.is_published
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
            <!-- <img
                    class="m-auto bg-white"
                    style="max-height: 120px; max-width: 120px; border-radius: 120px;"
                    :src="getUserPhoto"
                    alt=""
                    @click="routerToChoosePhoto()"
            >-->
            <div
                    v-if="getUserPhoto"
                    class="m-auto bg-white img-header"
                :style="getUserPhoto"
            />
            <div v-if="!isPublished && !isShow">
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
                <v-card-subtitle v-if="getUserMock" class="font-bold white--text text-white mt-4 card-padding">
                    {{ getUserMock }}
                </v-card-subtitle>
                <v-card-subtitle v-if="getUserName" class="font-bold white--text text-white card-padding">
                    {{ getUserName }}
                </v-card-subtitle>
                <v-btn
                        v-if="!edit && !isShow"
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
                <nuxt-link to="/profile/choosePhoto" style="padding: 0" class="flex white--text text-center">
                    Добавить фото
                    <img
                            class="m-0 ml-2 flex-none"
                            style="max-height: 24px; max-width: 24px"
                            src="../../assets/images/icon/add.svg"
                            alt=""
                    >
                </nuxt-link>
            </v-row>
            <v-card-subtitle v-if="!edit && user.post" class="white--text text-center card-padding">
                {{ user.post }}
            </v-card-subtitle>
            <v-card-text v-if="!edit && user.description" class="white--text text-center card-padding">
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

<style lang="scss">
    .card-padding {
        padding: 2px!important;
    }
    .img-header {
        width: 100px;
        height: 100px;
        background-position: center;
        background-size: cover;
        display: flex;
    }
</style>
