<template>
  <div id="edit-team">
    <loading v-show="loading" />
    <div class="page-header" v-show="!loading">
      <h1 class="page-title">{{ team.name }}</h1>
    </div>
    <div class="card" v-if="!loading && team.id">
      <div class="card-tabs">
        <router-link class="card-tabs-item" :to="'/calendar/'+ this.id + '/schedule'" :class="{'active': this.$route.name == 'team-schedule'}">
          <h3 class="text-center mb-1">Schedule</h3>
        </router-link>
        <router-link class="card-tabs-item" :to="'/calendar/'+ this.id + '/shift'" :class="{'active': this.$route.name == 'team-shift'}">
          <h3 class="text-center mb-1">Shift</h3>
        </router-link>
        <router-link class="card-tabs-item" :to="'/calendar/'+ this.id + '/members'" :class="{'active': this.$route.name == 'team-members'}">
          <h3 class="text-center mb-1">Member</h3>
        </router-link>
        <router-link class="card-tabs-item" :to="'/calendar/'+ this.id + '/info'" :class="{'active': this.$route.name == 'team-info'}">
          <h3 class="text-center mb-1">Info</h3>
        </router-link>
      </div>
      <div class="card-body">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  data() {
    return {
      loading: true,
      id: 0,
    };
  },
  computed: {
    ...mapState({
      team: state => state.team.currentTeam,
    })
  },
  created() {
    this.id = this.$route.params.id;
    this.fetchTeam();
  },
  methods: {
    fetchTeam() {
      this.loading = true;
      axios.get(`/api/admin/teams/${this.id}`).then(response => {
        this.loading = false;
        const { team } = response.data;
        this.$store.commit('updateCurrentTeam', team);
      }).catch(error => {
        this.loading = false;
      })
    }
  }
}
</script>

