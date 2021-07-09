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
        checkboxRules: [
          v => !!v || 'Посмотрите политику конфиденциальности',
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
    class="flex flex-col"
    v-model="valid"
  >

    <v-text-field
      class="font-croc"
      v-model="userInfo.name"
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
      hint="Пароль недёжный, наверное"
      outlined
      counter
      @click:append="showPassword = !showPassword"
    ></v-text-field>

    <v-text-field
      class="font-croc"
      v-model="userInfo.confirmPassword"
      :append-icon="showConfirm ? 'mdi-eye' : 'mdi-eye-off'"
      :rules="confirmPasswordRules.concat(passwordConfirmationRule)"
      :type="showConfirm ? 'text' : 'password'"
      name="password"
      label="Повторите пароль"
      placeholder="Ваш пароль"
      counter
      outlined
      @click:append="showConfirm = !showConfirm"
    ></v-text-field>
    <div class="flex flex-row">
      <input v-model="checkbox" :rules="checkboxRules" class="ml-4 font-croc" type="checkbox" id="privacy" name="privacy">
      <label for="privacy">Я согласен(а) на обработку персональных данных и соглашаюсь с политикой конфиденциальности</label>
    </div>

    <v-btn
      :disabled="!valid"
      color="primary"
      class="rounded-lg flex-initial m-auto w-8/12"
      max-width="225px"
      min-width="150px"
      height="48"
      @click="regForm(userInfo)"
    >
      {{ buttonText }}
    </v-btn>
  </v-form>
</template>

<style lang="scss">

  .v-input__slot {
    min-height: 50px!important;
  }

  .v-text-field input{
    padding: 12px 0 0px!important;
  }


</style>
