<template>
  <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-3 ml-auto d-none">
          <form class="input-icon my-3 my-lg-0">
            <input type="search" class="form-control header-search" placeholder="Search" tabindex="1">
            <div class="input-icon-addon">
              <i class="fe fe-search"></i>
            </div>
          </form>
        </div>
        <div class="col-lg order-lg-first">
          <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
            <li class="nav-item">
              <router-link to="/" class="nav-link" :class="{active: path == '/'}">
                <i class="fe fe-home"></i> Dashboard
              </router-link>
            </li>
            <li class="nav-item" v-if="hasPermission('view product')">
              <router-link :to="{name: 'products'}" class="nav-link" :class="{active: root == 'products'}">
                <i class="fe fe-grid"></i> Tin rao
              </router-link>
            </li>
            <!-- <li class="nav-item">
              <router-link :to="{name: 'categories'}" class="nav-link" :class="{active: root == 'categories'}">
                <i class="fe fe-grid"></i> Category
              </router-link>
            </li> -->
            <li class="nav-item" v-if="hasPermission('view post')">
              <router-link :to="{name: 'news'}" class="nav-link" :class="{active: root == 'news'}">
                <i class="fe fe-grid"></i> Tin tức
              </router-link>
            </li>
            <li class="nav-item" v-if="hasPermission('view subscriber')">
              <router-link to="/subscribers" class="nav-link" :class="{active: root == 'subscribers'}">
                <i class="fe fe-grid"></i> Subscribers
              </router-link>
            </li>
            <li class="nav-item dropdown" v-if="hasPermission('view user')">
              <a href="#" class="nav-link" :class="{active: root == 'users' || root=='bills'}"
                 data-toggle="dropdown">
                <i class="fe fe-users"></i> Khách hàng</a>
              <div class="dropdown-menu dropdown-menu-arrow">
                <router-link :to="{name: 'users'}" class="dropdown-item" :class="{active: root == 'users'}">
                  DS Khách hàng
                </router-link>
                <router-link to="/bills" v-if="hasPermission('manage bill')"
                             class="dropdown-item" :class="{active: root == 'bills'}">
                  Lịch sử giao dịch
                </router-link>
              </div>

            </li>
            <template v-if="hasPermission('view admin') && hasPermission('manage admin')">
              <li class="nav-item dropdown">
                <a href="#" class="nav-link" :class="{active: root == 'admins'}" data-toggle="dropdown">
                  <i class="fe fe-users"></i> Admins</a>
                <div class="dropdown-menu dropdown-menu-arrow">
                  <router-link :to="{name: 'admins'}" class="dropdown-item" :class="{active: path == '/admins'}">Admins</router-link>
                  <router-link :to="{name :'roles'}" class="dropdown-item" :class="{active: path == '/admins/roles'}">Roles</router-link>
                </div>
              </li>
            </template>
            <template v-else-if="hasPermission('view admin')">
              <li class="nav-item">
              <router-link :to="{name: 'admins'}" class="nav-link" :class="{active: root == 'admins'}">
                <i class="fe fe-users"></i> Admins
              </router-link>
            </li>
            </template>
            <li class="nav-item" v-if="hasPermission('manage setting')">
              <router-link to="/emails" class="nav-link" :class="{active: root == 'emails'}">
                <i class="fe fe-grid"></i> Emails
              </router-link>
            </li>
            <li class="nav-item" v-if="hasPermission('view log')">
              <router-link to="/logs" class="nav-link" :class="{active: root == 'logs'}">
                <i class="fe fe-grid"></i> Logs
              </router-link>
            </li>
            <li class="nav-item dropdown" v-if="hasPermission('manage setting')">
              <a href="#" class="nav-link" :class="{active: root == 'settings'}" data-toggle="dropdown">
                <i class="fe fe-settings"></i> Setting</a>
              <div class="dropdown-menu dropdown-menu-arrow">
                <router-link to="/settings" class="dropdown-item" :class="{active: path == '/settings'}">All</router-link>                
                <router-link to="/banner-setting" class="dropdown-item" :class="{active: path == '/banner-setting'}">Banners</router-link>
                <router-link to="/setting/category" class="dropdown-item" :class="{active: path == '/setting/category'}">Category</router-link>                
                <router-link to="/brands" class="dropdown-item" :class="{active: path == '/brands'}">Brands</router-link>
                <router-link to="/setting/seo-setting" class="dropdown-item" :class="{active: path == '/setting/seo-setting'}">Seo</router-link>
                <router-link to="/setting/seolink" class="dropdown-item" :class="{active: path == '/setting/seolink'}">Link Footer</router-link>
                <router-link to="/setting/robot" class="dropdown-item" :class="{active: path == '/setting/robot'}">Robot</router-link>
              </div>
            </li>
            <li class="nav-item dropdown" v-if="hasPermission('manage package')">
              <a href="#" class="nav-link" :class="{active: root == 'services' || root == 'campaign'}" data-toggle="dropdown">
                <i class="fe fe-dollar-sign"></i> Price & Campaign</a>
              <div class="dropdown-menu dropdown-menu-arrow">
                <router-link to="/day_options" class="dropdown-item"
                             :class="{active: path == '/day_options'}">Day Options</router-link>
                <router-link to="/services" class="dropdown-item" :class="{active: path == '/services'}">Gói dịch vụ</router-link>
                <router-link to="/services/add" class="dropdown-item" :class="{active: path == '/services/add'}">Thêm mới package</router-link>
                <router-link to="/campaign" class="dropdown-item" v-if="hasPermission('manage campaign')"
                             :class="{active: path == '/campaign'}">Chiến dịch</router-link>
                <router-link to="/campaign/add" class="dropdown-item"  v-if="hasPermission('manage campaign')"
                             :class="{active: path == '/campagin/add'}">Thêm mới chiến dịch</router-link>
              </div>
            </li>
            <li class="nav-item dropdown" v-if="hasPermission('manage class category')">
              <a href="#" class="nav-link" :class="{active: root == 'class_category' || root == 'product_category'}" data-toggle="dropdown">
                <i class="fe fe-menu"></i> Category</a>
              <div class="dropdown-menu dropdown-menu-arrow">
                <router-link to="/class_category" class="dropdown-item" :class="{active: path == '/class_category'}">Danh sách class cate</router-link>
                <router-link to="/class_category/add" class="dropdown-item" :class="{active: path == '/class_category/add'}">Thêm mới class cate</router-link>                          
                <router-link to="/product/category" class="dropdown-item" v-if="hasPermission('manage product')"
                             :class="{active: path == '/product/category'}">Danh sách category</router-link>
                <router-link to="/product/category/add" class="dropdown-item" v-if="hasPermission('manage product')"
                             :class="{active: path == '/product/category/add'}">Thêm mới category</router-link>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState, mapGetters } from 'vuex';
export default {
  computed: {
    ...mapState({
      path: state => state.common.route.path,
      user: state => state.auth.user
    }),
    ...mapGetters(['hasPermission']),
    root() {
      return _.split(this.path, '/')[1];
    }
  }
};
</script>