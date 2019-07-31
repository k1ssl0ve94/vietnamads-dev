<template>
  <div id="add-user" class="row">
    <div class="col-lg-6 col-md-8 offset-lg-3 offset-md-2">
      <form action="" @submit.prevent="submit">
        <div class="card">
          <dimmer v-show="loading"/>
          <div class="card-header">
            <h2 class="card-title">Edit Setting</h2>
          </div>
          <form-message/>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Group</label>
                  <select class="form-control" v-model="form.group">
                    <option value="department">Department</option>
                    <option value="product">Product</option>
                    <option value="system">System</option>
                    <option value="source">Source</option>
                    <option value="issue_type">Issue Type</option>
                    <option value="error_type">Error Type</option>
                    <option value="team_role">Team Role</option>
                    <option value="tag">Tag</option>
                    <option value="other">Other</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Key</label>
                  <input class="form-control" required v-model="form.key">
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label class="form-control-label">Value</label>
                  <input class="form-control" required v-model="form.value">
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex">
            <router-link class="btn btn-link" to="/settings">Cancel</router-link>
            <button type="submit" class="btn btn-primary ml-auto">Save Setting</button>
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
      id: 0,
      form: {
        key: '',
        value: '',
        group: 'department'
      },
      loading: true
    };
  },
  mounted() {
    this.id = this.$route.params.id;

    this.fetchSetting();
  },
  methods: {
    fetchSetting() {
      this.loading = true;
      axios
        .get(`/api/admin/settings/${this.id}`)
        .then(response => {
          this.loading = false;

          this.form = response.data.setting;
        })
        .catch(error => {
          this.loading = false;
        });
    },
    submit() {
      axios.post(`/api/admin/settings/${this.id}`, this.form).then(response => {
        if (response.data.setting) {
          this.$store.dispatch('formSuccess', 'Update Setting success');
        } else {
          this.$store.dispatch('formErrors', ['Error!!']);
        }
      });
    }
  }
};
</script>