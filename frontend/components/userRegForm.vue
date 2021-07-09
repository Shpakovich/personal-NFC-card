<script>
    export default {
      name: "userRegForm",

      props: [
        "regForm",
        "buttonText"
      ],

      data: () => ({
        showPassword: false,
        showConfirm: false,
        valid: false,
        userInfo: {
          name: '',
          password: '',
          confirmPassword: '',
        },
        emailRules: [
          v => !!v || 'E-mail обязательное поле',
          v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ],
        passwordRules: [
          v => !!v || 'Пароль обязательное поле',
          v => v.length >= 5 || 'Минимальная длинна 5'
        ],
        confirmPasswordRules: [
          v => !!v || 'Подтвердите пароль',
        ],
        checkbox: false
      }),

      computed: {
        passwordConfirmationRule() {
          return () =>
            this.userInfo.password === this.userInfo.confirmPassword || "Пароли не совпадают";
        }
      }
    }
</script>

<template>
  <v-form
    ref="form"
    v-model="valid"
    lazy-validation
  >

    <v-text-field
      v-model="userInfo.name"
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

    <v-text-field
      v-model="userInfo.confirmPassword"
      :append-icon="showConfirm ? 'mdi-eye' : 'mdi-eye-off'"
      :rules="confirmPasswordRules.concat(passwordConfirmationRule)"
      :type="showConfirm ? 'text' : 'password'"
      name="password"
      label="Повторите пароль"
      placeholder="Ваш пароль"
      counter
      @click:append="showConfirm = !showConfirm"
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
