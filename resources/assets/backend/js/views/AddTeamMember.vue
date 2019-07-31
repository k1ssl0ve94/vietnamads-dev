<template>
  <div id="add-member" class="row">
    <div class="col-lg-8 col-md-10 offset-lg-2 offset-md-1">
      <form action="" @submit.prevent="addMember">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Add Member</h2>
          </div>
          <form-message/>
          <div class="card-body">
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Member</label>
              <div class="col-sm-8">
                <multiselect v-model="selectedMember" track-by="id" label="name" placeholder="Select a Member" :options="users" :searchable="true" :allow-empty="true">
                  <template slot="singleLabel" slot-scope="{ option }">{{ option.id }} - {{ option.name }}</template>
                  <template slot="option" slot-scope="{ option }">{{ option.id }} - {{ option.name }}</template>
                </multiselect>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Team Role</label>
              <div class="col-sm-8">
                <select class="form-control" v-model="form.role">
                  <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.value }}</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-4" for="userNote">Product</label>
                <div class="col-sm-8">
                  <div class="custom-controls-stacked">
                    <label class="custom-control custom-checkbox" v-for="id in team.products" :key="id">
                      <input type="checkbox" class="custom-control-input" name="products" :value="id" v-model="form.products">
                      <span class="custom-control-label">{{ getProductNameById(id) }}</span>
                    </label>
                  </div>
                </div>
              </div>
          </div>
          <div class="card-footer d-flex">
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
        user_id: 0,
        role: 0,
        products: [],
      },
      selectedMember: null,
      roles: [],
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
    selectedMember() {
      this.form.user_id = this.selectedMember ? this.selectedMember.id : 0;
    }
  },
  created() {
    this.teamRoles.forEach(role => {
      if (this.team.roles.includes(role.id)) {
        this.roles.push(role);
      }
    });

    if (this.roles.length > 0) {
      this.form.role = this.roles[0].id;
    }
  },
  methods: {
    addMember() {
      if (this.form.user_id == 0) {
        this.$store.dispatch('formErrors', ['Please select a user']);
        return;
      }

      axios.post(`/api/admin/teams/${this.team.id}/members`, this.form).then(response => {
        if (response.data.team) {
          this.$store.commit('updateCurrentTeam', response.data.team);
        }

        if (response.data.success) {
          this.resetFormData();
          this.$store.dispatch("alertSuccess", "Add Member successful!");
          this.$router.push(`/calendar/${this.team.id}/members`);
        }
      });
    },
    getProductNameById(id) {
      const product = this.products.find(product => product.id == id);
      if (product) {
        return product.value;
      }
      return '';
    },
    resetFormData() {
      this.form = {
        user_id: 0,
        role: 0,
        products: [],
      };

      if (this.roles.length > 0) {
        this.form.role = this.roles[0].id;
      }
    }
  }
}
</script>

