<script>
  import userRegForm from "../components/userRegForm";

  export default {
    name: "registration",

    components: {
      userRegForm
    },

    methods: {
      async regUser (regInfo) {
        let data = {
          'email': regInfo.email,
          'password': regInfo.password
        };

        this.$store.commit('setUserInfo', regInfo);

        await this.$api.auth.registrationUser(data)
          .then(() => this.$router.push('/confirmEmail'))
          .catch((err) => console.log(err)); // пока console.log, потом придумает что то другое
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
    <userRegForm buttonText="Регистрация" :regForm="regUser" />
  </v-container>
</template>

<style lang="scss">

  .btn-back {
    justify-content: normal!important;
  }
</style>
