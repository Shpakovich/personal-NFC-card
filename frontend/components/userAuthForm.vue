<script>
    export default {
      name: "userAuthForm",

      props: [
        "submitForm",
        "buttonText"
      ],

      data: () => ({
        valid: true,
        userInfo: {
          email: 'test@test.ru',
          password: 'test1'
        },
        emailRules: [
          v => !!v || 'E-mail обязательное поле',
          v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ],
        passwordRules: [
          v => !!v || 'Пароль обязательное поле'
        ]
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
    <p>
      Забыли пароль? <a>Перейти -></a>
    </p>

    <v-btn
      :disabled="!valid"
      color="primary"
      class="mr-4"
      @click="submitForm(userInfo)"
    >
      {{ buttonText }}
    </v-btn>
  </v-form>
</template>

<style scoped>

</style>
