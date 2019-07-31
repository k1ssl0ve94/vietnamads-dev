<style lang="scss" scoped>
#roles {
  .card {
    min-height: 60px;
  }
}
</style>
<template>
  <div id="roles">
    <div class="page-header">
      <h1 class="page-title">Roles</h1>
      <div class="page-options">
        <!-- <router-link class="btn btn-primary" :to="{name: 'add-role'}">Add Role</router-link> -->
      </div>
    </div>
    <div class="card">
      <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Users count</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="role in roles" :key="role.id">
              <td>{{ role.id }}</td>
              <td>{{ role.name }}</td>
              <td>{{ role.users_count }}</td>
              <td>
                <!-- <router-link class="btn btn-secondary btn-sm" :to="{ name: 'edit-role', params: { id: role.id }}">Edit</router-link>
                <button class="btn btn-danger btn-sm" @click="confirmDelete(role)">Delete</button> -->
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <modal-confirm ref="modalConfirm" />
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  computed: {
    ...mapState({
      roles: state => state.common.roles
    })
  },
  mounted() {
    this.$refs.modalConfirm.$on('delete_role_ok', (role) => {
      this.delete(role);
      this.$refs.modalConfirm.hide();
    });
  },
  methods: {
    confirmDelete(role) {
      this.$refs.modalConfirm.show('delete_role', 'Are you sure to delete this role? All users of this role will be deleted', role);
    },
    delete(role) {
      axios.delete(`/api/admin/roles/${role.id}`).then(response => {
        if (response.data.success) {
          this.$store.dispatch("alertSuccess", "Delete success!");
          this.$store.dispatch('fetchRolesAndPermissions');
        }
      });
    }
  }
};
</script>