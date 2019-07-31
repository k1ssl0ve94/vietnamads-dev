<template>
  <div id="add-post" class="row">
    <div class="col-md-12">
      <form action @submit.prevent="addPost">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Add Post</h2>
          </div>
          <form-message/>
          <div class="card-body">
            <div class="form-group row">
              <label class="col-form-label col-sm-3">Language</label>
              <div class="col-sm-6">
                <select class="form-control" v-model="form.lang">
                  <option value="0">Vietnamese</option>
                  <option value="1">English</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-3">Category</label>
              <div class="col-sm-6">
                <select class="form-control" v-model="form.cat">
                  <option value="1">Sự kiện</option>
                  <option value="2">Phân tích, nhận định</option>
                  <option value="3">Chia sẻ kinh nghiệm</option>
                  <option value="4">Thương hiệu, sản phẩm</option>
                  <option value="5">Chính sách, quản lý</option>
                  <option value="6">Thông báo</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-3">Image</label>
              <div class="col-sm-9">
                <div class="img-preview" v-if="form.image">
                  <img :src="form.image.url" alt>
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
            <div class="form-group row">
              <label class="col-form-label col-sm-3">Image alt text</label>
              <div class="col-sm-9">
                <input
                        type="text"
                        class="form-control"
                        placeholder="Image alt text"
                        v-model="form.image_alt"
                >
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-3">Title</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="title" v-model="form.title" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-3">Slug</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="slug" v-model="form.slug">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-3">Sapo</label>
              <div class="col-sm-9">
                <textarea class="form-control" rows="3" v-model="form.sapo" required></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-3">Content</label>
              <div class="col-sm-9">
                <textarea class="form-control summernote" rows="8" v-model="form.content" required></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-3">Meta title</label>
              <div class="col-sm-9">
                <input
                        type="text"
                        class="form-control"
                        placeholder="Meta title"
                        v-model="form.meta_title"
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
                        v-model="form.meta_keywords"
                >
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-3">Meta canonical</label>
              <div class="col-sm-9">
                <input
                        type="text"
                        class="form-control"
                        placeholder="Meta canonical url"
                        v-model="form.meta_canonical"
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
                        v-model="form.meta_description"
                >
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-9 offset-sm-3">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    value
                    id="formStatus"
                    v-model="form.status"
                  >
                  <label class="form-check-label" for="formStatus">Active</label>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-9 offset-sm-3">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    value
                    id="formHot"
                    v-model="form.hot"
                  >
                  <label class="form-check-label" for="formHot">Hot</label>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex">
            <router-link to="/news" class="btn btn-link">Cancel</router-link>
            <button type="submit" class="btn btn-primary ml-auto">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                title: '',
                sapo: '',
                content: '',
                image: '',
                status: true,
                hot: false,
                cat: 1,
                lang: 0,
                meta_description: '',
                meta_keywords: '',
                meta_canonical: '',
                image_alt: '',
                slug: ''
            },
            isUploading: false,
            percentCompleted: 0
        };
    },
    created() {
        this.$store.dispatch('fetchSettings');
    },
    mounted() {
        this.initSummerNote();
    },
    methods: {
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
        addPost() {
            let form = this.form;
            form.hot = form.hot ? '1' : 0;
            axios.post('/api/admin/posts', form).then(response => {
                if (response.data.post) {
                    this.resetFormData();
                    this.$store.dispatch('alertSuccess', 'Add new post success');
                    this.$router.push({
                        name: 'news'
                    });
                } else {
                    this.$store.dispatch('formErrors', ['Error!!']);
                }
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
        resetFormData() {
            this.form = {
                title: '',
                sapo: '',
                content: '',
                image: '',
                status: true,
                hot: false,
                cat: 1,
                meta_description: '',
                meta_keywords: '',
                meta_canonical: '',
            };
        }
    }
};
</script>

<style lang="scss" scoped>
.img-preview {
    margin-bottom: 20px;
    img {
        max-height: 200px;
    }
}
</style>
