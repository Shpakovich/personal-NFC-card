<script>
  import userAuthForm from "../components/userAuthForm";

  export default {
    name: "authorization",

    components: {
      userAuthForm
    },

    data: () => ({
      valid: true,
      userInfo: {
        user: '',
        password: ''
      },
      emailRules: [
        v => !!v || 'E-mail обязательное поле',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      passwordRules: [
        v => !!v || 'Пароль обязательное поле'
      ]
    }),

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
      class="rounded-lg flex-initial"
      style="width: 28%"
      max-width="81px"
      min-width="45px"
      height="48"
      color="secondary"
      to="/"
    >
      <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M10.6925 16.4502H22.2075" stroke="#FFA436" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M16.45 10.6924L22.2075 16.4499L16.45 22.2074" stroke="#FFA436" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      Назад
    </v-btn>
    <userAuthForm buttonText="Войти" :submitForm="loginUser" />
  </v-container>
</template>

<style scoped>

</style>
