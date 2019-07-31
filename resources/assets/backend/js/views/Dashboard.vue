<template>
  <div class="page-main">
    <my-header />
    <header-menu />
    <div class="my-3 my-md-5">
      <div :class="containerClass">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import Header from '../components/Header';
import HeaderMenu from '../components/HeaderMenu';

export default {
  created() {
    this.$store.dispatch('fetchUserInfo');
    this.$store.dispatch('fetchRolesAndPermissions');
    this.$store.dispatch('fetchSettings');
    this.$store.dispatch('fetchAllUsers');
  },
  components: {
    'my-header': Header,
    HeaderMenu
  },
  computed: {
    ...mapState({
      path: state => state.common.route.path
    }),
    containerClass() {
      if (_.split(this.path, '/')[1] == 'calendar') {
        return ['container-fluid'];
      } else if (this.$route.name == 'tickets') {
        return ['container-fluid'];
      }

      return ['container'];
    }
  }
};
</script>
