<template>
  <div id="team-info">
    <form action="" @submit.prevent="editTeam">
      <div class="row">
        <div class="col-lg-8 col-md-10 offset-lg-2 offset-md-1">
          <div class="card">
            <form-message />
            <div class="card-body">
              <div class="form-group row">
                <label class="col-form-label col-sm-4">Name</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="name" v-model="form.name" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-4">Leader</label>
                <div class="col-sm-8">
                  <multiselect v-model="selectedLeader" track-by="id" label="name" placeholder="Select a leader" :options="users" :searchable="true" :allow-empty="true">
                    <template slot="singleLabel" slot-scope="{ option }">{{ option.id }} - {{ option.name }}</template>
                    <template slot="option" slot-scope="{ option }">{{ option.id }} - {{ option.name }}</template>
                  </multiselect>
                  <!-- <pre class="language-json"><code>{{ selectedLeader  }}</code></pre> -->
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-4">Status</label>
                <div class="col-sm-8">
                  <select class="form-control" v-model="form.status">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-4" for="userNote">Note</label>
                <div class="col-sm-8">
                  <textarea class="form-control" id="userNote" rows="3" v-model="form.note"></textarea>
                </div>
              </div>
              <hr>
              <div class="form-group row">
                <label class="col-form-label col-sm-4" for="userNote">Product</label>
                <div class="col-sm-8">
                  <div class="custom-controls-stacked">
                    <label class="custom-control custom-checkbox" v-for="product in products" :key="product.id">
                      <input type="checkbox" class="custom-control-input" name="products" :value="product.id" v-model="form.products">
                      <span class="custom-control-label">{{ product.value }}</span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-4" for="userNote">Channels</label>
                <div class="col-sm-8">
                  <div class="custom-controls-stacked">
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="channels" v-model="form.channels" value="1">
                      <span class="custom-control-label">Skype</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="channels" v-model="form.channels" value="2">
                      <span class="custom-control-label">Slack</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="channels" v-model="form.channels" value="3">
                      <span class="custom-control-label">Jira</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="channels" v-model="form.channels" value="4">
                      <span class="custom-control-label">Hotline</span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-4" for="userNote">Role</label>
                <div class="col-sm-8">
                  <div class="custom-controls-stacked">
                    <label class="custom-control custom-checkbox" v-for="role in teamRoles" :key="role.id">
                      <input type="checkbox" class="custom-control-input" name="roles" v-model="form.roles" :value="role.id">
                      <span class="custom-control-label">{{ role.value }}</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer d-flex">
              <button type="submit" class="btn btn-primary ml-auto">Save</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';

export default {
  data() {
    return {
      form: {
        name: '',
        status: 1,
        channels: [],
        roles: [],
        products: [],
        leader_id: 0,
      },
      selectedLeader: null,
    };
  },
  computed:{
    ...mapState({
      users: state => state.user.users,
      team: state => state.team.currentTeam,
    }),
    ...mapGetters(['products', 'teamRoles'])
  },
  watch: {
    selectedLeader() {
      this.form.leader_id = this.selectedLeader ? this.selectedLeader.id : 0;
    }
  },
  created() {
    const teamData = _.omit(this.team, ['created_at', 'created_at']);
    if (teamData.roles == null) {
      teamData.roles = [];
    }
    if (teamData.products == null) {
      teamData.products = [];
    }
    if (teamData.channels == null) {
      teamData.channels = [];
    }
    this.form = teamData;

    if (this.form.leader_id) {
      const user = this.users.find(user => user.id == this.form.leader_id);
      if (user) {
        this.selectedLeader = user;
      }
    }
  },
  methods: {
    editTeam() {
      axios.put(`/api/admin/teams/${this.form.id}`, this.form).then(response => {
        if (response.data.team) {
          this.$store.commit('updateCurrentTeam', response.data.team);
          this.$store.dispatch("alertSuccess", "Update team success");
        }
      });
    }
  }
};
</script>

