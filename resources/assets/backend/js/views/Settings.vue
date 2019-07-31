<template>
  <div id="settings">
    <div class="page-header">
      <h1 class="page-title">Settings</h1>
      <div class="page-options">
        <router-link to="/settings/add" class="btn btn-primary">Add Setting</router-link>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="selectgroup selectgroup-pills">
          <label class="selectgroup-item">
            <input type="checkbox" name="value" value="all" class="selectgroup-input" ref="checkboxAll" checked @change="changeAll">
            <span class="selectgroup-button">All</span>
          </label>
          <label class="selectgroup-item">
            <input type="checkbox" name="value" value="department" class="selectgroup-input" v-model="groups">
            <span class="selectgroup-button">Department</span>
          </label>
          <label class="selectgroup-item">
            <input type="checkbox" name="value" value="product" class="selectgroup-input" v-model="groups">
            <span class="selectgroup-button">Product</span>
          </label>
          <label class="selectgroup-item">
            <input type="checkbox" name="value" value="system" class="selectgroup-input" v-model="groups">
            <span class="selectgroup-button">System</span>
          </label>
          <label class="selectgroup-item">
            <input type="checkbox" name="value" value="source" class="selectgroup-input" v-model="groups">
            <span class="selectgroup-button">Source</span>
          </label>
          <label class="selectgroup-item">
            <input type="checkbox" name="value" value="issue_type" class="selectgroup-input" v-model="groups">
            <span class="selectgroup-button">Issue Type</span>
          </label>
          <label class="selectgroup-item">
            <input type="checkbox" name="value" value="error_type" class="selectgroup-input" v-model="groups">
            <span class="selectgroup-button">Error Type</span>
          </label>
          <label class="selectgroup-item">
            <input type="checkbox" name="value" value="team_role" class="selectgroup-input" v-model="groups">
            <span class="selectgroup-button">Team Role</span>
          </label>
          <label class="selectgroup-item">
            <input type="checkbox" name="value" value="tag" class="selectgroup-input" v-model="groups">
            <span class="selectgroup-button">Tag</span>
          </label>
          <label class="selectgroup-item">
            <input type="checkbox" name="value" value="other" class="selectgroup-input" v-model="groups">
            <span class="selectgroup-button">Other</span>
          </label>
        </div>
      </div>
    </div>
    <div class="card">
      <dimmer v-show="loading" />
      <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap">
          <thead>
            <tr>
              <th>Group</th>
              <th>Key</th>
              <th>Value</th>
              <th width="240">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="setting in settings" :key="setting.key + setting.group">
              <td>{{ getGroupText(setting.group) }}</td>
              <td>{{ setting.key }}</td>
              <td>{{ setting.value }}</td>
              <td>
                <router-link class="btn btn-secondary btn-sm" :to="{name:'edit-setting', params: { id: setting.id } }">Edit</router-link>
                <button class="btn btn-danger btn-sm" @click="confirmDeleteSetting(setting)">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="text-center mt-3" v-show="!loading && settings.length == 0">No Setting Found</p>
      <div class="card-footer">
        <pagination ref="settingPagination" :data="pagination" />
      </div>
    </div>
    <modal-confirm ref="modalConfirm" />
  </div>
</template>

<script>
const groupText = {
  department: 'Department',
  product: 'Product',
  system: 'System',
  source: 'Source',
  issue_type: 'Issue Type',
  error_type: 'Error Type',
  team_role: 'Team Role',
  tag: 'Tag',
  other: 'Other'
};
export default {
  data() {
    return {
      settings: [],
      pagination: {},
      loading: true,
      page: 0,
      groups: []
    };
  },
  mounted() {
    let page = parseInt(this.$route.query.page);
    if (!page || page < 1) {
      page = 1;
    }

    this.page = page;

    this.$refs.settingPagination.$on('goto_page', page => {
      this.page = page;
    });

    this.$refs.modalConfirm.$on('delete_setting_ok', setting => {
      this.deleteSetting(setting);
      this.$refs.modalConfirm.hide();
    });
  },
  watch: {
    page(value) {
      this.fetchSettings(this.page);
    },
    groups() {
      if (this.groups.length > 0) {
        this.$refs.checkboxAll.checked = false;
      }
      this.fetchSettings(1);
    }
  },
  methods: {
    changeAll(event) {
      if (event.target.checked) {
        this.groups = [];
      }
    },
    fetchSettings(page = 1) {
      this.loading = true;
      this.$router.push({ path: 'settings', query: { page: page } });
      axios
        .get(`/api/admin/settings?page=${page}`, {
          params: {
            groups: this.groups
          }
        })
        .then(response => {
          this.settings = response.data.data;

          let pagination = response.data;
          pagination = _.omit(pagination, ['data']);
          this.pagination = pagination;

          this.loading = false;
        })
        .catch(error => {
          this.loading = false;
        });
    },
    confirmDeleteSetting(setting) {
      this.$refs.modalConfirm.show(
        'delete_setting',
        'Are you sure to delete this setting?',
        setting
      );
    },
    deleteSetting(setting) {
      axios.get(`/api/admin/settings/${setting.id}/delete`).then(response => {
        if (response.data.success) {
          this.$store.dispatch('alertSuccess', 'Delete success!');
          if (this.settings.length == 1) {
            this.page = 1;
          } else {
            this.fetchSettings(this.page);
          }
        }
      });
    },
    getGroupText(key) {
      return groupText[key] ? groupText[key] : 'other';
    }
  }
};
</script>

