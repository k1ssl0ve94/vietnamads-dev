<style lang="scss" scoped>
.card-table tr td:first-child,
.card-table tr th:first-child {
  padding-left: 0.5rem;
}
.table th,
.text-wrap table th,
.table td,
.text-wrap table td {
  padding: 0.4rem 0.3rem;
}

.table .btn {
  padding: 0.25rem;
  i {
    font-size: 0.8rem;
  }
}

#issues {
  font-size: 0.9rem;
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
  <div id="issues">
    <div class="page-header">
      <h1 class="page-title">Tickets</h1>
      <div class="page-options">
        <button type="button" class="btn btn-link" @click.prevent="downloadExport">Export</button>
        <a href="#" id="btn-download-export" target="_blank" class="d-none">btn</a>
        <router-link to="/tickets/add" class="btn btn-primary" v-if="hasPermission('add ticket')">Add Ticket</router-link>
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
              <multiselect v-model="selectedAssignee" track-by="id" label="name" placeholder="Select a Assignee" :options="users" :searchable="true" :allow-empty="true">
                <template slot="singleLabel" slot-scope="{ option }">{{ option.id }} - {{ option.name }}</template>
                <template slot="option" slot-scope="{ option }">{{ option.id }} - {{ option.name }}</template>
              </multiselect>
            </div>
            <div class="form-group col-sm-2">
              <select class="form-control" v-model="form.source">
                <option value="">-- All Source --</option>
                <option v-for="source in sources" :key="source.id" :value="source.id">{{ source.value }}</option>
              </select>
            </div>
            <div class="form-group col-sm-2">
              <select class="form-control" v-model="form.error_type">
                <option value="">-- All Error Type --</option>
                <option :value="t.id" v-for="t in errorTypes" :key="t.id">{{ t.value }}</option>
              </select>
            </div>
            <div class="form-group col-sm-2">
              <select class="form-control" v-model="form.product">
                <option value="">-- All Product --</option>
                <option :value="product.id" v-for="product in products" :key="product.id">{{ product.value }}</option>
              </select>
            </div>
            <div class="form-group col-sm-2">
              <select class="form-control" v-model="form.system">
                <option value="">-- All System --</option>
                <option :value="system.id" v-for="system in systems" :key="system.id">{{ system.value }}</option>
              </select>
            </div>
            <div class="form-group col-sm-2">
              <select class="form-control" v-model="form.issue_type">
                <option value="">-- All Issue Type --</option>
                <option :value="t.id" v-for="t in issueTypes" :key="t.id">{{ t.value }}</option>
              </select>
            </div>
            <div class="form-group col-sm-2">
              <select class="form-control" v-model="form.status">
                <option value="">-- All Status --</option>
                <option value="1">Open</option>
                <option value="2">Closed</option>
                <option value="3">Pending</option>
                <option value="4">Buy Off</option>
                <option value="5">Under Repair</option>
                <option value="6">Cancel</option>
              </select>
            </div>
            <div class="form-group col-sm-2">
              <select class="form-control" v-model="form.order">
                <option value="1">Newest</option>
                <option value="2">Oldest</option>
              </select>
            </div>
            <div class="form-group col-sm-2">
              <button type="submit" class="btn btn-primary btn-block">Search</button>
            </div>
            <div class="form-group col-sm-2">
              <button type="button" class="btn btn-secondary btn-block" @click.prevent="resetFormSearch">Reset</button>
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
              <th>Title</th>
              <th>Status</th>
              <th>Remain time</th>
              <th>Assignee</th>
              <th>Order By</th>
              <th>Source</th>
              <th>Channel</th>
              <th>Error Type</th>
              <th>System</th>
              <th>Product</th>
              <th>Type</th>
              <th>Deadline</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="issue in issues" :key="issue.id" @click="view(issue)">
              <td v-if="issue.code">
                <a href="#" @click.stop="preview(issue)">{{ issue.code }}-{{ issue.id }}</a>

              </td>
              <td v-else>
                <a href="#" @click.stop="preview(issue)">{{ issue.id }}</a>
              </td>
              <td>{{ issue.title }}</td>
              <td>
                <template v-if="issue.status == 1">
                  <span class="badge badge-open">Open - LT1</span>
                </template>
                <template v-else-if="issue.status == 2">
                  <span class="badge badge-close">Close - LT8</span>
                </template>
                <template v-else-if="issue.status == 3">
                  <span class="badge badge-danger">Pending - LT2B</span>
                </template>
                <template v-else-if="issue.status == 4">
                  <span class="badge badge-buy-off">Buy Off - LT5</span>
                </template>
                <template v-else-if="issue.status == 5">
                  <span class="badge badge-under-repair">Under repair - LT2A</span>
                </template>
                <template v-else-if="issue.status == 6">
                  <span class="badge badge-cancel">Cancel</span>
                </template>
              </td>
              <td>{{ issue.downtime }}</td>
              <td>{{ issue.assignee ? issue.assignee.name : '' }}</td>
              <td>{{ issue.created_email }}</td>
              <td>{{ issue.source ? issue.source.value : '' }}</td>
              <td>{{ issue.channel }}</td>
              <td>{{ issue.error_type ? issue.error_type.value : '' }}</td>
              <td>{{ issue.system ? issue.system.value : '' }}</td>
              <td>{{ issue.product ? issue.product.value : '' }}</td>
              <td>{{ issue.type ? issue.type.value : '' }}</td>
              <td>{{ issue.deadline }}</td>
              <td>
                <router-link class="btn btn-secondary btn-sm" :to="{name:'edit-issue', params:{id: issue.id}}" v-if="hasPermission('edit ticket')">
                  <i class="fe fe-edit"></i>
                </router-link>
                <button class="btn btn-danger btn-sm" @click.prevent.stop="confirmDelete(issue)" v-if="hasPermission('edit ticket')">
                  <i class="fe fe-trash-2"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="text-center pt-3" v-if="issues.length == 0">No issue found</p>
      <div class="card-footer d-flex">
        <p>Total: {{ pagination.total }} tickets</p>
        <div class="ml-auto">
          <pagination ref="issuePagination" :data="pagination" />
        </div>
      </div>
    </div>
    <modal-confirm ref="modalConfirm" />
    <modal-preview-issue ref="modalPreview" />
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
import ModalPreviewIssue from '../components/ModalPreviewIssue';

export default {
  components: {
    ModalPreviewIssue
  },
  data() {
    return {
      issues: [],
      pagination: {},
      form: {
        keyword: '',
        source: '',
        system: '',
        product: '',
        error_type: '',
        issue_type: '',
        status: '',
        order: 1,
        assignee_id: 0
      },
      selectedAssignee: null,
      loading: true,
      page: 0
    };
  },
  computed: {
    ...mapState({
      roles: state => state.common.roles,
      users: state => state.user.users
    }),
    ...mapGetters(['sources', 'products', 'systems', 'issueTypes', 'errorTypes', 'hasPermission']),
    query() {
      let params = Object.assign({}, this.form);
      const query = _.map(params, (v, k) => {
        return encodeURIComponent(k) + '=' + encodeURIComponent(v);
      }).join('&');
      return query;
    }
  },
  watch: {
    selectedAssignee() {
      this.form.assignee_id = this.selectedAssignee ? this.selectedAssignee.id : 0;
    }
  },
  created() {
    let page = parseInt(this.$route.query.page);
    if (!page || page < 1) {
      page = 1;
    }

    if (this.$route.query.status) {
      this.form.status = this.$route.query.status;
    }

    this.fetchIssues(page);
  },
  filters: {
    chunkContent: function(content) {
      const maxLength = 30;
      if (content.length > maxLength) {
        return `${content.substring(0, maxLength)}...`;
      }
      return content;
    }
  },
  mounted() {
    this.$refs.issuePagination.$on('goto_page', page => {
      this.fetchIssues(page);
    });

    this.$refs.modalConfirm.$on('delete_issue_ok', user => {
      this.delete(user);
      this.$refs.modalConfirm.hide();
    });
  },
  methods: {
    search() {
      this.fetchIssues(1);
    },
    view(issue) {
      if (!this.hasPermission('edit ticket') && !this.hasPermission('view detail ticket')) {
        return;
      }
      this.$router.push({
        name: 'edit-issue',
        params: { id: issue.id }
      });
    },
    resetFormSearch() {
      this.form = {
        keyword: '',
        source: '',
        system: '',
        product: '',
        error_type: '',
        issue_type: '',
        status: '',
        order: 1,
        assignee_id: 0
      };
      this.selectedAssignee = null;
      this.fetchIssues(1);
    },
    fetchIssues(page = 1) {
      this.loading = true;
      this.page = page;
      let params = Object.assign({}, this.form, { page });
      const query = _.map(params, (v, k) => {
        return encodeURIComponent(k) + '=' + encodeURIComponent(v);
      }).join('&');

      axios.get(`/api/admin/issues?${query}`).then(response => {
        this.issues = response.data.data;

        let pagination = response.data;
        pagination = _.omit(pagination, ['data']);
        this.pagination = pagination;

        this.loading = false;
      });
    },
    confirmDelete(issue) {
      this.$refs.modalConfirm.show('delete_issue', 'Are you sure to delete this issue?', issue);
    },
    delete(issue) {
      axios.delete(`/api/admin/issues/${issue.id}`).then(response => {
        if (response.data.success) {
          this.$store.dispatch('alertSuccess', 'Delete success!');
          if (this.issues.length == 1) {
            this.fetchIssues(1);
          } else {
            this.fetchIssues(this.page);
          }
        }
      });
    },
    downloadExport() {
      axios.get(`/api/admin/issues/download-token?${this.query}`).then(response => {
        $('#btn-download-export')
          .attr('href', response.data.token)
          .trigger('click');
        window.location = `/export-issue?token=${response.data.token}`;
      });
    },
    preview(issue) {
      console.log(issue);
      this.$refs.modalPreview.show(issue);
    }
  }
};
</script>