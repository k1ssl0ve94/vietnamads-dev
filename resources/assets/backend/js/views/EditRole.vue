<template>
  <div id="edit-role" class="row">
    <div class="col-lg-6 col-md-8 offset-lg-3 offset-md-2">
      <form action="" @submit.prevent="submit">
        <div class="card">
          <dimmer v-show="loading" />
          <div class="card-header">
            <h2 class="card-title">Edit Role</h2>
          </div>
          <form-message />
          <div class="card-body">
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Name</label>
              <div class="col-sm-8">
                <input class="form-control" v-model="form.name" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Permissions</label>
              <div class="col-sm-8">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="all" id="permissionAll" v-model="form.permissions">
                  <label class="form-check-label" for="permissionAll">All</label>
                </div>
                <div class="form-check" v-for="per in permissions" :key="per.id">
                  <input class="form-check-input" type="checkbox" :value="per.name" :id="'permission_'+per.id" v-model="form.permissions">
                  <label class="form-check-label" :for="'permission_'+per.id">{{ per.name }}</label>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex">
            <router-link class="btn btn-link" to="/users/roles">Cancel</router-link>
            <button type="submit" class="btn btn-primary ml-auto">Update Role</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  data() {
    return {
      form: {
        name: '',
        permissions: [],
      },
      loading: true,
      id: 0
    }
  },
  computed:{
    ...mapState({
      permissions: state => state.common.permissions,
      roles: state => state.common.roles,
    })
  },
  created () {
    this.id = this.$route.params.id;
    this.fetchRole();
  },
  methods: {
    fetchRole() {
      axios.get(`/api/admin/roles/${this.id}`).then(response => {
        const { role } = response.data;
        this.form = {
          name: role.name,
          permissions: role.permissions,
        };
        this.loading = false;
      }).catch(error => {
        this.loading = false;
      });
    },
    submit() {
      axios.put(`/api/admin/roles/${this.id}`, this.form).then(response => {
        if (response.data.role) {
          this.$store.commit('updateRole', { id: this.id, name: this.form.name });
          this.$store.dispatch("formSuccess", "Update Role success");
        } else {
          this.$store.dispatch("formErrors", ["Error!!"]);
        }
      });
    }
  }
}
</script>