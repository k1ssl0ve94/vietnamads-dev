<template>
  <div id="add-team" class="row">
    <div class="col-lg-6 col-md-8 offset-lg-3 offset-md-2">
      <form action="" @submit.prevent="addTeam">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Add Team</h2>
          </div>
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
            <router-link to="/calendar" class="btn btn-link">Cancel</router-link>
            <button type="submit" class="btn btn-primary ml-auto">Submit</button>
          </div>
        </div>
      </form>
    </div>
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
        note: '',
        channels: [],
        roles: [],
        products: [],
        leader_id: 0
      },
      selectedLeader: null
    };
  },
  computed: {
    ...mapState({
      users: state => state.user.users
    }),
    ...mapGetters(['products', 'teamRoles'])
  },
  watch: {
    selectedLeader() {
      this.form.leader_id = this.selectedLeader ? this.selectedLeader.id : 0;
    }
  },
  methods: {
    addTeam() {
      axios.post('/api/admin/teams', this.form).then(response => {
        if (response.data.team) {
          this.resetFormData();
          this.$store.dispatch('alertSuccess', 'Add new team success');
          this.$router.push('/calendar');
        } else {
          this.$store.dispatch('formErrors', ['Error!!']);
        }
      });
    },
    resetFormData() {
      this.form = {
        name: '',
        status: 1,
        note: '',
        channels: [],
        roles: [],
        products: [],
        leader_id: 0
      };
    }
  }
};
</script>

