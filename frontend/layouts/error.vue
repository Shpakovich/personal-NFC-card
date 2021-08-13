<script>
  import error404 from '../pages/error/error404';

export default {
  layout: 'empty',
  props: {
    error: {
      type: Object,
      default: null
    }
  },

  computed: {
    errorPage () {
      if (this.error.statusCode === 404) {
        return error404;
      }
    }
  }
}
</script>


<template>
  <component
    :is="errorPage"
    :error="error"
  />
</template>
