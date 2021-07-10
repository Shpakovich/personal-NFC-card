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
      })
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
      class="font-croc"
      v-model="userInfo.password"
      :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
      :rules="passwordRules"
      :type="showPassword ? 'text' : 'password'"
      name="password"
      label="Пароль"
      placeholder="Ваш пароль"
      outlined
      counter
      @click:append="showPassword = !showPassword"
    ></v-text-field>
    <p class="text-sm font-gilroy inline-flex mb-9">
      Забыли пароль?
      <nuxt-link class="contents" to="/resetPassword">Перейти
      <svg width="22" height="22" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M10.6925 16.4502H22.2075" stroke="#475DEB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M16.45 10.6924L22.2075 16.4499L16.45 22.2074" stroke="#475DEB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
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
