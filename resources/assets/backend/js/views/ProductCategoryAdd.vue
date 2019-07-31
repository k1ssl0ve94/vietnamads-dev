<template>
    <div id="campaign_page">
        <div class="page-header">
            <h1 class="page-title" v-if="form.id == ''">Add Product category</h1>
            <h1 class="page-title" v-else>Update Product category</h1>
            <div class="page-options"></div>
        </div>
        <div class="row">
            <div class="col-md-8 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div  v-if="errors.length" class="alert alert-danger">
                            <p v-for="error in errors">
                                {{error}}
                            </p>
                        </div>
                        <div class="form-group">
                            <label>Parent Category (*)</label>
                            <select class="form-control" v-model="form.parent_id">
                                <option value="0">Trống</option>
                                <template v-if="metadata && metadata.product">
                                    <option
                                            v-for="item in metadata.product.category"
                                            :value="item.id"
                                            :key="item.id"
                                    >{{ item.name }}</option>
                                </template>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Name (*)</label>
                            <input
                                    type="text"
                                    maxlength="200"
                                    class="form-control"
                                    placeholder="Độ dài tối đa 200"
                                    v-model="form.name"
                            >
                        </div>
                        <div class="form-group">
                            <label>Slug (*)</label>
                            <input
                                    type="text"
                                    maxlength="200"
                                    class="form-control"
                                    placeholder="Độ dài tối đa 200"
                                    v-model="form.slug"
                            >
                        </div>

                        <div class="form-group">
                            <label>Name (English) (*)</label>
                            <input
                                    type="text"
                                    maxlength="200"
                                    class="form-control"
                                    placeholder="Độ dài tối đa 200"
                                    v-model="form.name_en"
                            >
                        </div>
                        <div class="form-group">
                            <label>Slug (English) (*)</label>
                            <input
                                    type="text"
                                    maxlength="200"
                                    class="form-control"
                                    placeholder="Độ dài tối đa 200"
                                    v-model="form.slug_en"
                            >
                        </div>
                        <div class="form-group">
                            <label>Meta title </label>
                            <input type="text" class="form-control" placeholder="Meta title" v-model="form.meta_title">
                        </div>                    
                        <div class="form-group">
                            <label>Meta keywords (*)</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta keywords"
                                    v-model="form.meta_keywords" required
                            >
                        </div>
                        <div class="form-group">
                            <label>Meta canonical (*)</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta canonical url"
                                    v-model="form.meta_canonical" required
                            >
                        </div>
                        <div class="form-group">
                            <label>Meta description (*)</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta description"
                                    v-model="form.meta_description" required
                            >
                        </div>
                        <div class="form-group">
                            <label>Top Description</label>
                            <textarea class="form-control" rows="8" v-model="form.description"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Bottom Description</label>
                            <textarea class="form-control summernote" rows="8" v-model="form.content"></textarea>
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
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    name: '',
                    parent_id: '',
                    slug: '',
                    name_end: '',
                    slug_en: '',
                    description: '',
                    content:'',
                    meta_title: '',
                    meta_description: '',
                    meta_keywords: '',
                    meta_canonical: '',
                    id: ''
                },
                metadata: {},
                defaultForm: {},
                errors: []
            };
        },
        created() {
            this.fetchMetaData();
            this.defaultForm = Object.assign({}, this.form);                    
            if (this.$route.params.id) {
                this.form.id = this.$route.params.id;
                this.loading = true;
                axios.get('/api/admin/categories/' + this.form.id).then(resp => {
                    //console.log(resp.data);
                    this.form = resp.data;                            
                    this.initSummerNote();
                    this.defaultForm = Object.assign({}, resp.data);
                    this.loading = false;
                });
            }
        },
        mounted() {
            //this.initSummerNote();
        },        
        watch: {

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
            fetchMetaData() {
                axios.get('/api/admin/product-data').then(resp => {
                    this.metadata = resp.data;
                });
            },
            reset() {
                this.form = Object.assign({}, this.defaultForm);
            },
            initSummerNote() {
                const $vm = this;
                $(document).ready(function() {
                    $('.summernote').summernote({
                        imageTitle: {
                          specificAltField: true,
                        },
                        popover: {
                          image: [
                            ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['remove', ['removeMedia']],
                            ['custom', ['imageTitle']],
                          ],
                        },
                        height: 300,
                        toolbar: [
                            ['font1', ['style', 'clear']],
                            ['font2', ['bold', 'underline', 'italic', 'fontsize']],
                            ['color', ['color', 'forecolor', 'backcolor']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture', 'video']],
                            ['view', ['fullscreen', 'codeview']]
                        ],
                        callbacks: {
                            onChange: (contents, $editable) => {
                                $vm.form.content = contents;
                            },
                            onImageUpload: function(files) {
                                $vm.uploadFile(files[0], false, function(img) {
                                    $('.summernote').summernote('insertImage', img.url);
                                });
                            }
                        }
                    });
                });
            },
            fileChange() {
                this.uploadFile(this.$refs.fileUpload.files[0], true);
            },
            uploadFile(file, isThumb, callback) {
                const form = new FormData();
                form.append('file', file);
                form.append('folder', 'posts');
                if (isThumb) {
                    form.append('thumb', '1');
                }

                const config = {
                    onUploadProgress: progressEvent => {
                        this.percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    }
                };

                this.isUploading = true;

                axios
                    .post('/api/admin/upload', form, config)
                    .then(response => {
                        if (response.data.success) {
                            if (callback) {
                                callback(response.data.file);
                            } else {
                                this.form.image = response.data.file;
                            }
                        }
                        this.$refs.fileUpload.value = '';
                        this.isUploading = false;
                    })
                    .catch(error => {
                        this.isUploading = false;
                        this.$refs.fileUpload.value = '';
                        if (callback) {
                            callback(null);
                        }
                    });
            },
            removeImage() {
                this.form.image = '';
                this.form.image_url = '';
            },                        
            create() {
                this.errors = [];
                axios
                    .post('/api/admin/categories', this.form)
                    .then(resp => {
                        console.log(resp.data);
                        this.$store.dispatch('alertSuccess', 'Create success');
                        this.$router.push({
                            name: 'product_category'
                        });
                    })
                    .catch(err => {
                        this.errors = ['Invalid data'];
                        this.$store.dispatch('formErrors', [err.response.data.message]);
                        this.$store.dispatch('handleError', err);
                    });
            },
            update() {
                this.errors = [];
                axios
                    .put('/api/admin/categories/' + this.form.id, this.form)
                    .then(resp => {
                        this.$store.dispatch('alertSuccess', 'Update success');
                        this.$router.push({
                            name: 'product_category'
                        });
                    })
                    .catch(err => {
                        // console.log(err.response.data.errors);
                        this.errors = ['Invalid data'];
                        console.log(this.errors);
                        this.$store.dispatch('formErrors', [err.response.data.message]);
                        this.$store.dispatch('handleError', err);
                    });
            }
        }
    };
</script>