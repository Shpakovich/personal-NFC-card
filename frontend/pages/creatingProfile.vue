<script>
  export default {
    name: "creatingProfile",
    layout: "createProfile"
  }
</script>

<template>
  <v-container class="py-11 px-11">
    <img
      src="../assets/images/myID-logo.svg"
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
      <img src="../assets/images/icon/icon-arrow-left.svg" alt="">
      Назад
    </v-btn>

    <v-form
      ref="form"
      class="flex flex-col"
      v-model="valid"
      lazy-validation
    >

      <v-text-field
        class="font-croc"
        label="Имя"
        required
        outlined
        placeholder="Ваше имя"
      ></v-text-field>

      <v-text-field
        class="font-croc"
        label="Номер телефона"
        required
        outlined
        placeholder="+ 7 ( ... ) ...  ..  .."
      ></v-text-field>
      <v-btn
        :disabled="!valid"
        color="secondary"
        height="48"
        max-width="136"
        class="m-auto w-2/5"
        @click="submitForm(token)"
      >
        Далее
      </v-btn>
    </v-form>
  </v-container>
</template>

<style scoped>

</style>
