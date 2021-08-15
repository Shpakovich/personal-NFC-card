<script>
  export default {
    name: "create",

    data: () => ({
      nickname: '',
      name: '',
      checkbox: false,
      valid: false
    }),

    methods: {
      async createProfile() {
        const data = {
          title: this.name,
          name: this.name,
          nickname: this.nickname,
          default_name: +this.checkbox,
          card_id: this.getCookie('hash')
        };
        await this.$api.card.registrationCard(data).then((res)=> {
            // TODO записать res.card_id и id в vuex
            this.$router.push('/profile/create')
          }
        )
      }
    }
  }
</script>

<template>
  <v-container class="py-11 px-11">
    <img
      src="../../assets/images/myID-logo.svg"
      class="mx-auto pb-4"
      alt=""
    />
    <v-btn
      icon
      class="rounded-lg flex-initial font-bold w-4/12 mb-6 ml-1.5 btn-back"
      max-width="90px"
      min-width="80px"
      height="48"
      color="secondary"
      to="/"
    >
      <img src="../../assets/images/icon/icon-arrow-left.svg" alt="">
      Назад
    </v-btn>

    <v-form
      ref="form"
      class="flex flex-col"
      v-model="valid"
      lazy-validation
    >
      <v-text-field
        v-model="name"
        class="font-croc"
        label="Имя"
        required
        outlined
        placeholder="Ваше имя"
      ></v-text-field>

      <v-text-field
        v-model="nickname"
        class="font-croc"
        label="Никнейм"
        outlined
        hint="Можно использовать вместо имени"
        placeholder="my-Nick"
      ></v-text-field>

      <div class="flex flex-row ml-4 mb-6">
        <input @click="checkbox = !checkbox" class="ml-4 font-croc custom-checkbox" type="checkbox" id="name" name="privacy">
        <label for="name">Имя</label>
        <input @click="checkbox = !checkbox" class="ml-4 font-croc custom-checkbox" type="checkbox" id="nickname" name="privacy">
        <label for="nickname">Никнейм</label>
      </div>

      <v-btn
        :disabled="!valid"
        color="secondary"
        height="48"
        width="155"
        max-width="186"
        class="m-auto w-2/5"
        @click="createProfile()"
      >
        Далее
      </v-btn>
    </v-form>
  </v-container>
</template>

<style scoped>

</style>
