<template>
  <div id="add-role" class="row">
    <div class="col-lg-6 col-md-8 offset-lg-3 offset-md-2">
      <form action="" @submit.prevent="submit">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Add Role</h2>
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
                  <input class="form-check-input" type="checkbox" value="all" id="defaultCheck1" v-model="form.permissions">
                  <label class="form-check-label" for="defaultCheck1">All</label>
                </div>
                <div class="form-check" v-for="per in permissions" :key="per.id">
                  <input class="form-check-input" type="checkbox" :value="per.name" :id="'permission_'+per.id" v-model="form.permissions">
                  <label class="form-check-label" :for="'permission_'+per.id">{{ per.name }}</label>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex">
            <router-link class="btn btn-link" to="/admins/roles">Cancel</router-link>
            <button type="submit" class="btn btn-primary ml-auto">Add Role</button>
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
      }
    }
  },
  computed: {
    ...mapState({
      permissions: state => state.common.permissions,
    })
  },
  methods: {
    resetForm() {
      this.form = {
        name: '',
        permissions: [],
      };
    },
    submit() {
      axios.post('/api/admin/roles', this.form).then(response => {
        if (response.data.role) {
          this.resetForm();
          this.$store.dispatch("alertSuccess", "Add Role success");
          this.$router.push({name:'roles'});
        } else {
          this.$store.dispatch("formErrors", ["Error!!"]);
        }
      });
    }
  }
}
</script>