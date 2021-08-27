<script>
    export default {
        name: "userIndexProfile",

        props: [
            "user"
        ],

        computed: {
            getUserPhoto() {
                return this.user?.photo?.path ? `background-image: url(${this.user.photo.path});border-radius: 50px;` : ''
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
        <div
                v-if="getUserPhoto"
                class="m-auto bg-white img-header index-photo"
                :style="getUserPhoto"
        />
        <v-card-subtitle v-if="getUserName" class="font-bold card-padding">
            {{ getUserName }}
        </v-card-subtitle>
    </v-row>
</template>

<style lang="scss">
    .card-padding {
        padding: 2px!important;
    }
    .index-photo {
        border: 5px solid #00A460;
        width: 100px;
        height: 100px;
        background-position: center;
        background-size: cover;
        display: flex;
    }
</style>
