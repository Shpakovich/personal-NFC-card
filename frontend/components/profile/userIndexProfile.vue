<script>
    export default {
        name: "userIndexProfile",

        props: [
            "user"
        ],

        computed: {
            getUserPhoto() {
                return this.user?.photo?.path ? this.user.photo.path : ''
            },
            getUserName() {
                return this.user.default_name === 1 ? this.user.name : this.user.nickname
            }
        },

        methods: {
            redirectToPage() {
                this.$router.push('/profile/page')
            }
        }
    }
</script>

<template>
    <v-row
            @click="redirectToPage()"
            style="display: flex;flex-direction: column!important; text-align: center;"
    >
        <img
                class="m-auto bg-white"
                style="max-height: 120px; max-width: 120px; border-radius: 120px; border: 5px solid #00A460;"
                :src="getUserPhoto"
                alt=""
        >
        <v-card-subtitle v-if="getUserName" class="font-bold">
            {{ getUserName }}
        </v-card-subtitle>
    </v-row>
</template>

<style scoped>

</style>
