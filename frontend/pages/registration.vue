<script>
  import userRegForm from "../components/userRegForm";

  export default {
    name: "registration",

    components: {
      userRegForm
    },

    data: () => ({
      loading: false,
      errorMessage: ''
    }),

    methods: {
      async regUser (regInfo) {
        this.loading = true;
        let data = {
          'email': regInfo.email,
          'password': regInfo.password
        };

        this.$store.commit('setUserInfo', regInfo);

        await this.$api.auth.registrationUser(data)
          .then((res) => {
              this.$router.push('/confirmEmail')
            }
          )
          .catch((err) => {
            if ( err.response && err.response.status === 400) { // TODO глянуть список возможных ответов
              this.errorMessage = 'Пользователь с таким email уже существует';
            }
          }); // пока так потом придумает что то другое
        this.loading = false;
      },
      setError() {
        this.errorMessage = '';
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
      max-width="110px"
      min-width="100px"
      height="48"
      color="secondary"
      to="/"
    >
      <img src="../assets/images/icon/icon-arrow-left.svg" alt="">
      Назад
    </v-btn>
    <userRegForm
      keep-alive
      buttonText="Регистрация"
      :loading="loading"
      @resetError="setError()"
      :errorMessages="errorMessage"
      :regForm="regUser"
    />
  </v-container>
</template>

<style lang="scss">

  .btn-back {
    justify-content: normal!important;
  }
</style>
