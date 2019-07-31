<template>
    <div id="campaign_page">
        <div class="page-header">
            <h1 class="page-title" v-if="form.id == ''">Add Class category</h1>
            <h1 class="page-title" v-else>Update Class category</h1>
            <div class="page-options"></div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Loại</label>
                            <select v-model="form.type"  class="form-control" >
                                <option value="1">Adviser</option>
                                <option value="2">Sponsor</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tên</label>
                            <input
                                    type="text"
                                    maxlength="200"
                                    class="form-control"
                                    placeholder="Độ dài tối đa 200"
                                    v-model="form.name"
                            >
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" v-model="form.category_id">
                                <option value="">- Select Category -</option>
                                <template v-if="metadata && metadata.product">
                                    <option
                                            v-for="item in metadata.product.category"
                                            :value="item.id"
                                            :key="item.id"
                                    >{{ item.name }}</option>abc
                                </template>
                            </select>
                        </div>
                        <div class="form-group" v-if="form.type == 1">
                            <label>Sub-category</label>
                            <select class="form-control" v-model="form.sub_category_id">
                                <option value="">Select Sub Category</option>
                                <option
                                        v-for="item in subCats"
                                        :value="item.id"
                                        :key="item.id"
                                >{{ item.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Contact name</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Contact name"
                                    v-model="form.contact_name"
                            >
                        </div>
                        <div class="form-group">
                            <label>Contact mobile</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Contact mobile"
                                    v-model="form.contact_mobile"
                            >
                        </div>
                        <div class="form-group">
                            <label>Meta title</label>
                            <input type="text" class="form-control" placeholder="Meta title" v-model="form.meta_title">
                        </div>
                        <div class="form-group">
                            <label>Meta keywords</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta keywords"
                                    v-model="form.meta_keywords"
                            >
                        </div>
                        <div class="form-group">
                            <label>Meta description</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta description"
                                    v-model="form.meta_description"
                            >
                        </div>
                        <div class="form-group">
                            <label>Meta canonical</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta canonical url"
                                    v-model="form.meta_canonical"
                            >
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea
                                    type="text"
                                    class="form-control"
                                    v-model="form.description"
                            ></textarea>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" v-model="form.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <button class="btn btn-link" @click.prevent="reset">Reset</button>
                        <button v-if="!form.id"
                                type="button"
                                class="btn btn-primary ml-auto"
                                @click.prevent="create"
                        >Create</button>
                        <button v-if="form.id"
                                type="button"
                                class="btn btn-primary ml-auto"
                                @click.prevent="update"
                        >Update</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="">
                        <div class="form-group">
                            <autocomplete
                                    ref="autocomplete"
                                    placeholder="Search product to add to class category"
                                    :source="getProductSuggestion"
                                    input-class="form-control"
                                    results-display="title"
                                    results-property="data"
                                    @selected="addProduct"
                                    :request-headers="authHeaders"
                            >
                            </autocomplete>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>~</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in products" :key="item.id">
                                    <td>{{item.id}}</td>
                                    <td>{{item.title}}</td>
                                    <td>
                                        <button class="btn btn-default"
                                            @click="removeProduct(index)"
                                            >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    name: '',
                    category_id: '',
                    sub_category_id: '',
                    type: 1,
                    contact_name: '',
                    contact_mobile: '',
                    id: '',
                    status: 1,
                    description: '',
                    meta_title: '',
                    meta_description: '',
                    meta_keywords: '',
                    meta_canonical: '',
                    productIds: []
                },
                products: [],
                metadata: {},
                defaultForm: {}
            };
        },
        created() {
            this.fetchMetaData();
            this.defaultForm = Object.assign({}, this.form);
            if (this.$route.params.id) {
                this.form.id = this.$route.params.id;
                this.loading = true;
                axios.get('/api/admin/class_category/detail/' + this.form.id).then(resp => {
                    this.form = resp.data;
                    this.defaultForm = Object.assign({}, resp.data);
                    this.products = resp.data.productArray;
                    this.updateProductIds();
                    this.loading = false;
                });
            }
        },
        watch: {
            // 'form.category_id': function() {
            //     if (this.form.category_id) {
            //         this.products.each(function(item, index) {
            //             if (item.category_parent != this.form.category_id) {
            //                 this.products.slice(index, 1);
            //             }
            //         });
            //     }
            //     this.updateProductIds();
            // },
            // 'form.sub_category_id': function() {
            //     if (this.form.sub_category_id) {
            //         this.products.each(function(item, index) {
            //             if (item.category != this.form.sub_category_id) {
            //                 this.products.slice(index, 1);
            //             }
            //         });
            //     }
            //     this.updateProductIds();
            // }
        },
        computed: {
            authHeaders(){
                return {
                    'Authorization': window.axios.defaults.headers.common['Authorization']
                }
            },
            subCats() {
                if (!this.form.category_id) {
                    return [];
                }
                if (!this.metadata || !this.metadata.category) {
                    return [];
                }
                return this.metadata.category.filter(cat => cat.parent_id == this.form.category_id);
            }
        },
        methods: {
            updateProductIds(){
                this.form.productIds = [];
                if (this.products) {
                    for(let i = 0; i < this.products.length; i++ ) {
                        this.form.productIds.push(this.products[i].id);
                    }
                }
                // console.log(this.form);
            },
            isAddProduct(item){
                for(var i = 0; i < this.products.length; i++ ) {
                    if (this.products[i].id === item.id) {
                        return true;
                    }
                }
                return false;
            },
            addProduct(item){
                if (this.isAddProduct(item.selectedObject)) {
                    alert('Product is existed.');
                } else {
                    this.products.push(item.selectedObject);
                    this.form.productIds.push(item.value);
                }
                this.$refs.autocomplete.clear();
            },
            removeProduct(index) {
                this.products.splice(index, 1);
                this.updateProductIds();
            },
            productDisplay(item) {
                return item.title;
            },
            getProductSuggestion(input){
                let query2 = '?keyword=' + input;
                if (this.form.category_id) {
                    query2 += '&category_id=' + this.form.category_id;
                }
                if (this.form.sub_category_id) {
                    query2 += '&sub_category_id=' + this.sub_category_id;
                }
                return process.env.MIX_APP_URL + '/api/admin/product/suggest' + query2;
            },
            fetchMetaData() {
                axios.get('/api/admin/product-data').then(resp => {
                    this.metadata = resp.data;
                });
            },
            reset() {
                this.form = Object.assign({}, this.defaultForm);
            },
            create() {
                axios
                    .post('/api/admin/class_category/create', this.form)
                    .then(resp => {
                        console.log(resp.data);
                        this.$store.dispatch('alertSuccess', 'Create success');
                        this.$router.push({
                            name: 'class_category'
                        });
                    })
                    .catch(err => {
                        console.log(err);
                        this.$store.dispatch('handleError', err);
                    });
            },
            update() {
                axios
                    .post('/api/admin/class_category/update', this.form)
                    .then(resp => {
                        console.log(resp.data);
                        this.$store.dispatch('alertSuccess', 'Update success');
                        this.$router.push({
                            name: 'class_category'
                        });
                    })
                    .catch(err => {
                        console.log(err);
                        this.$store.dispatch('handleError', err);
                    });
            }
        }
    };
</script>