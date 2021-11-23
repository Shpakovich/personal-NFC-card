<script>
  import Vue from 'vue'
  import VueMask from 'v-mask'
  Vue.use(VueMask);

    export default {
      name: "register",
      layout: "createProfile",

      data: () => ({
        alias: '',
        mask: 'https://myid-card.ru/NNNNNNNNNNNN',
        valid: false,
        errorMessage: '',
        errorMessageToField: ''
      }),

      methods: {
        async registerCard(alias) {
          await this.$store.dispatch('card/setCard', alias)
            .then((res) => {
              if (res?.response?.status === 400) {
                  const errorMessage = res?.response?.data?.message;
                if( errorMessage.includes('not found') ) {
                  this.errorMessageToField = 'Метка myID с таким hash не найдена';
                } else if (errorMessage.includes('Card with alias')) {
                  this.errorMessageToField = 'Такой адрес страницы уже существует';
                } else if (errorMessage.includes('already registered')) {
                  this.errorMessageToField = 'Метка myID с таким hash уже зарегестрировнна';
                }
                this.errorMessage = res?.response?.data?.message;
              } else if (res?.response?.status === 422) {
                if (res.response.data?.errors.length) {
                  const errorMessage = res.response.data.errors[0].message;

                  if (errorMessage.includes('not be blank')) {
                    this.errorMessage = "Упс, мы не видим код с вашей метки. \n️ " +
                            "Приложите ваше устройство к метке, перейдите по ссылке и повторите активацию";
                  } else if (errorMessage.includes('value is too short')) {
                    this.errorMessageToField = 'Адрес должен состоять минимум из 3 символов';
                  }
                }
              } else {
                this.$router.push('/profile/create')
              }
            }).catch((err) => console.log(err));
        },
        resetError () {
          this.errorMessageToField = '';
        }
      }
    }
</script>

<template>
  <v-container class="py-11 px-11">
    <img
      src="../../assets/images/myID-logo.svg"
      class="mx-auto pb-4"
      alt=""
    />
    <v-btn
      icon
      class="rounded-lg flex-initial font-bold w-4/12 mb-6 ml-1.5 btn-back"
      max-width="110px"
      min-width="100px"
      height="48"
      color="secondary"
      to="/"
    >
      <img src="../../assets/images/icon/icon-arrow-left.svg" alt="">
      Назад
    </v-btn>

    <h3 class="text-center px-5 mb-6">
      Давайте активируем метку, выберете ваш ник.
    </h3>
    <v-row v-if="!errorMessage" class="flex-nowrap mb-6">
      <img src="../../assets/images/icon/info_secondary.svg" class="mr-2" alt="">
      <p class="font-gilroy my-auto">
        Повторно адрес страницы изменить будет нельзя
      </p>
    </v-row>
    <p class="font-gilroy mb-6" style="color: #FF645A;" v-if="errorMessage">
      {{ errorMessage }}
    </p>

    <v-form
      ref="form"
      class="flex flex-col"
      v-model="valid"
      lazy-validation
    >
      <v-text-field
        v-model="alias"
        v-mask="mask"
        :error-messages="errorMessageToField"
        v-on:keyup="resetError()"
        class="font-croc"
        id="alias"
        type="text"
        label="Адрес страницы"
        hint="Поддерживает только латинские буквы и цифры"
        required
        outlined
        placeholder="https://myid-card.ru/myNick"
      ></v-text-field>

      <v-btn
        :disabled="!valid"
        color="secondary"
        height="48"
        width="155"
        max-width="186"
        class="m-auto w-2/5"
        @click="registerCard(alias)"
      >
        Активировать
      </v-btn>
    </v-form>
  </v-container>
</template>

<style scoped>

</style>
