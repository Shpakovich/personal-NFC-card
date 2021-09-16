<script>
  import userIndexProfile from '../components/profile/userIndexProfile';

  import { createNamespacedHelpers } from 'vuex';
  const cardStore = createNamespacedHelpers('card');
  const profileStore = createNamespacedHelpers('profile');
  const showStore = createNamespacedHelpers('show');

  export default {
    components: {
      userIndexProfile
    },

    computed:{
      ...profileStore.mapState({
        profile: (state) => state
      }),
      ...showStore.mapState({
        show: (state) => state
      }),
      ...cardStore.mapState({
        card: (state) => state
      }),
      getUserName () {
        return this.profile?.name;
      },
      hasRegisterCard () {
        return (!!this.card.card?.id);
      },
      hasRegisterProfile () {
        return (!!this.profile.id);
      },
      getYear () {
        const data = new Date();
        return data.getFullYear();
      }
    },

    async asyncData ({ store, route }) {
      if (!!route.query?.hash) {
        await store.dispatch('show/getShowProfile', route.query?.hash)
                .catch((e) => console.log('show/getShowProfile error ' + e));
      }
      if( !!store.state.show.profile?.id ) {
        const fields = store.state.show.profile?.fields;
        const sortable = [];

        for (let field in fields) {
          const num = fields[field];
          for (let fiel in num) {
            sortable.push(num[fiel]);
          }
        }

        sortable.sort(function (a, b) {
          return a.sort - b.sort;
        });

        store.commit('show/SET_SHOW_PROFILE_SORT_FIELDS', sortable);
      } else {
        await store.dispatch('profile/getAllProfilesInfo')
                .catch((e) => console.log('profile/getAllProfilesInfo error' + e));
      }

      const cardID = store.state.card?.card?.id;
      const profileID = store.state.profile?.id;
      const user = store.state.auth.user;
      if ((!cardID || !profileID) && !!user) {
        await store.dispatch('card/getUserCards')
                .catch((e) => console.log('card/getUserCards error ' + e));
      }
    },


    async mounted() {
      if (!!this.show.profile?.id) {
        if(this.show.card?.alias.includes('/')) {
          await this.$router.push(`/hash=${this.show.card?.id}`);
        } else {
          await this.$router.push(`/${this.show.card?.alias}`);
        }
      } else if (this.$route.query?.hash) {
        let name = "hash";
        let hashValue = this.$route.query.hash;

        document.cookie = encodeURIComponent(name) + '=' + encodeURIComponent(hashValue);
      }
    },

    methods: {
      logOut () {
          this.$auth.logout().then(
                  this.resetProfile()
        )
      },
      resetProfile () {
        this.$store.commit('profile/SET_PROFILE_INFO', {});
        this.$store.commit('profile/SET_PROFILE_FIELDS', {});
      }
    }
  }
</script>

<template>
  <v-container class="py-11 px-11 xl:flex xl:flex-row xl:h-full">
    <img
            style="max-width: 415px;"
      src="../assets/images/myID-logo.svg"
      class="mx-auto pb-4 xl:w-full"
      alt=""
    />
    <div
            class="xl:text-center xl:m-auto"
            style="max-width: 550px;"
    >
      <v-row v-if="!this.$auth.loggedIn" style="display: flex;flex-direction: column!important;">
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
      </v-row>
      <v-row class="mb-4" style="justify-content: center;" v-else-if="this.$auth.loggedIn && hasRegisterCard && hasRegisterProfile" >
        <p class="font-croc text-center">
          Привет, {{ getUserName }}!<br/>
          Мы рады снова видеть тебя.
        </p>
      </v-row>

      <div v-if="!this.$auth.loggedIn">
        <v-row class="flex-row pb-10 xl:justify-center" >
          <v-btn
              class="rounded-lg flex-initial w-8/12"
              max-width="175px"
              min-width="150px"
              height="48"
              color="primary"
              to="/registration"
          >
            Регистрация
          </v-btn>
          <v-btn
              class="rounded-lg flex font-bold ml-6"
              max-width="90px"
              min-width="85px"
              height="48"
              color="secondary"
              to="/authorization"
              icon
          >
            Войти
            <img src="../assets/images/icon/icon-arrow-right.svg" alt="">
          </v-btn>
        </v-row>
        <!-- <p class="font-croc font-bold text-center text-sm pb-4">
          Войти с помощью
        </p>
        <v-row class="flex-row justify-center pb-11" style="gap: 50px;" >
          <img src="../assets/images/icon/instagram-logo.svg" alt="">

          <img src="../assets/images/icon/google-logo.svg" alt="">

          <img src="../assets/images/icon/facebook-logo.svg" alt="">
        </v-row> -->
      </div>
      <div class="flex flex-col" v-else>
        <userIndexProfile v-if="hasRegisterCard" class="mb-8" :user="profile" />
        <div class="flex- flex-col text-center mb-8" v-if="!hasRegisterCard">
          <p class="font-gilroy text-center mb-1">
            К сожалению, мы не нашли у вас зарегестрированной метки myID.
          </p>
          <nuxt-link class="font-gilroy text-center" to="/card/register">
            Зарегестрировать карту
          </nuxt-link>
        </div>
        <div class="flex- flex-col text-center mb-8" v-if="hasRegisterCard && !hasRegisterProfile">
          <p class="font-gilroy text-center mb-1">
            У вас ещё нет своего профиля. Создать его можно по ссылке ниже.
          </p>
          <nuxt-link class="font-gilroy text-center" to="/profile/create">
            Создать профиль
          </nuxt-link>
        </div>
        <div class="flex flex-col justify-center mb-10" >
          <v-btn
                  class="rounded-lg m-auto white--text mb-4"
                  max-width="225px"
                  min-width="150px"
                  height="48"
                  color="#FF645A"
                  @click="logOut()"
          >
             Выйти
          </v-btn>
          <v-btn
                  icon
                  style="font-size: 15px!important; line-height: 21px!important;"
                  block
                  height="48"
                  class="rounded-lg"
                  color="secondary"
                  to="/authorization"
          >
            Войти как другой пользователь
            <img src="../assets/images/icon/icon-arrow-right.svg" alt="">
          </v-btn>
        </div>
      </div>

      <v-row class="flex-col leading-6 justify-center">
        <nuxt-link class="text-sm text-center font-gilroy" to="/info/supportedDevice">
          Поддерживаемые устройства
        </nuxt-link><br>
        <p class="text-sm text-center font-gilroy">
          Вопросы и предложения<br>
          присылай на
          <a href="mailto:myidcard.ru@gmail.com">
            потчу
          </a>
        </p>
        <p v-if="!this.$auth.loggedIn" class="mt-8 text-sm text-center font-gilroy">
          {{ getYear }} myID - будущее нетворкинга
        </p>
      </v-row>
    </div>
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
