<script>
    export default {
        name: "userHead",

        props: [
            "user"
        ],

        computed: {
            getUserName() {
                return this.default_name ? this.user.nickname : this.user.name
            }
        }
    }
</script>

<template>
    <v-row>
        <v-card
                class="mx-auto flex flex-col rounded-lg pt-5 pb-6 px-5"
                :rounded=20
                width="100%"
                color="#00A460"
        >
            <img
                    class="m-auto bg-white"
                    style="max-height: 120px; max-width: 120px; border-radius: 120px;"
                    src="https://i.pinimg.com/originals/b9/a8/e1/b9a8e1da698d290b043851a2ddfb05f7.png"
                    alt=""
            >
            <v-card-subtitle class="text-center">
                {{ getUserName }}
            </v-card-subtitle>
            <v-card-subtitle class="text-center">
                {{ user.post }}
            </v-card-subtitle>
            <v-card-text class="text-center">
                {{ user.description }}
            </v-card-text>
        </v-card>
    </v-row>
</template>

<style scoped>

</style>
