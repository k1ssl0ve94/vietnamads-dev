<template>
    <div id="banner-setting">
        <div class="page-header">
            <h1 class="page-title">Banner Setting</h1>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Banner_top</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>URL</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="url of ads"
                                v-model="banner_top.url"
                            >
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <div class="img-preview" v-if="banner_top_url">
                                <img :src="banner_top_url">
                            </div>
                            <div class="custom-file" v-show="!isUploading">
                                <input
                                    type="file"
                                    class="custom-file-input"
                                    name="example-file-input-custom"
                                    ref="fileUpload"
                                    @change="fileChangeImageTop"
                                >
                                <label class="custom-file-label">Choose file</label>
                            </div>
                            <p v-if="isUploading">Uploading: {{ percentCompleted }}%</p>
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <button class="btn btn-primary ml-auto" @click.prevent="Update">Update</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Banner_1</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>URL</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="url of ads"
                                v-model="banner_1.url"
                            >
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <div class="img-preview" v-if="banner_1_url">
                                <img :src="banner_1_url">
                            </div>
                            <div class="custom-file" v-show="!isUploading">
                                <input
                                    type="file"
                                    class="custom-file-input"
                                    name="example-file-input-custom"
                                    ref="fileUpload_1"
                                    @change="fileChangeImage1"
                                >
                                <label class="custom-file-label">Choose file</label>
                            </div>
                            <p v-if="isUploading">Uploading: {{ percentCompleted }}%</p>
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <button class="btn btn-primary ml-auto" @click.prevent="Update">Update</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Banner_2</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>URL</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="url of ads"
                                v-model="banner_2.url"
                            >
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <div class="img-preview" v-if="banner_2_url">
                                <img :src="banner_2_url">
                            </div>
                            <div class="custom-file" v-show="!isUploading">
                                <input
                                    type="file"
                                    class="custom-file-input"
                                    name="example-file-input-custom"
                                    ref="fileUpload_2"
                                    @change="fileChangeImage2"
                                >
                                <label class="custom-file-label">Choose file</label>
                            </div>
                            <p v-if="isUploading">Uploading: {{ percentCompleted }}%</p>
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <button class="btn btn-primary ml-auto" @click.prevent="Update">Update</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Banner_3</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>URL</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="url of ads"
                                v-model="banner_3.url"
                            >
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <div class="img-preview" v-if="banner_3_url">
                                <img :src="banner_3_url">
                            </div>
                            <div class="custom-file" v-show="!isUploading">
                                <input
                                    type="file"
                                    class="custom-file-input"
                                    name="example-file-input-custom"
                                    ref="fileUpload_3"
                                    @change="fileChangeImage3"
                                >
                                <label class="custom-file-label">Choose file</label>
                            </div>
                            <p v-if="isUploading">Uploading: {{ percentCompleted }}%</p>
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <button class="btn btn-primary ml-auto" @click.prevent="Update">Update</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Banner_4</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>URL</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="url of ads"
                                v-model="banner_4.url"
                            >
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <div class="img-preview" v-if="banner_4_url">
                                <img :src="banner_4_url">
                            </div>
                            <div class="custom-file" v-show="!isUploading">
                                <input
                                    type="file"
                                    class="custom-file-input"
                                    name="example-file-input-custom"
                                    ref="fileUpload_4"
                                    @change="fileChangeImage4"
                                >
                                <label class="custom-file-label">Choose file</label>
                            </div>
                            <p v-if="isUploading">Uploading: {{ percentCompleted }}%</p>
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <button class="btn btn-primary ml-auto" @click.prevent="Update">Update</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Banner_5</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>URL</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="url of ads"
                                v-model="banner_5.url"
                            >
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <div class="img-preview" v-if="banner_5_url">
                                <img :src="banner_5_url">
                            </div>
                            <div class="custom-file" v-show="!isUploading">
                                <input
                                    type="file"
                                    class="custom-file-input"
                                    name="example-file-input-custom"
                                    ref="fileUpload_5"
                                    @change="fileChangeImage5"
                                >
                                <label class="custom-file-label">Choose file</label>
                            </div>
                            <p v-if="isUploading">Uploading: {{ percentCompleted }}%</p>
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <button class="btn btn-primary ml-auto" @click.prevent="Update">Update</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Banner_6</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>URL</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="url of ads"
                                v-model="banner_6.url"
                            >
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <div class="img-preview" v-if="banner_6_url">
                                <img :src="banner_6_url">
                            </div>
                            <div class="custom-file" v-show="!isUploading">
                                <input
                                    type="file"
                                    class="custom-file-input"
                                    name="example-file-input-custom"
                                    ref="fileUpload_6"
                                    @change="fileChangeImage6"
                                >
                                <label class="custom-file-label">Choose file</label>
                            </div>
                            <p v-if="isUploading">Uploading: {{ percentCompleted }}%</p>
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <button class="btn btn-primary ml-auto" @click.prevent="Update">Update</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Banner_7</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>URL</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="url of ads"
                                v-model="banner_7.url"
                            >
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <div class="img-preview" v-if="banner_7_url">
                                <img :src="banner_7_url">
                            </div>
                            <div class="custom-file" v-show="!isUploading">
                                <input
                                    type="file"
                                    class="custom-file-input"
                                    name="example-file-input-custom"
                                    ref="fileUpload_7"
                                    @change="fileChangeImage7"
                                >
                                <label class="custom-file-label">Choose file</label>
                            </div>
                            <p v-if="isUploading">Uploading: {{ percentCompleted }}%</p>
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <button class="btn btn-primary ml-auto" @click.prevent="Update">Update</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Banner_8</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>URL</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="url of ads"
                                v-model="banner_8.url"
                            >
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <div class="img-preview" v-if="banner_8_url">
                                <img :src="banner_8_url">
                            </div>
                            <div class="custom-file" v-show="!isUploading">
                                <input
                                    type="file"
                                    class="custom-file-input"
                                    name="example-file-input-custom"
                                    ref="fileUpload_8"
                                    @change="fileChangeImage8"
                                >
                                <label class="custom-file-label">Choose file</label>
                            </div>
                            <p v-if="isUploading">Uploading: {{ percentCompleted }}%</p>
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <button class="btn btn-primary ml-auto" @click.prevent="Update">Update</button>
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
            banner_top_url: '',
            banner_top: {
                image: '',
                url: ''
            },
            banner_1_url: '',
            banner_1: {
                image: '',
                url: ''
            },
            banner_2_url: '',
            banner_2: {
                image: '',
                url: ''
            },
            banner_3_url: '',
            banner_3: {
                image: '',
                url: ''
            },
            banner_4_url: '',
            banner_4: {
                image: '',
                url: ''
            },
            banner_5_url: '',
            banner_5: {
                image: '',
                url: ''
            },
            banner_6_url: '',
            banner_6: {
                image: '',
                url: ''
            },
            banner_7_url: '',
            banner_7: {
                image: '',
                url: ''
            },
            banner_8_url: '',
            banner_8: {
                image: '',
                url: ''
            },
            isUploading: false,
            percentCompleted: 0
        };
    },
    created() {
        this.fetchSettings();
    },
    methods: {
        fileChangeImageTop() {
            this.uploadFile(this.$refs.fileUpload.files[0], false, file => {
                this.banner_top_url = file.url;
                this.banner_top.image = file.filename;
            });
        },
        fileChangeImage1() {
            this.uploadFile(this.$refs.fileUpload_1.files[0], false, file => {
                this.banner_1_url = file.url;
                this.banner_1.image = file.filename;
            });
        },
        fileChangeImage2() {
            this.uploadFile(this.$refs.fileUpload_2.files[0], false, file => {
                this.banner_2_url = file.url;
                this.banner_2.image = file.filename;
            });
        },
        fileChangeImage3() {
            this.uploadFile(this.$refs.fileUpload_3.files[0], false, file => {
                this.banner_3_url = file.url;
                this.banner_3.image = file.filename;
            });
        },
        fileChangeImage4() {
            this.uploadFile(this.$refs.fileUpload_4.files[0], false, file => {
                this.banner_4_url = file.url;
                this.banner_4.image = file.filename;
            });
        },
        fileChangeImage5() {
            this.uploadFile(this.$refs.fileUpload_5.files[0], false, file => {
                this.banner_5_url = file.url;
                this.banner_5.image = file.filename;
            });
        },
        fileChangeImage6() {
            this.uploadFile(this.$refs.fileUpload_6.files[0], false, file => {
                this.banner_6_url = file.url;
                this.banner_6.image = file.filename;
            });
        },
        fileChangeImage7() {
            this.uploadFile(this.$refs.fileUpload_7.files[0], false, file => {
                this.banner_7_url = file.url;
                this.banner_7.image = file.filename;
            });
        },
        fileChangeImage8() {
            this.uploadFile(this.$refs.fileUpload_8.files[0], false, file => {
                this.banner_8_url = file.url;
                this.banner_8.image = file.filename;
            });
        },
        uploadFile(file, isThumb, callback) {
            const form = new FormData();
            form.append('file', file);
            form.append('folder', 'banners');
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
        Update() {
            const data = {
                banner_top: this.banner_top,
                banner_1: this.banner_1,
                banner_2: this.banner_2,
                banner_3: this.banner_3,
                banner_4: this.banner_4,
                banner_5: this.banner_5,
                banner_6: this.banner_6,
                banner_7: this.banner_7,
                banner_8: this.banner_8,
            };
            axios
                .put('/api/admin/banner-setting', data)
                .then(resp => {
                    console.log(resp.data);
                    this.$store.dispatch('alertSuccess', 'Update success');
                })
                .catch(err => {
                    console.log(err);
                });
        },
        fetchSettings() {
            axios.get('/api/admin/banner-setting').then(resp => {
                const data = resp.data;
                this.banner_top = data.banner_top;
                this.banner_top_url = data.banner_top_url;
                this.banner_1 = data.banner_1;
                this.banner_1_url = data.banner_1_url;
                this.banner_2 = data.banner_2;
                this.banner_2_url = data.banner_2_url;
                this.banner_3 = data.banner_3;
                this.banner_3_url = data.banner_3_url;
                this.banner_4 = data.banner_4;
                this.banner_4_url = data.banner_4_url;
                this.banner_5 = data.banner_5;
                this.banner_5_url = data.banner_5_url;
                this.banner_6 = data.banner_6;
                this.banner_6_url = data.banner_6_url;
                this.banner_7 = data.banner_7;
                this.banner_7_url = data.banner_7_url;
                this.banner_8 = data.banner_8;
                this.banner_8_url = data.banner_8_url;
            });
        }
    }
};
</script>

<style lang="scss" scoped>
.img-preview {
    margin-bottom: 10px;
    img {
        max-height: 120px;
    }
}
</style>