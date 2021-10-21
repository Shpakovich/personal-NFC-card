<script>
    export default {
        name: "userField",

        props: [
            "favorit",
            "index"
        ],

        computed: {
            getUserName () {
                return this.favorit?.profile?.name;
            },
            getUserPost () {
                return this.favorit?.profile?.post;
            },
            getFieldColor () {
                const order = this.index % 3;
                if (order === 0) {
                    return '#EEF7FE';
                } else if (order === 1) {
                    return '#F6FEEE';
                } else if (order === 2) {
                    return '#FEF3EE';
                }
                return '#EEF7FE';
            }
        },

        methods: {
            routeToUser () {
                this.$router.push(`/?hash=${this.favorit?.profile?.id}`);
            },
            async deleteUserFromFavorite() {
                const id = {
                    "id": this.favorit?.profile?.id // TODO вроде был id, но сейчас так
                };
                await this.$store.dispatch('user/deleteUserFromFavorites', id)
                    .catch((e) => console.log('profile/hideProfile error' + e));
            }
        }
    }
</script>

<template>
    <v-card
            v-if="favorit"
            outlined
            class="mx-auto flex flex-row rounded-lg pt-5 pb-6 px-5"
            style="display: flex!important; border-radius: 20px!important;"
            height="80"
            width="100%"
            :color="getFieldColor"
    >
        <div
                class="flex justify-center"
                style=" width: 36px; max-width: 36px; height: 36px;"
                @click="routeToUser()"
        >
            <img
                    class="m-auto flex-none"
                    style="max-height: 24px; max-width: 24px"
                    src="./../../../assets/images/icon/user-green.svg"
                    alt=""
            >
        </div>
        <div
                style="display: flex; flex-direction: column; flex-wrap: nowrap; max-width: 70%;"
                @click="routeToUser()"
        >
            <v-card-subtitle class="my-auto ml-4 font-gilroy font-bold" style="color: #415EB6;font-size: 15px;line-height: 18px; padding: 0">
                {{ getUserName }}
            </v-card-subtitle>
            <v-card-subtitle class="my-auto ml-4 font-gilroy" style="color: #415EB6;font-size: 12px;line-height: 16px; padding: 0">
                {{ getUserPost }}
            </v-card-subtitle>
        </div>
        <v-btn
                icon
                class="font-bold ml-auto"
                max-width="36px"
                min-width="36px"
                height="36"
                @click="deleteUserFromFavorite()"
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
