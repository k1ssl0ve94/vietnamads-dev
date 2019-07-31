<template>
  <div id="edit-member" class="row">
    <div class="col-lg-8 col-md-10 offset-lg-2 offset-md-1">
      <form action="" @submit.prevent="editMember">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Edit Member</h2>
          </div>
          <form-message/>
          <div class="card-body">
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Member</label>
              <div class="col-sm-8">
                <p>{{ member.id }} - {{ member.name }}</p>
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
      member: null,
      roles: [],
    };
  },
  computed:{
    ...mapState({
      team: state => state.team.currentTeam,
    }),
    ...mapGetters(['products', 'teamRoles'])
  },
  created() {
    this.member = this.team.members.find(member => member.id == this.$route.params.user_id);
    if (!this.member) {
      this.$router.push('/');
    }

    this.form = {
      user_id: this.member.id,
      role: this.member.pivot.role,
      products: JSON.parse(this.member.pivot.products),
    }

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
    editMember() {
      axios.post(`/api/admin/teams/${this.team.id}/members/update`, this.form).then(response => {
        if (response.data.team) {
          this.$store.commit('updateCurrentTeam', response.data.team);
        }

        if (response.data.success) {
          this.$store.dispatch('alertSuccess', 'Update Member successful!');
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
  }
}
</script>

