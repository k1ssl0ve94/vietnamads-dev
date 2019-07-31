<template>
    <div id="class_Category">
        <div class="page-header">
            <h1 class="page-title">Product category</h1>
            <div class="page-options">
                <router-link
                        v-if="hasPermission('manage setting')"
                        class="btn btn-primary"
                        :to="{name: 'product_category_add'}"
                >Add new product category</router-link>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action @submit.prevent="search">
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <select class="form-control" v-model="form.parent_id">
                                <option value="">- Select Parent Category -</option>
                                <template v-if="metadata && metadata.product">
                                    <option
                                            v-for="item in metadata.product.category"
                                            :value="item.id"
                                            :key="item.id"
                                    >{{ item.name }}</option>
                                </template>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter keyword"
                                    v-model="form.keyword"
                            >
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
                        <th>Parent Category</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>English</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in items">
                        <td>{{item.id}}</td>
                        <td>{{item.parentCate.name}}</td>
                        <td>{{item.name}}</td>
                        <td>{{item.slug}}sdsd</td>
                        <td>
                            {{item.name_en}}<br/>
                            {{item.slug_en}}
                        </td>
                        <td>
                            <router-link
                                    class="fa fa-edit"
                                    :to="{name:'product_category_edit', params:{id: item.id}}"
                            ></router-link>
                            <router-link
                                    class="fa fa-remove"
                                    :to="{name:'product_category_delete', params:{id: item.id}}"
                            >Delete</router-link>                                                      
                        </td>
                    </tr> 
                    </tbody>
                </table>
            </div>
            <p class="text-center pt-3" v-if="items.length == 0">No product category found</p>
            <div class="card-footer d-flex">
                <span v-if="pagination">
                    Total:
                    <strong>{{ pagination.total }}</strong> product category
                </span>
                <pagination class="ml-auto" ref="itemPagination" :data="pagination"/>
            </div>
        </div>
        <modal-confirm ref="modalConfirm"/>

    </div>
</template>

<script>
    import { mapState, mapGetters } from 'vuex';

    export default {
        data() {
            return {
                items: [],
                pagination: {},
                form: {
                    keyword: '',
                    parent_id: ''
                },
                loading: true,
                page: 1,
                metadata: null,
                defaultForm: {},
                currentItem: null,
                currentStatus: '',
            };
        },
        filters: {

        },
        watch: {

        },
        computed: {
            ...mapGetters(['hasPermission']),
        },
        created() {
            this.defaultForm = Object.assign({}, this.form);
            let page = parseInt(this.$route.query.page);
            if (!page || page < 1) {
                page = 1;
            }

            this.fetchMetaData();

            this.fetchData(page);

            this.$store.dispatch('fetchSettings');
        },
        mounted() {
            this.$refs.itemPagination.$on('goto_page', page => {
                this.fetchData(page);
            });
        },
        methods: {
            parentCateNameFunc(parentId) {
                if (!parentId) {
                    return '';
                }
                if (this.metadata.product) {
                    let parentCate = this.metadata.product.category.filter(cat => cat.id == parentId);
                    if (parentCate) {
                        return parentCate.name;
                    }
                }
                return parentId;
            },
            search() {
                this.fetchData(1);
            },
            fetchData(page = 1) {
                this.loading = true;
                this.page = page;
                let params = Object.assign({}, this.form, { page });
                const query = _.map(params, (v, k) => {
                    return encodeURIComponent(k) + '=' + encodeURIComponent(v);
                }).join('&');

                axios.get(`/api/admin/categories?${query}`).then(response => {
                    this.items = response.data.data;
                    let pagination = response.data;
                    pagination = _.omit(pagination, ['data']);
                    this.pagination = pagination;
                    this.loading = false;
                });
            },
            resetFormSearch() {
                this.form = Object.assign({}, this.defaultForm);
                this.fetchData(1);
            },
            fetchMetaData() {
                axios.get('/api/admin/product-data').then(resp => {
                    this.metadata = resp.data;
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
