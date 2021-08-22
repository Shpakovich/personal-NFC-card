<script>
  export default {
    name: "error404"
  }
</script>

<template>
  <v-container class="py-11 px-11 h-screen flex flex-col justify-center">
    <v-btn
      style="position: absolute; top: 47px; left: 28px;"
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
    <div>
      <img
        class="pb-16 m-auto"
        src="../../assets/images/404.svg"
        alt=""
      />
      <p class="text-center text-2xl leading-10 font-bold mb-2.5" style="color: #00A460">
        404<br/>
        Страница не найдена
      </p>
      <p class="text-center text-xl leading-7 font-bold" style="color: #FFA436">
        Page Not Found
      </p>
    </div>
  </v-container>
</template>

<style scoped>

</style>
