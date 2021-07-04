<script>
    export default {
      name: "userRegForm",

      props: [
        "regForm",
        "buttonText"
      ],

      data: () => ({
        valid: true,
        userInfo: {
          email: 'test@test.ru',
          password: 'test1',
          passwordConfirm: 'test1',
        },
        emailRules: [
          v => !!v || 'E-mail обязательное поле',
          v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ],
        passwordRules: [
          v => !!v || 'Пароль обязательное поле'
        ],
        passwordConfirmRules: [
          v => !!v || 'Пароль обязательное поле'
        ],
        checkbox: false
      })
    }
</script>

<template>
  <v-form
    ref="form"
    v-model="valid"
    lazy-validation
  >

    <v-text-field
      v-model="userInfo.email"
      :rules="emailRules"
      label="Email"
      required
      placeholder="Ваш email"
    ></v-text-field>

    <v-text-field
      v-model="userInfo.password"
      :rules="passwordRules"
      label="Пароль"
      required
      placeholder="Ваш пароль"
    ></v-text-field>

    <v-text-field
      v-model="userInfo.passwordConfirm"
      :rules="passwordConfirmRules"
      label="Повторите пароль"
      required
      placeholder="Ваш пароль"
    ></v-text-field>

    <v-checkbox
      v-model="checkbox"
      label="Я согласен(а) на обработку персональных данных и соглашаюсь с политикой конфиденциальности"
      required
    ></v-checkbox>

    <v-btn
      :disabled="!valid"
      color="primary"
      class="mr-4"
      @click="regForm(userInfo)"
    >
      {{ buttonText }}
    </v-btn>
  </v-form>
</template>

<style scoped>

</style>
