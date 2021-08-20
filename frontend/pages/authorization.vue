<script>
  import userAuthForm from "../components/userAuthForm";

  export default {
    name: "authorization",

    components: {
      userAuthForm
    },

    data: () => ({
      loading: false,
      errorMessage: '',
      errorPassword: ''
    }),

    methods: {
      async loginUser(loginInfo) {
        this.loading = true;
        this.logOut();
        const params = new URLSearchParams();
        params.append('grant_type', 'password');
        params.append('username', loginInfo.username);
        params.append('password', loginInfo.password);
        params.append('client_id', 'frontend');

        try {
          await this.$auth.loginWith('local',{
            data: params
          }).then(()=> { this.$router.push('/profile/page'); });
        } catch (err) {
          if ( err.response && err.response.status === 400) { // TODO глянуть список возможных ответов
            this.errorMessage = 'Неверный логин или пароль';
            this.errorPassword = ' ';
          }
        }
        this.loading = false;
      },
      setError() {
        this.errorMessage = '';
        this.errorPassword = '';
      },
      logOut () {
        this.$auth.logout().then(
                this.resetProfile()
        )
      },
      resetProfile () {
        this.$store.commit('profile/SET_PROFILE_INFO', {});
        this.$store.commit('profile/SET_PROFILE_FIELDS', {});
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
    <userAuthForm
      buttonText="Войти"
      :loading="loading"
      @resetError="setError()"
      :errorMessages="errorMessage"
      :errorPasswordMessages="errorPassword"
      :submitForm="loginUser"
    />
  </v-container>
</template>

<style lang="scss">
  .button-svg {
    width: 32px;
    height: 32px;
  }

  .btn-back {
    justify-content: normal!important;
  }

  .v-btn {
    font-size: 17px!important;
    line-height: 24px!important;
  }
</style>
