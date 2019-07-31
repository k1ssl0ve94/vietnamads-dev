<template>
    <div id="class_Category">
        <div class="page-header">
            <h1 class="page-title">Class category</h1>
            <div class="page-options">
                <router-link
                        v-if="hasPermission('manage setting')"
                        class="btn btn-primary"
                        :to="{name: 'class_category_add'}"
                >Add new</router-link>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action @submit.prevent="search">
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <select class="form-control" v-model="form.type">
                                <option value="">Select Type</option>
                                <option value="1">Adviser</option>
                                <option value="2">Sponsor</option>
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
                        <div class="form-group col-sm-2">
                            <select class="form-control" v-model="form.category_id">
                                <option value="">- Select Category -</option>
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
                            <select class="form-control" v-model="form.sub_category_id">
                                <option value="">- Select Sub Category -</option>
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
                                <option value="2">Inactive</option>
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
                        <th>Type</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Total product</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in items">
                        <td>{{item.id}}</td>
                        <td>{{item.typeLabel}}</td>
                        <td>{{item.name}}</td>
                        <td>
                            <div>{{item.category}}</div>
                            <span class="badge badge-info" v-if="item.subCategory">
                                {{item.subCategory}}
                            </span>
                        </td>
                        <td class="text-center">{{item.total_products | numFormat}}</td>
                        <td>
                            <div v-if="item.contact_name">{{item.contact_name}}</div>
                            <span v-if="item.contact_mobile" class="badge badge-info">
                                {{item.contact_mobile}}</span>
                        </td>
                        <td>
                            {{item.statusLabel}}
                        </td>
                        <td>
                            <router-link
                                    class="fa fa-edit"
                                    :to="{name:'class_category_edit', params:{id: item.id}}"
                            ></router-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <p class="text-center pt-3" v-if="items.length == 0">No class category found</p>
            <div class="card-footer d-flex">
                <span v-if="pagination">
                    Total:
                    <strong>{{ pagination.total }}</strong> class category
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
                    status: '',
                    sub_category_id: '',
                    category_id: '',
                    type: ''
                },
                loading: true,
                page: 1,
                metadata: null,
                defaultForm: {},
                currentItem: null,
                currentStatus: '',
                note: '',
                servicePackages: [],
            };
        },
        filters: {
            formatStatus(value) {
                switch (value) {
                    case 1:
                        return 'Active';
                        break;
                    case 2:
                        return 'InActive';
                        break;
                }
            }
        },
        watch: {
            'form.category_parent': function() {
                this.form.category = '';
            }
        },
        computed: {
            ...mapGetters(['hasPermission']),
            subCats() {
                if (!this.form.category_id) {
                    return [];
                }
                if (!this.metadata) {
                    return [];
                }
                return this.metadata.category.filter(cat => cat.parent_id == this.form.category_id);
            }
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

                axios.get(`/api/admin/class_category?${query}`).then(response => {
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
            },
            confirmChangeStatus(item, status) {
                this.currentItem = item;
                this.currentStatus = status;
                // $('#modal-note-status').modal('show');
            },
            changeStatus(item, status, note = '') {

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
