<template>
    <div id="seo-setting">
        <div class="page-header">
            <h1 class="page-title">Seo Setting</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">One Page</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta title</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta title"
                                    v-model="meta_title"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta keywords</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta keywords"
                                    v-model="meta_keywords"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta description</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta description"
                                    v-model="meta_description"
                            >
                          </div>
                        </div>                       
                    </div>
                    <div class="card-footer d-flex">
                        <button class="btn btn-primary ml-auto" @click.prevent="Update">Update</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Facebook</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta title</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta title"
                                    v-model="fb_meta_title"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta description</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta description"
                                    v-model="fb_meta_description"
                            >
                          </div>
                        </div> 
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Image</label>
                          <div class="col-sm-9">
                            <div class="img-preview" v-if="fb_image_url">
                              <img :src="fb_image_url" alt>
                            </div>
                            <div class="custom-file" style="max-width: 300px" v-show="!isUploading">
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
                            <small class="form-text text-muted">
                              <a href="#" @click.prevent="removeImage">Remove</a>
                            </small>
                          </div>
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
            meta_title: '',
            meta_keywords: '',
            meta_description: '',
            fb_meta_title: '',
            fb_meta_description: '',
            fb_image_url:'',
            fb_image: '',            
            isUploading: false,
            percentCompleted: 0

        };
    },
    created() {
        this.fetchSettings();
    },
    methods: { 
        fileChange() {
            this.uploadFile(this.$refs.fileUpload.files[0], false, file => {
                this.fb_image_url = file.url;
                this.fb_image = file.filename;
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
                meta_title: this.meta_title,
                meta_keywords: this.meta_keywords,
                meta_description: this.meta_description,
                fb_meta_title: this.fb_meta_title,
                fb_meta_description: this.fb_meta_description,
                fb_image: this.fb_image,
            };
            axios
                .put('/api/admin/seo-setting', data)
                .then(resp => {
                    this.$store.dispatch('alertSuccess', 'Update success');
                })
                .catch(err => {
                    console.log(err);
                });
        },        
        fetchSettings() {
            axios.get('/api/admin/seo-setting').then(resp => {                
                const data = resp.data;
                this.meta_title = data.meta_title;
                this.meta_keywords = data.meta_keywords;
                this.meta_description = data.meta_description;
                this.fb_meta_title = data.fb_meta_title;
                this.fb_meta_description = data.fb_meta_description;
                this.fb_image = data.fb_image;               
                this.fb_image_url = data.fb_image_url;
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