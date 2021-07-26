<script>
    export default {
        name: "confirmEmail",

      data: () => ({
        loading: false,
        token: '',
        valid: false,
        errorMessages: '',
        tokenRules: [
          v => !!v || 'Введите ваш токен'
        ]
      }),

      methods: {
        async submitForm(token) {
          this.loading = true;
          this.$api.auth.confirmEmail(token).then(() => {
            if (this.$store.state.user) {
              const params = new URLSearchParams();
              const user = this.$store.state.user;
              params.append('grant_type', 'password');
              params.append('username', user.email);
              params.append('password', user.password);
              params.append('client_id', 'frontend');

              this.$auth.loginWith('local', {
                data: params
              }).then(() =>
                this.$router.push('/creatingProfile')
              );
            } else {
              this.$router.push('/authorization')
            }
          }).catch((err) => {
            if (err.response && err.response.status === 400) {
              this.errorMessages = 'Токен неправильный или устарел';
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
        :error-messages="errorMessages"
        v-on:keyup="resetError()"
        :rules="tokenRules"
        label="Код"
        name="token"
        required
        outlined
        placeholder="123456"
      ></v-text-field>

      <v-btn
      :disabled="!valid"
      :loading="loading"
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
