<template>
  <div class="alert card-alert" :class="alertClass" role="alert" v-show="hasContent" @click="clearContent">
    <ul v-if="errors.length > 1">
      <li v-for="(error, index) in errors" :key="index" >{{ error }}</li>
    </ul>
    <template v-else-if="errors.length == 1">
      {{ errors[0] }}
    </template>
    <span v-if="success">{{ success }}</span>
  </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
  computed: {
    ...mapState({
      errors: state => state.common.form.errors,
      success: state => state.common.form.success,
    }),
    alertClass() {
      if (this.errors.length > 0) {
        return ['alert-danger'];
      } else if (this.success) {
        return ['alert-success'];
      }
      return [];
    },
    hasContent() {
      return this.errors.length > 0 || this.success;
    }
  },
  methods: {
    clearContent() {
      this.$store.commit('updateFormErrors', []);
      this.$store.commit('updateFormSuccess', '');
    }
  }
}
</script>

