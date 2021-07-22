<script>
    export default {
        name: "confirmEmail",

      data: () => ({
        token: '',
        valid: false,
        tokenRules: [
          v => !!v || 'Введите ваш токен'
        ]
      }),

      methods: {
        async submitForm(token) {
          this.$api.auth.confirmEmail(token).then(
            // await this.$auth.loginWith('local',{}), TODO после добавления store берём данные для логина от туда
            this.$router.push('/creatingProfile')
          );
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
      to="/"
    >
      <img src="../assets/images/icon/icon-arrow-left.svg" alt="">
      Назад
    </v-btn>
    <h3 class="text-center px-5 mb-6">
      Вам на почту пришел код,
      введите его, чтобы подтвердить
      ваш e-mail
    </h3>
    <v-form
      ref="form"
      class="flex flex-col"
      v-model="valid"
      lazy-validation
    >
      <v-text-field
        class="font-croc"
        v-model="token"
        :rules="tokenRules"
        label="Код"
        required
        outlined
        placeholder="123456"
      ></v-text-field>

      <v-btn
      :disabled="!valid"
      color="primary"
      height="48"
      max-width="136"
      class="m-auto w-2/5"
      @click="submitForm(token)"
      >
        Ок
      </v-btn>
    </v-form>
  </v-container>
</template>

<style scoped>

</style>
