<script>
  import userAuthForm from "../components/userAuthForm";

  export default {
    name: "authorization",

    components: {
      userAuthForm
    },

    mounted() {
      if(this.$auth.loggedIn) {
        // const cookieRes = this.$cookies.get('auth.redirect');
        // window.location.href = cookieRes; // router не работает
      }
    },

    methods: {
      async loginUser (loginInfo) {
        try {
          await this.$auth.loginWith('local',{
            data: loginInfo
          });
        } catch (err) {
          console.log(err)
        }
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
    <userAuthForm buttonText="Войти" :submitForm="loginUser" />
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
