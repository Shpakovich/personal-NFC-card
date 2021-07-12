<script>
  import userRegForm from "../components/userRegForm";

  export default {
    name: "registration",

    components: {
      userRegForm
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

    methods: {
      async regUser (regInfo) {
        let data = {
          'username': regInfo.user,
          'password': regInfo.password
        };

        try {
          await this.$auth.loginWith('local',{
            data
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
      max-width="81px"
      min-width="45px"
      height="48"
      color="secondary"
      to="/"
    >
      <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M22.2075 16.45H10.6925" stroke="#FFA436" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M16.45 10.6924L10.6925 16.4499L16.45 22.2074" stroke="#FFA436" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
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
