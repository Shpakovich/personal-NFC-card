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
      <svg class="button-svg" width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M22.2075 16.45H10.6925" stroke="#FFA436" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M16.45 10.6924L10.6925 16.4499L16.45 22.2074" stroke="#FFA436" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
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
