<style lang="scss" scoped>
#team-member {
  tbody {
    tr {
      cursor: pointer;
      &:hover {
        background-color: #f4f4f4;
      }
    }
  }
}
</style>

<template>
  <div id="team-member">
    <router-link :to="'/calendar/'+id+'/add-member'" class="btn btn-primary mb-3">Add member</router-link>
    <div class="card">
      <div class="card-body">
        <form action="" @submit.prevent="search">
          <div class="row">
            <div class="form-group col-sm-3">
              <input type="text" class="form-control" placeholder="Enter keyword" v-model="form.keyword">
            </div>
            <div class="form-group col-sm-2">
              <select class="form-control" v-model="form.product">
                <option value="">-- All product --</option>
                <option v-for="id in team.products" :key="id" :value="id">{{ getProductNameById(id) }}</option>
              </select>
            </div>
            <div class="form-group col-sm-2">
              <select class="form-control" v-model="form.role">
                <option value="">-- All Role --</option>
                <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.value }}</option>
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

    <p class="text-center" v-show="filteredMember.length == 0">No members!</p>
    <table class="table table-bordered" v-if="filteredMember.length > 0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Role</th>
          <th>Product</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in filteredMember" :key="user.id" @click.self="view(user)">
          <td>{{ user.id }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.phone }}</td>
          <td>{{ getRoleNameById(user.pivot.role) }}</td>
          <td v-html="productIdsToText(user.pivot.products)"></td>
          <td>
            <router-link :to="'/calendar/'+ id +'/members/' + user.id" class="btn btn-secondary btn-sm">
              <i class="fe fe-edit"></i>
            </router-link>
            <router-link :to="'/users/'+user.id" class="btn btn-secondary btn-sm">
              <i class="fe fe-eye"></i>
            </router-link>
            <button class="btn btn-danger btn-sm" @click.prevent.stop="confirmDelete(user)">
              <i class="fe fe-trash-2"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <modal-confirm ref="modalConfirm" />
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';

export default {
  data() {
    return {
      id: this.$route.params.id,
      form: {
        keyword: '',
        product: '',
        role: ''
      },
      searchParams: {},
      roles: []
    };
  },
  computed: {
    ...mapState({
      members: state => state.team.currentTeam.members,
      team: state => state.team.currentTeam
    }),
    ...mapGetters(['products', 'teamRoles']),
    filteredMember() {
      let members = this.members;

      if (this.searchParams.keyword) {
        const keyword = this.searchParams.keyword
          .toLowerCase()
          .normalize('NFD')
          .replace(/[\u0300-\u036f]/g, '');
        members = members.filter(m => {
          const name = m.name
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '');
          const email = m.email.toLowerCase();
          return email.includes(keyword) || m.id == keyword || name.includes(keyword) || (m.phone && m.phone.includes(keyword));
        });
      }

      if (this.searchParams.product) {
        const productId = parseInt(this.searchParams.product, 10);
        members = members.filter(m => {
          const ids = JSON.parse(m.pivot.products);
          if (ids && ids.includes(productId)) {
            return true;
          }
          return false;
        });
      }

      if (this.searchParams.role) {
        const roleId = parseInt(this.searchParams.role, 10);
        members = members.filter(m => m.pivot.role == roleId);
      }

      return members;
    }
  },
  created() {
    this.teamRoles.forEach(role => {
      if (this.team.roles.includes(role.id)) {
        this.roles.push(role);
      }
    });
  },
  mounted() {
    this.$refs.modalConfirm.$on('delete_member_ok', member => {
      this.delete(member);
      this.$refs.modalConfirm.hide();
    });
  },
  methods: {
    confirmDelete(member) {
      this.$refs.modalConfirm.show('delete_member', 'Are you sure to remove this member?', member);
    },
    delete(member) {
      axios.get(`/api/admin/teams/${this.id}/members/${member.id}/delete`).then(response => {
        if (response.data.success) {
          this.$store.dispatch('alertSuccess', 'Delete success!');
        }

        if (response.data.team) {
          this.$store.commit('updateCurrentTeam', response.data.team);
        }
      });
    },
    search() {
      console.log('search');
      this.searchParams = Object.assign({}, this.form);
    },
    resetFormSearch() {
      this.form = {
        keyword: '',
        product: '',
        role: ''
      };
      this.searchParams = {};
    },
    getRoleNameById(id) {
      const role = this.teamRoles.find(role => role.id == id);

      if (role) {
        return role.value;
      }

      return '';
    },
    productIdsToText(value) {
      const ids = JSON.parse(value);
      const names = [];
      this.products.forEach(p => {
        if (ids.includes(p.id)) {
          names.push(p.value);
        }
      });

      return names.join('<br>');
    },
    getProductNameById(id) {
      const product = this.products.find(product => product.id == id);
      if (product) {
        return product.value;
      }
      return '';
    },
    view(user) {
      this.$router.push('/calendar/' + this.id + '/members/' + user.id);
    }
  }
};
</script>

