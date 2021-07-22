<script>
  export default {
    name: "newPassword",

    data: () => ({
      showPassword: false,
      showConfirm: false,
      valid: false,
      token: '',
      title: '',
      userInfo: {
        password: '',
        confirmPassword: '',
      },
      passwordRules: [
        v => !!v || 'Пароль обязательное поле',
        v => v.length >= 5 || 'Минимальная длинна 5'
      ],
      confirmPasswordRules: [
        v => !!v || 'Подтвердите пароль',
      ]
    }),

    mounted () {
      if (!this.$route.query?.token) {
        this.title = 'Ой, кажется ваша ссылка изменения пароля не правильная.';
      }
      this.token = this.$route.query?.token;
    },

    computed: {
      passwordConfirmationRule() {
        return () =>
          this.userInfo.password === this.userInfo.confirmPassword || "Пароли не совпадают";
      },
      colorPasswordIcon () {
        return this.showPassword ? '#68676C' : '#FFA436';
      },
      colorConfirmPasswordIcon () {
        return this.showConfirm ? '#68676C' : '#FFA436';
      }
    },

    methods: {
      async setNewPassword () {
        let data = {
          'token': this.token,
          'password': this.userInfo.password
        };

        await this.$api.auth.confirmNewPassword(data)
          .then(() => this.$router.push('/authorization'))
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
    <v-form
      ref="form"
      class="flex flex-col"
      v-model="valid"
    >
      <h3>{{ title }}</h3>
      <v-text-field
        class="font-croc"
        v-model="userInfo.password"
        :rules="passwordRules"
        :type="showPassword ? 'text' : 'password'"
        name="password"
        label="Введите новый пароль"
        placeholder="Ваш пароль"
        hint="Пароль недёжный, наверное"
        outlined
        counter
      >
        <template v-slot:append>
          <div @click="showPassword = !showPassword">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M14.12 14.12C13.8454 14.4147 13.5141 14.6512 13.1462 14.8151C12.7782 14.9791 12.3809 15.0673 11.9781 15.0744C11.5753 15.0815 11.1752 15.0074 10.8016 14.8565C10.4281 14.7056 10.0887 14.481 9.80385 14.1962C9.51897 13.9113 9.29439 13.5719 9.14351 13.1984C8.99262 12.8248 8.91853 12.4247 8.92563 12.0219C8.93274 11.6191 9.02091 11.2218 9.18488 10.8538C9.34884 10.4859 9.58525 10.1546 9.88 9.88M1 1L23 23M17.94 17.94C16.2306 19.243 14.1491 19.9649 12 20C5 20 1 12 1 12C2.24389 9.6819 3.96914 7.65661 6.06 6.06L17.94 17.94ZM9.9 4.24C10.5883 4.07888 11.2931 3.99834 12 4C19 4 23 12 23 12C22.393 13.1356 21.6691 14.2047 20.84 15.19L9.9 4.24Z" :stroke="colorPasswordIcon" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </template>
      </v-text-field>

      <v-text-field
        class="font-croc"
        v-model="userInfo.confirmPassword"
        :rules="confirmPasswordRules.concat(passwordConfirmationRule)"
        :type="showConfirm ? 'text' : 'password'"
        name="password"
        label="Повторите пароль"
        placeholder="Ваш пароль"
        counter
        outlined
      >
        <template v-slot:append>
          <div @click="showConfirm = !showConfirm">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M14.12 14.12C13.8454 14.4147 13.5141 14.6512 13.1462 14.8151C12.7782 14.9791 12.3809 15.0673 11.9781 15.0744C11.5753 15.0815 11.1752 15.0074 10.8016 14.8565C10.4281 14.7056 10.0887 14.481 9.80385 14.1962C9.51897 13.9113 9.29439 13.5719 9.14351 13.1984C8.99262 12.8248 8.91853 12.4247 8.92563 12.0219C8.93274 11.6191 9.02091 11.2218 9.18488 10.8538C9.34884 10.4859 9.58525 10.1546 9.88 9.88M1 1L23 23M17.94 17.94C16.2306 19.243 14.1491 19.9649 12 20C5 20 1 12 1 12C2.24389 9.6819 3.96914 7.65661 6.06 6.06L17.94 17.94ZM9.9 4.24C10.5883 4.07888 11.2931 3.99834 12 4C19 4 23 12 23 12C22.393 13.1356 21.6691 14.2047 20.84 15.19L9.9 4.24Z" :stroke="colorConfirmPasswordIcon" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </template>
      </v-text-field>

      <v-btn
        :disabled="!valid"
        color="primary"
        class="rounded-lg flex-initial m-auto w-8/12"
        max-width="225px"
        min-width="150px"
        height="48"
        @click="setNewPassword()"
      >
        Далее
      </v-btn>
    </v-form>
  </v-container>
</template>

<style scoped>

</style>
