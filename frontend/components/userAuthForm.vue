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
      v-model="userInfo.user"
      :rules="emailRules"
      label="Email"
      required
      placeholder="Ваш email"
    ></v-text-field>

    <v-text-field
      v-model="userInfo.password"
      :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
      :rules="passwordRules"
      :type="showPassword ? 'text' : 'password'"
      name="password"
      label="Пароль"
      placeholder="Ваш пароль"
      hint="Пароль недёжный, наверное"
      counter
      @click:append="showPassword = !showPassword"
    ></v-text-field>
    <p>
      Забыли пароль? <a>Перейти -></a>
    </p>

    <v-btn
      :disabled="!valid"
      color="primary"
      class="m-auto w-2/6"
      @click="submitForm(userInfo)"
    >
      {{ buttonText }}
    </v-btn>
  </v-form>
</template>

<style scoped>

</style>
