<template>
  <div id="app-container" class="page">
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  created() {
    this.$store.dispatch('fetchLocation');
    this.$store.commit('updateFormErrors', []);
    this.$store.dispatch('updateAxiosToken');
  }
};
</script>