<template>
  <div id="categories">
    <div class="page-header">
      <h1 class="page-title">Categories</h1>
      <div class="page-options">
        <router-link class="btn btn-primary" :to="{name: 'add-category'}">Add Category</router-link>
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
              <select class="form-control" v-model="form.parent_id">
                <option value="">-- All Parent --</option>
                <option value="1">Sự kiện</option>
                <option value="2">Phân tích, nhận định</option>
                <option value="3">Chia sẻ kinh nghiệm</option>
                <option value="4">Thương hiệu, sản phẩm</option>
                <option value="5">Chính sách, quản lý</option>
                <option value="6">Thông báo</option>
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
              <th>Parent</th>
              <th>Total Product</th>
              <th>Created at</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="cat in categories" :key="cat.id">
              <td>{{ cat.id }}</td>
              <td>{{ cat.name }}</td>
              <td>{{ cat.parent_id }}</td>
              <td>{{ 999 }}</td>
              <td>{{ cat.created_at }}</td>
              <td>
                <router-link class="btn btn-secondary btn-sm" :to="{name:'edit-post', params:{id: cat.id}}">Edit</router-link>
                <button class="btn btn-danger btn-sm" @click.prevent="confirmDelete(cat)">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="text-center pt-3" v-if="categories.length == 0">No category found</p>
      <div class="card-footer d-flex">
        <span v-if="pagination">Total: <strong>{{ pagination.total }}</strong> categories</span>
        <pagination class="ml-auto" ref="catPagination" :data="pagination" />
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
      categories: [],
      pagination: {},
      form: {
        keyword: '',
        status: '',
        parent_id: '',
      },
      loading: true,
      page: 1,
    }
  },
  filters: {
    formatTitle (value) {
      let l = 40
      if (value.length < l) {
        return value;
      }
      return value.substring(0, l) + '...';
    },
    formatCat (value) {
      const cats = {
        '1': 'Sự kiện',
        '2': 'Phân tích, nhận định',
        '3': 'Chia sẻ kinh nghiệm',
      };
      return cats[value];
    }
  },
  computed: {
  },
  created() {
    let page = parseInt(this.$route.query.page);
    if (!page || page < 1) {
      page = 1;
    }

    this.fetchCategories(page);
  },
  mounted() {
    this.$refs.catPagination.$on('goto_page', (page) => {
      this.fetchCategories(page);
    })

    this.$refs.modalConfirm.$on('delete_category_ok', (cat) => {
      this.delete(cat);
      this.$refs.modalConfirm.hide();
    });
  },
  methods: {
    search() {
      this.fetchCategories(1);
    },
    fetchCategories(page = 1) {
      this.loading = true;
      this.page = page;
      let params = Object.assign({}, this.form, {page});
      const query = _.map(params,(v,k) => {
        return encodeURIComponent(k) + '=' + encodeURIComponent(v);
      }).join('&');

      axios.get(`/api/admin/categories?${query}`).then(response => {
        this.categories = response.data.data;
        let pagination = response.data;
        pagination = _.omit(pagination, ['data']);
        this.pagination = pagination;
        this.loading = false;
      });
    },
    resetFormSearch() {
      this.form = {
        keyword: '',
        status: '',
        cat: '',
      };
      this.fetchCategories(1);
    },
    confirmDelete(cat) {
      this.$refs.modalConfirm.show('delete_category', 'Are you sure to delete this category?', cat);
    },
    delete(cat) {
      axios.delete(`/api/admin/categories/${cat.id}`).then(response => {
        if (response.data.success) {
          this.$store.dispatch("alertSuccess", "Delete success!");
          if (this.categories.length == 1) {
            this.fetchCategories(1);
          } else {
            this.fetchCategories(this.page);
          }
        }
      });
    }
  }
};
</script>