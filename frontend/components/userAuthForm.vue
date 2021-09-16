<script>
  export default {
      name: "userAuthForm",

      props: [
        "submitForm",
        "buttonText",
        "errorMessages",
        "errorPasswordMessages",
        "loading"
      ],


      data: () => ({
        showPassword: false,
        showConfirm: false,
        valid: false,
        userInfo: {
          username: '',
          password: ''
        },
        emailRules: [
          v => !!v || 'E-mail обязательное поле',
          v => /.+@.+\..+/.test(v) || 'E-mail не по формату',
        ],
        passwordRules: [
          v => !!v || 'Пароль обязательное поле',
          v => v.length >= 5 || 'Минимальная длинна 5'
        ]
      }),

    computed:{
        colorIcon () {
          return this.showPassword ? '#68676C' : '#FFA436';
        },
        typeInput () {
          return this.showPassword ? 'text' : 'password'
        }
    },
    methods: {
      resetError () {
        this.$emit('resetError'); // TODO надо бы сделать через vuex actions
      }
    }
  }
</script>

<template>
  <v-form
    ref="form"
    class="flex flex-col xl:m-auto form-container_xl"
    v-model="valid"
  >

    <v-text-field
      class="font-croc"
      v-model="userInfo.username"
      :error-messages="errorMessages"
      v-on:keyup="resetError()"
      :rules="emailRules"
      label="Email"
      required
      outlined
      placeholder="Ваш email"
    ></v-text-field>

    <v-text-field
      id="password"
      class="font-croc"
      v-model="userInfo.password"
      v-on:keyup="resetError()"
      :error-messages="errorPasswordMessages"
      :rules="passwordRules"
      :type="typeInput"
      name="password"
      label="Пароль"
      placeholder="Ваш пароль"
      outlined
      counter
    >
      <template v-slot:append>
        <div @click="showPassword = !showPassword">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14.12 14.12C13.8454 14.4147 13.5141 14.6512 13.1462 14.8151C12.7782 14.9791 12.3809 15.0673 11.9781 15.0744C11.5753 15.0815 11.1752 15.0074 10.8016 14.8565C10.4281 14.7056 10.0887 14.481 9.80385 14.1962C9.51897 13.9113 9.29439 13.5719 9.14351 13.1984C8.99262 12.8248 8.91853 12.4247 8.92563 12.0219C8.93274 11.6191 9.02091 11.2218 9.18488 10.8538C9.34884 10.4859 9.58525 10.1546 9.88 9.88M1 1L23 23M17.94 17.94C16.2306 19.243 14.1491 19.9649 12 20C5 20 1 12 1 12C2.24389 9.6819 3.96914 7.65661 6.06 6.06L17.94 17.94ZM9.9 4.24C10.5883 4.07888 11.2931 3.99834 12 4C19 4 23 12 23 12C22.393 13.1356 21.6691 14.2047 20.84 15.19L9.9 4.24Z" :stroke="colorIcon" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </template>
    </v-text-field>
    <p class="text-sm font-gilroy inline-flex mb-9">
      Забыли пароль?
      <nuxt-link class="contents" to="/resetPassword">Перейти
        <img src="../assets/images/icon/icon-arrow-right-primary.svg" alt="">
      </nuxt-link>
    </p>

    <v-btn
      :disabled="!valid"
      :loading="loading"
      color="primary"
      height="48"
      max-width="136"
      class="m-auto w-2/5"
      @click="submitForm(userInfo)"
    >
      {{ buttonText }}
    </v-btn>
  </v-form>
</template>

<style scoped>

</style>
