<template>
  <div id="edit-user" class="row">
    <div class="col-lg-6 col-md-8 offset-lg-3 offset-md-2">
      <form action="" @submit.prevent="editUser">
        <div class="card">
          <dimmer v-show="loading"/>
          <div class="card-header">
            <h2 class="card-title">Edit User</h2>
          </div>
          <form-message/>
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
                <input type="password" class="form-control" name="password" v-model="form.password" placeholder="Enter here to change password">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Mobile</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="phone" v-model="form.phone">
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
            <div class="form-group row">
              <div class="col-sm-8 offset-sm-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="activated" v-model="form.activated">
                  <label class="form-check-label" for="activated">Kích hoạt tài khoản?</label>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-8 offset-sm-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="verified_by_admin" v-model="form.verified_by_admin">
                  <label class="form-check-label" for="verified_by_admin">Tài khoản được xác minh?</label>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex">
            <router-link to="/users" class="btn btn-link">Cancel</router-link>
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
        status: true,
        activated: false,
        verified_by_admin: false
      },
      loading: true
    };
  },
  created() {
    this.id = this.$route.params.id;
    this.fetchUser();
  },
  methods: {
    fetchUser() {
      this.loading = true;
      axios
        .get(`/api/admin/users/${this.id}`)
        .then(response => {
          this.loading = false;
          this.form = response.data.user;
        })
        .catch(error => {
          this.loading = false;
        });
    },
    editUser() {
      axios.post(`/api/admin/users/${this.id}`, this.form).then(response => {
        if (response.data.success) {
          this.$store.dispatch('formSuccess', 'Update user success');
          window.scrollTo(0, 0);
        } else {
          this.$store.dispatch('formErrors', ['Error!!']);
        }
      });
    }
  }
};
</script>

