<template>
    <div id="products">
        <div class="page-header">
            <h1 class="page-title">Tin rao</h1>
            <div class="page-options">
                <router-link
                    v-if="hasPermission('manage product')"
                    class="btn btn-primary"
                    :to="{name: 'add-product'}"
                >Add Product</router-link>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action @submit.prevent="search">
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Enter keyword"
                                v-model="form.keyword"
                            >
                        </div>
                        <div class="form-group col-sm-2">
                            <select class="form-control" v-model="form.category_parent">
                                <option value>Select Category</option>
                                <template v-if="metadata && metadata.product">
                                    <option
                                        v-for="item in metadata.product.category"
                                        :value="item.id"
                                        :key="item.id"
                                    >{{ item.name }}</option>abc
                                </template>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <select class="form-control" v-model="form.category">
                                <option value>Select Sub Category</option>
                                <option
                                    v-for="item in subCats"
                                    :value="item.id"
                                    :key="item.id"
                                >{{ item.name }}</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <select class="form-control" v-model="form.status">
                                <option value>Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Disabled</option>
                                <option value="0">Pending</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <select
                                    class="form-control"
                                    id="package_value"
                                    name="level"
                                    v-model="form.level"
                            >
                                <option value>Select Package</option>
                                <option
                                        v-for="spackage in servicePackages"
                                        :value="spackage.id"
                                        :key="spackage.id"
                                >
                                    {{spackage.name}}
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <select class="form-control" v-model="form.user_level">
                                <option value="">-- User level --</option>
                                <option value="1">Normal</option>
                                <option value="2">VIP</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <select class="form-control" v-model="form.user_type">
                                <option value="">-- User type --</option>
                                <option value="1">Customer</option>
                                <option value="2">Agency</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <select class="form-control" v-model="form.lang">
                                <option value="">-- Select Language --</option>
                                <option value="0">Vietnamese</option>
                                <option value="1">English</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Search</button>
                        </div>
                        <div class="form-group">
                            <button
                                type="button"
                                class="btn btn-link"
                                @click.prevent="resetFormSearch"
                            >Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <dimmer v-show="loading"/>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Level</th>
                            <th v-if="hasPermission('manage product')">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products" :key="product.id">
                            <td>
                                <div>{{ product.id }}</div>
                                <small>{{ product.user ? product.user.name : '' }}</small><br/>
                                <span class="badge badge-danger" v-if="product.user && product.user.level == 2">VIP</span>
                                <span class="badge badge-primary" v-if="product.user && product.user.type == 2">Agency</span>
                            </td>
                            <td>
                                <div>
                                    <a
                                        :href="product.product_url+'?token='+user_token"
                                        target="_blank"
                                    >{{ product.title | formatTitle }}</a>
                                </div>
                                <div><small>{{ product.lang_text }}</small></div>
                            </td>
                            <td>
                                {{ product.category_parent_text }}
                                <div>- {{ product.category_text }}</div>
                            </td>
                            <td>
                                <div>{{ product.from | formatDate }}
                                    <span class="fa fa-angle-double-right"></span>
                                    {{ product.to | formatDate }}</div>
                                <div><small>Create: {{ product.created_at }}</small></div>
                            </td>
                            <td>
                                <span
                                    v-if="product.status == 0"
                                    class="badge badge-secondary"
                                >Pending</span>
                                <span
                                    v-else-if="product.status == 1"
                                    class="badge badge-success"
                                >Active</span>
                                <span
                                    v-else-if="product.status == 2"
                                    class="badge badge-dark"
                                >Disabled</span>
                            </td>
                            <td>
                                <span v-if="product.service">
                                    {{product.service.name}}
                                </span>
                            </td>
                            <td v-if="hasPermission('manage product')">
                                <router-link
                                    class="btn btn-secondary btn-sm"
                                    :to="{name:'edit-product', params:{id: product.id}}"
                                >Edit</router-link>
                                <div class="dropdown">
                                    <button
                                        class="btn btn-secondary btn-sm dropdown-toggle"
                                        type="button"
                                        id="dropdownMenuButton"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >Status</button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a
                                            class="dropdown-item"
                                            href="#"
                                            @click.prevent="changeStatus(product, 0)"
                                            v-if="product.status != 0"
                                        >Pending</a>
                                        <a
                                            class="dropdown-item"
                                            href="#"
                                            @click.prevent="changeStatus(product, 1)"
                                            v-if="product.status != 1"
                                        >Active</a>
                                        <a
                                            class="dropdown-item"
                                            href="#"
                                            @click.prevent="confirmChangeStatus(product, 2)"
                                            v-if="product.status != 2"
                                        >Disabled</a>
                                    </div>
                                </div>
                                <button
                                    class="btn btn-danger btn-sm"
                                    @click.prevent="confirmDelete(product)"
                                >Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="text-center pt-3" v-if="products.length == 0">No product found</p>
            <div class="card-footer d-flex">
                <span v-if="pagination">
                    Total:
                    <strong>{{ pagination.total }}</strong> products
                </span>
                <pagination class="ml-auto" ref="productPagination" :data="pagination"/>
            </div>
        </div>
        <modal-confirm ref="modalConfirm"/>
        <div class="modal fade" id="modal-note-status" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Note</label>
                            <textarea class="form-control" rows="4" v-model="note"></textarea>
                            <p>Hãy note cho user biết lí do disable, thông tin liên lạc, etc,...</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click.prevent="changeStatus(currentProduct, currentStatus, note)">Continue</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';

export default {
    data() {
        return {
            products: [],
            pagination: {},
            form: {
                keyword: '',
                status: '',
                category_parent: '',
                category: '',
                level: '',
                user_level: '',
                user_type: '',
                lang: '',
            },
            loading: true,
            page: 1,
            metadata: null,
            defaultForm: {},
            currentProduct: null,
            currentStatus: '',
            note: '',
            servicePackages: [],
        };
    },
    filters: {
        formatStatus(value) {
            switch (value) {
                case 0:
                    return 'Pending';
                    break;
                case 1:
                    return 'Active';
                    break;
                case 2:
                    return 'Disabled';
                    break;
            }
        },
        formatTitle(value) {
            let l = 40;
            if (value.length < l) {
                return value;
            }
            return value.substring(0, l) + '...';
        },
        formatLevel(value) {
            if (value == 2) {
                return 'VIP';
            }
            return 'normal';
        },
        formatDate(value) {
            if (!value) {
                return '';
            }
            return value.split(' ')[0];
        }
    },
    watch: {
        'form.category_parent': function() {
            this.form.category = '';
        }
    },
    computed: {
        ...mapGetters(['hasPermission']),
        ...mapState({
            user_token: state => state.auth.user_token,
        }),
        subCats() {
            if (!this.form.category_parent) {
                return [];
            }
            if (!this.metadata) {
                return [];
            }
            return this.metadata.category.filter(cat => cat.parent_id == this.form.category_parent);
        }
    },
    created() {
        this.defaultForm = Object.assign({}, this.form);
        let page = parseInt(this.$route.query.page);
        if (!page || page < 1) {
            page = 1;
        }

        this.fetchMetaData();

        this.fetchProducts(page);

        this.$store.dispatch('fetchSettings');
    },
    mounted() {
        this.$refs.productPagination.$on('goto_page', page => {
            this.fetchProducts(page);
        });

        this.$refs.modalConfirm.$on('delete_product_ok', product => {
            this.delete(product);
            this.$refs.modalConfirm.hide();
        });
    },
    methods: {
        search() {
            this.fetchProducts(1);
        },
        fetchProducts(page = 1) {
            this.loading = true;
            this.page = page;
            let params = Object.assign({}, this.form, { page });
            const query = _.map(params, (v, k) => {
                return encodeURIComponent(k) + '=' + encodeURIComponent(v);
            }).join('&');

            axios.get(`/api/admin/products?${query}`).then(response => {
                this.products = response.data.data;
                let pagination = response.data;
                pagination = _.omit(pagination, ['data']);
                this.pagination = pagination;
                this.loading = false;
            });
        },
        resetFormSearch() {
            this.form = Object.assign({}, this.defaultForm);
            this.fetchProducts(1);
        },
        confirmDelete(product) {
            this.$refs.modalConfirm.show('delete_product', 'Are you sure to delete this product?', product);
        },
        delete(product) {
            axios.delete(`/api/admin/products/${product.id}`).then(response => {
                if (response.data.success) {
                    this.$store.dispatch('alertSuccess', 'Delete success!');
                    if (this.products.length == 1) {
                        this.fetchProducts(1);
                    } else {
                        this.fetchProducts(this.page);
                    }
                }
            });
        },
        fetchMetaData() {
            axios.get('/api/admin/product-data').then(resp => {
                this.metadata = resp.data;
            });
            this.getServicePackages();
        },
        getServicePackages() {
            axios.get('/api/admin/services?addProduct=1').then(resp => {
                this.servicePackages = resp.data.items;
            });
        },
        confirmChangeStatus(product, status) {
            this.currentProduct = product;
            this.currentStatus = status;
            this.note = product.note;
            $('#modal-note-status').modal('show');
        },
        changeStatus(product, status, note = '') {
            $('#modal-note-status').modal('hide');
            this.products.forEach(p => {
                if (p.id == product.id) {
                    p.status = status;
                }
            });
            axios
                .put(`/api/admin/products/${product.id}/status`, { status, note })
                .then(resp => {
                    console.log(resp.data);
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
};
</script>

<style lang="scss" scoped>
.product-thumb-preview {
    max-height: 60px;
}
.table th,
.text-wrap table th,
.table td,
.text-wrap table td {
    padding: 0.4rem;
}
.card-table tr td:first-child,
.card-table tr th:first-child {
    padding-left: 0.5rem;
}
</style>
