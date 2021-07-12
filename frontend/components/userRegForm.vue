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
        },
        colorPasswordIcon () {
          return this.showPassword ? '#68676C' : '#FFA436';
        },
        colorConfirmPasswordIcon () {
          return this.showConfirm ? '#68676C' : '#FFA436';
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
      :rules="passwordRules"
      :type="showPassword ? 'text' : 'password'"
      name="password"
      label="Пароль"
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
