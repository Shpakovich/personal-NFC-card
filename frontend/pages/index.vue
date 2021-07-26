<script>
  export default {
  }
</script>

<template>
  <v-container class="py-11 px-11">
    <img
      src="../assets/images/myID-logo.svg"
      class="mx-auto pb-4"
      alt=""
    />
    <p class="text-xl font-croc mb-3">Привет!</p>
    <h1 class="text-5xl pb-4 font-croc">
      Это myID
    </h1>
    <h2 class="text-md leading-6 pb-4 font-gilroy text-color-secondary">
      Мы электронная визитка в которой можно указать ссылки на все свои соцсети и контакты.
    </h2>
    <h2 class="text-md leading-6 pb-6 font-gilroy text-color-secondary">
      Она позволит любому, кто прислонит телефон перейти в соц. сеть, позвонить, начать чат, открыть сайт,
      поделиться плейлистом или портфолио и так далее.
    </h2>
    <h2 class="text-md leading-6 pb-8 font-gilroy text-color-secondary">
      Так же можно просто сохранить
      контакт в записную книгу
      телефона, нажав всего одну кнопку.
    </h2>
    <client-only>
      <div v-if="!this.$auth.loggedIn">
        <v-row class="flex-row pb-10" >
          <v-btn
            class="rounded-lg flex-initial w-8/12"
            max-width="225px"
            min-width="150px"
            height="48"
            color="primary"
            to="/registration"
          >
            Регистрация
          </v-btn>
          <v-btn
            class="rounded-lg flex-initial flex font-bold ml-6"
            max-width="81px"
            min-width="45px"
            height="48"
            color="secondary"
            to="/authorization"
            icon
          >
            Войти
            <img src="../assets/images/icon/icon-arrow-right.svg" alt="">
          </v-btn>
        </v-row>
        <p class="font-croc font-bold text-center text-sm pb-4">
          Войти с помощью
        </p>
        <v-row class="flex-row justify-center pb-11" style="gap: 50px;" >
          <img src="../assets/images/icon/instagram-logo.svg" alt="">

          <img src="../assets/images/icon/google-logo.svg" alt="">

          <img src="../assets/images/icon/facebook-logo.svg" alt="">
        </v-row>
      </div>
      <div v-else>
        <v-row>
          <p>Вы авторизованны</p>
          <v-btn
            color="primary"
            icon
          >
            <v-icon @click="$auth.logout()">mdi-exit-to-app</v-icon>
          </v-btn>
        </v-row>
      </div>
    </client-only>
    <v-row class="flex-col leading-6 justify-center">
      <a class="text-sm text-center font-gilroy">
        URL на поддерживаемые устройства
      </a><br>
      <a class="text-sm text-center font-gilroy">
        URL на обратную связь
      </a>
      <br><br>
      <p class="text-sm text-center font-gilroy">
        2021 myID - будущее нетворкинга
      </p>
    </v-row>
  </v-container>
</template>

<style lang="scss">

  .v-btn {
    font-size: 17px!important;
    line-height: 24px!important;
 }

  h1 {
    font-weight: 700;
  }

  .signIn-svg{
    width: 17px;
    height: 17px;
  }

</style>
