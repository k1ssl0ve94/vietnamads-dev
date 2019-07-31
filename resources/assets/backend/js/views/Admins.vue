<template>
  <div id="admins">
    <div class="page-header">
      <h1 class="page-title">Admins</h1>
      <div class="page-options">
        <router-link v-if="hasPermission('manage admin')" :to="{name:'add-admin'}" class="btn btn-primary">Add Admin</router-link>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <form action="" @submit.prevent="search">
          <div class="row">
            <div class="form-group col-sm-4">
              <input type="text" class="form-control" placeholder="Enter keyword" v-model="form.keyword">
            </div>
            <div class="form-group col-sm-2">
              <select class="form-control" v-model="form.role">
                <option value="">-- All Role --</option>
                <option :value="role.name" v-for="role in roles" :key="role.id">{{ role.name }}</option>
              </select>
            </div>
            <div class="form-group col-sm-2">
              <select class="form-control" v-model="form.status">
                <option value="">-- All Status --</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
            </div>
            <div class="form-group col-sm-2">
              <button type="submit" class="btn btn-primary btn-block">Search</button>
            </div>
            <div class="form-group col-sm-2">
              <button type="button" class="btn btn-link" @click.prevent="resetFormSearch">Reset</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="card">
      <dimmer v-show="loading" />
      <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td>{{ user.id }}</td>
              <td>{{ user.name }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.roles[0] ? user.roles[0].name : '' }}</td>
              <td>{{ user.status ? 'Active' : 'Inactive' }}</td>
              <td>
                <router-link v-if="hasPermission('manage admin')" class="btn btn-secondary btn-sm" :to="{name:'edit-admin', params:{id: user.id}}">Edit</router-link>
                <button v-if="hasPermission('manage admin')" class="btn btn-danger btn-sm" @click.prevent="confirmDelete(user)">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="text-center pt-3" v-if="users.length == 0">No user found</p>
      <div class="card-footer d-flex">
        <span v-if="pagination">Total: <strong>{{ pagination.total }}</strong> admins</span>
        <pagination class="ml-auto" ref="userPagination" :data="pagination" />
      </div>
    </div>
    <modal-confirm ref="modalConfirm" />
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';

export default {
  data() {
    return {
      users: [],
      pagination: {},
      form: {
        keyword: '',
        role: '',
        status: '',
        group: 1,
      },
      loading: true,
      page: 0,
    }
  },
  computed: {
    ...mapGetters(['hasPermission']),
    ...mapState({
      roles: state => state.common.roles,
    }),
  },
  created() {
    let page = parseInt(this.$route.query.page);
    if (!page || page < 1) {
      page = 1;
    }

    this.fetchUsers(page);

    this.$store.dispatch('fetchSettings');
  },
  mounted() {
    this.$refs.userPagination.$on('goto_page', (page) => {
      this.fetchUsers(page);
    })

    this.$refs.modalConfirm.$on('delete_user_ok', (user) => {
      this.delete(user);
      this.$refs.modalConfirm.hide();
    });
  },
  methods: {
    search() {
      this.fetchUsers(1);
    },
    resetFormSearch() {
      this.form = {
        keyword: '',
        role: '',
        status: '',
        group: 1,
      };
      this.fetchUsers(1);
    },
    fetchUsers(page = 1) {
      this.loading = true;
      this.page = page;
      let params = Object.assign({}, this.form, {page});
      const query = _.map(params,(v,k) => {
        return encodeURIComponent(k) + '=' + encodeURIComponent(v);
      }).join('&');

      axios.get(`/api/admin/users?${query}`).then(response => {
        this.users = response.data.data;

        let pagination = response.data;
        pagination = _.omit(pagination, ['data']);
        this.pagination = pagination;

        this.loading = false;
      });
    },
    confirmDelete(user) {
      this.$refs.modalConfirm.show('delete_user', 'Are you sure to delete this user?', user);
    },
    delete(user) {
      axios.delete(`/api/admin/admins/${user.id}`).then(response => {
        if (response.data.success) {
          this.$store.dispatch("alertSuccess", "Delete success!");
          if (this.users.length == 1) {
            this.fetchUsers(1);
          } else {
            this.fetchUsers(this.page);
          }
        }
      });
    }
  }
}
</script>