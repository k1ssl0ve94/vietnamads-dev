<template>
    <div id="brands">
        <div class="page-header">
            <h1 class="page-title">Brands</h1>
            <div class="page-options"></div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create Brand</h3>
                    </div>
                    <form-message/>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Enter brand name here"
                                v-model="form.name"
                            >
                        </div>
                        <div class="form-group">
                            <label>Url</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Enter url"
                                v-model="form.url"
                            >
                        </div>
                        <div class="form-group">
                            <label>logo</label>
                            <div class="img-preview" v-if="logo_preview">
                                <img :src="logo_preview">
                            </div>
                            <div class="custom-file" v-show="!isUploading">
                                <input
                                    type="file"
                                    class="custom-file-input"
                                    name="example-file-input-custom"
                                    ref="fileUpload"
                                    @change="fileChange"
                                >
                                <label class="custom-file-label">Choose file</label>
                            </div>
                            <p v-if="isUploading">Uploading: {{ percentCompleted }}%</p>
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <button class="btn btn-link" @click.prevent="reset">Reset</button>
                        <button
                            type="button"
                            class="btn btn-primary ml-auto"
                            @click.prevent="create"
                        >Create</button>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group">
                            <draggable
                                v-model="brands"
                                :options="{draggable:'.list-group-item'}"
                                @start="drag=true"
                                @end="drag=false"
                                @update="checkUpdate"
                            >
                                <li class="list-group-item" v-for="brand in brands" :key="brand.id">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img :src="brand.logo_url" class="brand-logo">
                                        </div>
                                        <div class="col-md-4">
                                            <div>Name: {{ brand.name }}</div>
                                            <div>Url: {{ brand.url }}</div>
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <button
                                                @click.prevent="remove(brand)"
                                                class="btn btn-danger btn-sm"
                                            >Delete</button>
                                        </div>
                                    </div>
                                </li>
                            </draggable>
                        </ul>
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
                url: '',
                logo: ''
            },
            brands: [],
            defaultForm: {},
            isUploading: false,
            logo_preview: '',
            percentCompleted: 0
        };
    },
    created() {
        this.defaultForm = Object.assign({}, this.form);
        this.fetchBrands();
    },
    methods: {
        fetchBrands() {
            axios.get('/api/admin/brands').then(resp => {
                this.brands = resp.data.brands;
            });
        },
        reset() {
            this.form = Object.assign({}, this.defaultForm);
            this.logo_preview = '';
        },
        fileChange() {
            this.uploadFile(this.$refs.fileUpload.files[0], true, file => {
                this.logo_preview = file.url;
                this.form.logo = file.filename;
            });
        },
        uploadFile(file, isThumb, callback) {
            const form = new FormData();
            form.append('file', file);
            form.append('folder', 'brands');
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
        create() {
            axios
                .post('/api/admin/brands', this.form)
                .then(resp => {
                    console.log(resp.data);
                    this.$store.dispatch('alertSuccess', 'Create success');
                    this.reset();
                    this.fetchBrands();
                })
                .catch(err => {
                    console.log(err);
                    this.$store.dispatch('handleError', err);
                });
        },
        remove(brand) {
            axios.delete(`/api/admin/brands/${brand.id}`).then(response => {
                if (response.data.status) {
                    this.$store.dispatch('alertSuccess', 'Delete success!');
                    this.fetchBrands();
                }
            });
        },
        checkUpdate(evt) {
            let orders = [];
            this.brands.forEach((b, index) => {
                orders.push({ id: b.id, order: index });
            });
            axios.put('/api/admin/brands-order', orders).then(resp => {
                console.log(resp.data);
            })
            console.log(orders);
        }
    }
};
</script>

<style lang="scss" scoped>
.img-preview {
    margin-bottom: 10px;
    img {
        max-height: 160px;
    }
}
.brand-logo {
    max-width: 80px;
    margin-right: 5px;
}
</style>