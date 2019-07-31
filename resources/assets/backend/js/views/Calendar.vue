<template>
  <div id="calendar">
    <div class="page-header">
      <h1 class="page-title">Teams</h1>
      <div class="page-options" v-if="hasPermission('manage calendar')">
        <router-link :to="{name: 'add-team'}" class="btn btn-primary">Add Team</router-link>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <form action="" @submit.prevent="search">
          <div class="row">
            <div class="form-group col-sm-3">
              <input type="text" class="form-control" placeholder="Enter keyword" v-model="form.keyword">
            </div>
            <div class="form-group col-sm-3">
              <select class="form-control" v-model="form.product">
                <option value="">-- All Products --</option>
                <option v-for="p in products" :key="p.id" :value="p.id">{{ p.value }}</option>
                <!-- <option v-for="dep in departments" :key="dep.id" :value="dep.id">{{ dep.value }}</option> -->
              </select>
            </div>
            <div class="form-group col-sm-2">
              <select class="form-control" v-model="form.status">
                <option value="">-- All Status --</option>
                <option value="1">Active</option>
                <option value="2">Inactive</option>
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
              <th>Leader</th>
              <th>Products</th>
              <th>Channels</th>
              <th>Status</th>
              <th width="240">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="team in teams" :key="team.id">
              <td>{{ team.id }}</td>
              <td>
                <router-link :to="'/calendar/' + team.id +'/schedule'">{{ team.name }}</router-link>
              </td>
              <td>
                <template v-if="team.leader">
                  <router-link :to="'/users/' + team.leader.id">{{ team.leader.name }}</router-link>
                </template>
                <template v-else>N/A</template>
              </td>
              <td>
                <div v-for="(productId, index) in team.products" :key="index">
                  {{ getProductNameById(productId) }}
                </div>
              </td>
              <td>
                <div v-for="(channel, index) in team.channels" :key="index">
                  <template v-if="channel == 1">Skype</template>
                  <template v-else-if="channel == 2">Slack</template>
                  <template v-else-if="channel == 3">Jira</template>
                  <template v-else-if="channel == 4">Hotline</template>
                </div>
              </td>
              <td>
                <template v-if="team.status == 1">Active</template>
                <template v-else>Inactive</template>
              </td>
              <td>
                <router-link :to="'/calendar/'+team.id+'/schedule'" class="btn btn-secondary btn-sm">
                  <i class="fe fe-eye"></i>
                </router-link>
                <router-link :to="'/calendar/'+team.id+'/info'" class="btn btn-secondary btn-sm">
                  <i class="fe fe-edit"></i>
                </router-link>
                <button class="btn btn-danger btn-sm" @click.prevent="confirmDelete(team)">
                  <i class="fe fe-trash-2"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <p class="text-center mt-2" v-if="teams.length == 0">No Team.</p>
      </div>
      <div class="card-footer">
        <pagination ref="teamPagination" :data="pagination" />
      </div>
    </div>
    <modal-confirm ref="modalConfirm" />
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex';

export default {
  data() {
    return {
      form: {
        keyword: '',
        product: '',
        status: ''
      },
      teams: [],
      loading: false,
      page: 1,
      pagination: {}
    };
  },
  computed: {
    ...mapState({
      team: state => state.team.currentTeam
    }),
    ...mapGetters(['products', 'hasPermission'])
  },
  created() {
    this.fetchTeam();
    this.$store.dispatch('fetchSettings');
  },
  mounted() {
    this.$refs.teamPagination.$on('goto_page', page => {
      this.fetchTeam(page);
    });

    this.$refs.modalConfirm.$on('delete_team_ok', user => {
      this.delete(user);
      this.$refs.modalConfirm.hide();
    });
  },
  methods: {
    search() {
      this.fetchTeam(1);
    },
    resetFormSearch() {
      this.form = {
        keyword: '',
        product: '',
        status: ''
      };
      this.fetchTeam(1);
    },
    fetchTeam(page = 1) {
      this.page = page;
      this.loading = true;

      let params = Object.assign({}, this.form, { page });
      const query = _.map(params, (v, k) => {
        return encodeURIComponent(k) + '=' + encodeURIComponent(v);
      }).join('&');

      axios
        .get(`/api/admin/teams?${query}`)
        .then(response => {
          this.teams = response.data.data;

          let pagination = response.data;
          pagination = _.omit(pagination, ['data']);
          this.pagination = pagination;

          this.loading = false;
        })
        .catch(error => {
          this.loading = false;
        });
    },
    getProductNameById(id) {
      const product = this.products.find(product => product.id == id);
      if (product) {
        return product.value;
      }
      return '';
    },
    confirmDelete(team) {
      this.$refs.modalConfirm.show('delete_team', 'Are you sure to delete this Team?', team);
    },
    delete(team) {
      axios.delete(`/api/admin/teams/${team.id}`).then(response => {
        if (response.data.success) {
          this.$store.dispatch('alertSuccess', 'Delete success!');
          if (this.teams.length == 1) {
            this.fetchTeam(1);
          } else {
            this.fetchTeam(this.page);
          }
        }
      });
    }
  }
};
</script>

