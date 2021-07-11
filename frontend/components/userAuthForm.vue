<script>
  export default {
      name: "userAuthForm",

      props: [
        "submitForm",
        "buttonText"
      ],

      data: () => ({
        showPassword: false,
        showConfirm: false,
        valid: false,
        userInfo: {
          user: '',
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
    }
    }
</script>

<template>
  <v-form
    ref="form"
    class="flex flex-col"
    v-model="valid"
    lazy-validation
  >

    <v-text-field
      class="font-croc"
      v-model="userInfo.user"
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
      :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
      :rules="passwordRules"
      :type="typeInput"
      name="password"
      label="Пароль"
      placeholder="Ваш пароль"
      outlined
      counter
      @click="showPassword = !showPassword"
    >
    </v-text-field>
    <p class="text-sm font-gilroy inline-flex mb-9">
      Забыли пароль?
      <nuxt-link class="contents" to="/resetPassword">Перейти
        <img src="../assets/images/icon/icon-arrow-right-primary.svg" alt="">
      </nuxt-link>
    </p>

    <v-btn
      :disabled="!valid"
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
