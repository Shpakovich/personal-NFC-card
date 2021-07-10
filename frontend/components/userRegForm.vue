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
          user: '',
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
    <div class="flex flex-row ml-4 mb-6">
      <input v-model="checkbox" :rules="checkboxRules" class="ml-4 font-croc custom-checkbox" type="checkbox" id="privacy" name="privacy">
      <label for="privacy">Я согласен(а) на обработку персональных данных и соглашаюсь<nuxt-link class="contents" to="/privacy">с политикой конфиденциальности</nuxt-link>
      </label>
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

  .v-text-field--outlined, .v-text-field--solo {
    border-radius: 10px;
  }

  .custom-checkbox {
    position: absolute;
    z-index: -1;
    opacity: 0;
  }

  .custom-checkbox+label {
    display: inline-flex;
    align-items: center;
    user-select: none;
  }
  .custom-checkbox+label::before {
    content: '';
    display: inline-block;
    width: 1.5rem;
    height: 1.5rem;
    flex-shrink: 0;
    flex-grow: 0;
    border: 1px solid $secondary;
    border-radius: 4px;
    margin-right: 1.375rem;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 50% 50%;
  }

  .custom-checkbox:checked+label::before {
    border-color: $secondary;
    background-color: $secondary;
    filter: drop-shadow(0px 4px 8px rgba(50, 50, 71, 0.16));
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
  }

  label {
    font-size: 12px;
    line-height: 20px;
    color: #68676C;
  }

  .v-input__slot {
    min-height: 50px!important;
  }

  .v-text-field input{
    padding: 12px 0 0px!important;
  }


</style>
