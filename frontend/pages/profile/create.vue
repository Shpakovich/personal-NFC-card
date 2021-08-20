<script>
  export default {
    name: "create",
    layout: "createProfile",

    data: () => ({
      nickname: '',
      name: '',
      checkbox: true,
      valid: false,
      nameRules: [
        v => !!v || 'Заполните это поле',
      ]
    }),

    methods: {
      async createProfile() {
        const data = {
          title: this.name,
          name: this.name,
          nickname: this.nickname,
          default_name: this.checkbox+1,
          card_id: this.getCookie('hash')
        };
        await this.$store.dispatch('profile/createNewProfile', data)
                .then((data) => this.$router.push('/profile/addInfo'))
                .catch((e) => console.log('profile/setProfile error' + e));
      },
      setDefaultName() {
        this.checkbox = !this.checkbox
      },
      getCookie(name) { // TODO Вынести в хелпер
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
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
      max-width="90px"
      min-width="80px"
      height="48"
      color="secondary"
      to="/"
    >
      <img src="../../assets/images/icon/icon-arrow-left.svg" alt="">
      Назад
    </v-btn>

    <v-form
      ref="form"
      class="flex flex-col"
      v-model="valid"
    >
      <v-text-field
        v-model="name"
        :rules="nameRules"
        class="font-croc"
        label="Имя"
        required
        outlined
        placeholder="Ваше имя"
      ></v-text-field>

      <v-text-field
        v-model="nickname"
        class="font-croc"
        label="Никнейм"
        outlined
        hint="Можно использовать вместо имени"
        placeholder="my-Nick"
      ></v-text-field>

      <div class="flex flex-row justify-around ml-4 mb-6">
        <input @click="setDefaultName()" class="ml-4 font-croc custom-checkbox" type="radio" id="name" name="privacy">
        <label for="name">Имя</label>
        <input @click="setDefaultName()" class="ml-4 font-croc custom-checkbox" type="radio" id="nickname" name="privacy">
        <label for="nickname">Никнейм</label>
      </div>

      <v-btn
        :disabled="!valid"
        color="secondary"
        height="48"
        width="155"
        max-width="186"
        class="m-auto w-2/5"
        @click="createProfile()"
      >
        Далее
      </v-btn>
    </v-form>
  </v-container>
</template>

<style lang="scss">
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
    margin-right: 0.5rem;
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
    padding: 12px 0 0 !important;
  }
</style>
