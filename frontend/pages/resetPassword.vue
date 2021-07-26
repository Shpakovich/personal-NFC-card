<script>
  export default {
    name: "resetPassword",

    data: () => ({
      valid: false,
      loading: false,
      email: '',
      errorMessages: '',
      emailRules: [
        v => !!v || 'E-mail обязательное поле',
        v => /.+@.+\..+/.test(v) || 'E-mail не по формату',
      ]
    }),

    methods: {
      async submitForm(email) {
        this.loading = true;
        this.$api.auth.resetPassword(email).then((res) => {
            this.$router.push('/authorization')
          }
        ).catch((err) => {
          if (err.response && err.response.status === 400) { // TODO глянуть список возможных ответов
            this.errorMessages = 'Пользователь не найдён';
          } else if (err.response && err.response.status === 422) {
            this.errorMessages = 'Введен некорректный Email';
          }
        });
        this.loading = false;
      },
      resetError () {
        this.errorMessages = '';
      }
    }
  }
</script>

<template>
  <v-container class="py-11 px-11">
    <img
      src="../assets/images/myID-logo.svg"
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
      to="/authorization"
    >
      <svg class="button-svg" width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M22.2075 16.45H10.6925" stroke="#FFA436" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M16.45 10.6924L10.6925 16.4499L16.45 22.2074" stroke="#FFA436" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      Назад
    </v-btn>

    <v-form
      ref="form"
      class="flex flex-col"
      v-model="valid"
    >
      <v-text-field
        class="font-croc"
        v-model="email"
        :error-messages="errorMessages"
        v-on:keyup="resetError()"
        :rules="emailRules"
        label="Email"
        required
        outlined
        placeholder="Ваш email"
      ></v-text-field>

      <v-btn
        :disabled="!valid"
        :loading="loading"
        color="secondary"
        height="48"
        max-width="136"
        class="m-auto w-2/5"
        @click="submitForm(email)"
      >
        Далее
      </v-btn>
    </v-form>
  </v-container>
</template>

<style scoped>

</style>
