<script>
  import Vue from 'vue'
  import VueMask from 'v-mask'
  Vue.use(VueMask);

    export default {
      name: "register",
      layout: "createProfile",

      data: () => ({
        nick: '',
        mask: 'https://myid-card/NNNNNNNNNNNNN',
        valid: false
      }),

      methods: {
        async registerCard(nick) {
          const alias = nick.substr(nick.indexOf("myid-card/") + 10);
          const data = {
            id: this.getCookie('hash'),
            alias
          };
          await this.$api.card.registrationCard(data)
        },
        getCookie(name) { // TODO Вынести в хелпер
          const value = `; ${document.cookie}`;
          const parts = value.split(`; ${name}=`);
          if (parts.length === 2) return parts.pop().split(';').shift();
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

    <h3 class="text-center px-5 mb-6">
      Ура, вы подтвердили почту. Давайте активируем метку. Выберете ваш ник.
    </h3>
    <v-form
      ref="form"
      class="flex flex-col"
      v-model="valid"
      lazy-validation
    >
      <v-text-field
        v-model="nick"
        v-mask="mask"
        class="font-croc"
        label="Адрес страницы"
        required
        outlined
        placeholder="https://myid-card/myNick"
      ></v-text-field>

      <v-btn
        :disabled="!valid"
        color="secondary"
        height="48"
        max-width="186"
        class="m-auto w-2/5"
        @click="registerCard(nick)"
      >
        Активировать
      </v-btn>
    </v-form>
  </v-container>
</template>

<style scoped>

</style>
