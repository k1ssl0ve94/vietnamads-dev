<template>
  <div id="news">
    <div class="page-header">
      <h1 class="page-title">News</h1>
      <div class="page-options">
        <router-link v-if="hasPermission('manage post')" class="btn btn-primary" :to="{name: 'add-post'}">Add Post</router-link>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <form action="" @submit.prevent="search">
          <div class="row">
            <div class="form-group col-sm-3">
              <input type="text" class="form-control" placeholder="Enter keyword" v-model="form.keyword">
            </div>
            <div class="form-group col-sm-2">
              <select class="form-control" v-model="form.cat">
                <option value="">-- All Categories --</option>
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
              <select class="form-control" v-model="form.lang">
                <option value="">-- Select Language --</option>
                <option value="0">Vietnamese</option>
                <option value="1">English</option>
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
              <th>Image</th>
              <th>Title</th>
              <th>Status</th>
              <th>Category</th>
              <th>Hot</th>
              <th>Created at</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="post in posts" :key="post.id">
              <td>{{ post.id }}</td>
              <td>
                <img :src="post.image_url" class="post-thumb-preview" v-if="post.image_url">
                <img src="/imgs/img_placeholder.png" v-else>
              </td>
              <td>
                <div>{{ post.title | formatTitle }}</div>
                <div><small>{{ post.lang_text }}</small></div>
              </td>
              <td>{{ post.status ? 'Active' : 'Inactive' }}</td>
              <td>{{ post.cat | formatCat }}</td>
              <td>
                <span class="badge badge-warning" v-if="post.hot == '1'">Hot</span>
              </td>
              <td>{{ post.created_at }}</td>
              <td>
                <router-link v-if="hasPermission('manage post')" class="btn btn-secondary btn-sm" :to="{name:'edit-post', params:{id: post.id}}">Edit</router-link>
                <button v-if="hasPermission('manage post')" class="btn btn-danger btn-sm" @click.prevent="confirmDelete(post)">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="text-center pt-3" v-if="posts.length == 0">No post found</p>
      <div class="card-footer d-flex">
        <span v-if="pagination">Total: <strong>{{ pagination.total }}</strong> posts</span>
        <pagination class="ml-auto" ref="postPagination" :data="pagination" />
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
      posts: [],
      pagination: {},
      form: {
        keyword: '',
        status: '',
        cat: '',
        lang: '',
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
    ...mapGetters(['hasPermission']),
  },
  created() {
    let page = parseInt(this.$route.query.page);
    if (!page || page < 1) {
      page = 1;
    }

    this.fetchPosts(page);

    this.$store.dispatch('fetchSettings');
  },
  mounted() {
    this.$refs.postPagination.$on('goto_page', (page) => {
      this.fetchPosts(page);
    })

    this.$refs.modalConfirm.$on('delete_post_ok', (post) => {
      this.delete(post);
      this.$refs.modalConfirm.hide();
    });
  },
  methods: {
    search() {
      this.fetchPosts(1);
    },
    fetchPosts(page = 1) {
      this.loading = true;
      this.page = page;
      let params = Object.assign({}, this.form, {page});
      const query = _.map(params,(v,k) => {
        return encodeURIComponent(k) + '=' + encodeURIComponent(v);
      }).join('&');

      axios.get(`/api/admin/posts?${query}`).then(response => {
        this.posts = response.data.data;
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
      this.fetchPosts(1);
    },
    confirmDelete(post) {
      this.$refs.modalConfirm.show('delete_post', 'Are you sure to delete this post?', post);
    },
    delete(post) {
      axios.delete(`/api/admin/posts/${post.id}`).then(response => {
        if (response.data.success) {
          this.$store.dispatch("alertSuccess", "Delete success!");
          if (this.posts.length == 1) {
            this.fetchPosts(1);
          } else {
            this.fetchPosts(this.page);
          }
        }
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.post-thumb-preview {
  max-height: 60px;
}
</style>
