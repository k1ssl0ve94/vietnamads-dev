<template>
  <div id="add-user" class="row">
    <div class="col-lg-6 col-md-8 offset-lg-3 offset-md-2">
      <form action="" @submit.prevent="addAdmin">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Add Admin</h2>
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
              <label class="col-form-label col-sm-4">Email</label>
              <div class="col-sm-8">
                <input type="email" class="form-control" name="email" v-model="form.email" required>
              </div>
            </div>
            <div class="form-group row" v-if="form.role <= 2">
              <label class="col-form-label col-sm-4">Password</label>
              <div class="col-sm-8">
                <input type="password" class="form-control" name="password" v-model="form.password" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Phone number</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="phone" v-model="form.phone" required>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-8 offset-sm-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="checkActive" v-model="form.status">
                  <label class="form-check-label" for="checkActive">Active</label>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex">
            <router-link to="/admins" class="btn btn-link">Cancel</router-link>
            <button type="submit" class="btn btn-primary ml-auto">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        phone: '',
        role: 0,
        status: true,
      },
    };
  },
  created() {
    this.$store.dispatch('fetchSettings');
  },
  mounted() {
    if (this.roles.length > 0) {
      this.form.role = this.roles[0].id;
    }
  },
  methods: {
    addAdmin() {
      axios.post('/api/admin/users', this.form).then(response => {
        if (response.data.user) {
          this.resetFormData();
          this.$store.dispatch("alertSuccess", "Add new user success");
          this.$router.push({name:'admins'});
        } else {
          this.$store.dispatch("formErrors", ["Error!!"]);
        }
      });
    },
    resetFormData() {
      this.form = {
        name: '',
        email: '',
        password: '',
        phone: '',
        role: 0,
        status: true,
      };
    }
  }
}
</script>

