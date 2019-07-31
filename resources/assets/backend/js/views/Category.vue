<template>
    <div id="robot_page">
        <div class="page-header">
            <h1 class="page-title">Update Parent Category</h1>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Biển quảng cáo</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Name</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Name"
                                    v-model="name0"
                            >
                          </div>
                        </div>                     
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Slug</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Slug"
                                    v-model="slug0"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Top Description</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Top Description"
                                    v-model="description0"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Bottom Description</label>
                          <div class="col-sm-9">
                            <textarea
                                    type="text"
                                    class="form-control summernote"
                                    placeholder="Bottom Description"
                                    v-model="content0"
                            ></textarea>
                          </div>
                        </div>                        
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Title</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Title"
                                    v-model="meta_title0"
                            >
                          </div>
                        </div>                           
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Keywords</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Keywords"
                                    v-model="meta_keywords0"
                            >
                          </div>
                        </div>    
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Description</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Description"
                                    v-model="meta_description0"
                            >
                          </div>
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
                        <h3 class="card-title">Quảng cáo truyền thông</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Name</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Name"
                                    v-model="name1"
                            >
                          </div>
                        </div>                     
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Slug</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Slug"
                                    v-model="slug1"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Top Description</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Top Description"
                                    v-model="description1"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Bottom Description</label>
                          <div class="col-sm-9">
                            <textarea
                                    type="text"
                                    class="form-control summernote"
                                    placeholder="Bottom Description"
                                    v-model="content1"
                            ></textarea>
                          </div>
                        </div>                        
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Title</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Title"
                                    v-model="meta_title1"
                            >
                          </div>
                        </div>                           
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Keywords</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Keywords"
                                    v-model="meta_keywords1"
                            >
                          </div>
                        </div>    
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Description</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Description"
                                    v-model="meta_description1"
                            >
                          </div>
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
                        <h3 class="card-title">Digital Marketing</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Name</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Name"
                                    v-model="name2"
                            >
                          </div>
                        </div>                     
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Slug</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Slug"
                                    v-model="slug2"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Top Description</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Top Description"
                                    v-model="description2"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Bottom Description</label>
                          <div class="col-sm-9">
                            <textarea
                                    type="text"
                                    class="form-control summernote"
                                    placeholder="Bottom Description"
                                    v-model="content2"
                            ></textarea>
                          </div>
                        </div>                        
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Title</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Title"
                                    v-model="meta_title2"
                            >
                          </div>
                        </div>                           
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Keywords</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Keywords"
                                    v-model="meta_keywords2"
                            >
                          </div>
                        </div>    
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Description</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Description"
                                    v-model="meta_description2"
                            >
                          </div>
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
                        <h3 class="card-title">Ads banner</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Name</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Name"
                                    v-model="name3"
                            >
                          </div>
                        </div>                     
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Slug</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Slug"
                                    v-model="slug3"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Top Description</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Top Description"
                                    v-model="description3"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Bottom Description</label>
                          <div class="col-sm-9">
                            <textarea
                                    type="text"
                                    class="form-control summernote"
                                    placeholder="Bottom Description"
                                    v-model="content3"
                            ></textarea>
                          </div>
                        </div>                        
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Title</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Title"
                                    v-model="meta_title3"
                            >
                          </div>
                        </div>                           
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Keywords</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Keywords"
                                    v-model="meta_keywords3"
                            >
                          </div>
                        </div>    
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Description</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Description"
                                    v-model="meta_description3"
                            >
                          </div>
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
                        <h3 class="card-title">Nghiệp vụ quảng cáo</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Name</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Name"
                                    v-model="name4"
                            >
                          </div>
                        </div>                     
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Slug</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Slug"
                                    v-model="slug4"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Top Description</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Top Description"
                                    v-model="description4"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Bottom Description</label>
                          <div class="col-sm-9">
                            <textarea
                                    type="text"
                                    class="form-control summernote"
                                    placeholder="Bottom Description"
                                    v-model="content4"
                            ></textarea>
                          </div>
                        </div>                        
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Title</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Title"
                                    v-model="meta_title4"
                            >
                          </div>
                        </div>                           
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Keywords</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Keywords"
                                    v-model="meta_keywords4"
                            >
                          </div>
                        </div>    
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Description</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Description"
                                    v-model="meta_description4"
                            >
                          </div>
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
                        <h3 class="card-title">Cần thuê dịch vụ</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Name</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Name"
                                    v-model="name5"
                            >
                          </div>
                        </div>                     
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Slug</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Slug"
                                    v-model="slug5"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Top Description</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Top Description"
                                    v-model="description5"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Bottom Description</label>
                          <div class="col-sm-9">
                            <textarea
                                    type="text"
                                    class="form-control summernote"
                                    placeholder="Bottom Description"
                                    v-model="content5"
                            ></textarea>
                          </div>
                        </div>                        
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Title</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Title"
                                    v-model="meta_title5"
                            >
                          </div>
                        </div>                           
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Keywords</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Keywords"
                                    v-model="meta_keywords5"
                            >
                          </div>
                        </div>    
                        <div class="form-group row">
                          <label class="col-form-label col-sm-3">Meta Description</label>
                          <div class="col-sm-9">
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Meta Description"
                                    v-model="meta_description5"
                            >
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
                name0: '',
                slug0:'',
                description0:'',
                content0:'',
                meta_title0:'',
                meta_description0:'',
                meta_keywords0:'',
                name1: '',
                slug1:'',
                description1:'',
                content1:'',
                meta_title1:'',
                meta_description1:'',
                meta_keywords1:'',
                name2: '',
                slug2:'',
                description2:'',
                content2:'',
                meta_title2:'',
                meta_description2:'',
                meta_keywords2:'',                
                name3: '',
                slug3:'',
                description3:'',
                content3:'',
                meta_title3:'',
                meta_description3:'',
                meta_keywords3:'', 
                name4: '',
                slug4:'',
                description4:'',
                content4:'',
                meta_title4:'',
                meta_description4:'',
                meta_keywords4:'',                               
                name5: '',
                slug5:'',
                description5:'',
                content5:'',
                meta_title5:'',
                meta_description5:'',
                meta_keywords5:'',                
                metadata: {},
                defaultForm: {},
                errors: []
            };
        },
        created() {
            this.fetchSettings();
        },
        watch: {

        },   
        computed: {

        },
        methods: {
            reset() {
                this.form = Object.assign({}, this.defaultForm);
            },         
            Update() {
                const data = {
                    name0:this.name0,
                    slug0:this.slug0,
                    description0:this.description0,
                    content0:this.content0,
                    meta_title0:this.meta_title0,
                    meta_description0:this.meta_description0,
                    meta_keywords0:this.meta_keywords0,
                    name1:this.name1,
                    slug1:this.slug1,
                    description1:this.description1,
                    content1:this.content1,
                    meta_title1:this.meta_title1,
                    meta_description1:this.meta_description1,
                    meta_keywords1:this.meta_keywords1,
                    name2:this.name2,
                    slug2:this.slug2,
                    description2:this.description2,
                    content2:this.content2,
                    meta_title2:this.meta_title2,
                    meta_description2:this.meta_description2,
                    meta_keywords2:this.meta_keywords2,
                    name3:this.name3,
                    slug3:this.slug3,
                    description3:this.description3,
                    content3:this.content3,
                    meta_title3:this.meta_title3,
                    meta_description3:this.meta_description3,
                    meta_keywords3:this.meta_keywords3,
                    name4:this.name4,
                    slug4:this.slug4,
                    description4:this.description4,
                    content4:this.content4,
                    meta_title4:this.meta_title4,
                    meta_description4:this.meta_description4,
                    meta_keywords4:this.meta_keywords4,
                    name5:this.name5,
                    slug5:this.slug5,
                    description5:this.description5,
                    content5:this.content5,
                    meta_title5:this.meta_title5,
                    meta_description5:this.meta_description5,
                    meta_keywords5:this.meta_keywords5,                                                                                
                };
                axios
                    .put('/api/admin/category', data)
                    .then(resp => {
                        this.$store.dispatch('alertSuccess', 'Update success');
                    })
                    .catch(err => {
                        console.log(err);
                    });
            }, 
            fetchSettings() {
                axios.get('/api/admin/category').then(resp => {                
                    const data = resp.data;  
                    this.name0 = data.name0;
                    this.slug0 = data.slug0;
                    this.description0 = data.description0;
                    this.content0 = data.content0;
                    this.meta_title0 = data.meta_title0;
                    this.meta_keywords0 = data.meta_keywords0;
                    this.meta_description0 = data.meta_description0;
                    this.name1 = data.name1;
                    this.slug1 = data.slug1;
                    this.description1 = data.description1;
                    this.content1 = data.content1;
                    this.meta_title1 = data.meta_title1;
                    this.meta_keywords1 = data.meta_keywords1;
                    this.meta_description1 = data.meta_description1;
                    this.name2 = data.name2;
                    this.slug2 = data.slug2;
                    this.description2 = data.description2;
                    this.content2 = data.content2;
                    this.meta_title2 = data.meta_title2;
                    this.meta_keywords2 = data.meta_keywords2;
                    this.meta_description2 = data.meta_description2;
                    this.name3 = data.name3;
                    this.slug3 = data.slug3;
                    this.description3 = data.description3;
                    this.content3 = data.content3;
                    this.meta_title3 = data.meta_title3;
                    this.meta_keywords3 = data.meta_keywords3;
                    this.meta_description3 = data.meta_description3;                                        
                    this.name4 = data.name4;
                    this.slug4 = data.slug4;
                    this.description4 = data.description4;
                    this.content4 = data.content4;
                    this.meta_title4 = data.meta_title4;
                    this.meta_keywords4 = data.meta_keywords4;
                    this.meta_description4 = data.meta_description4;  
                    this.name5 = data.name5;
                    this.slug5 = data.slug5;
                    this.description5 = data.description5;
                    this.content5 = data.content5;
                    this.meta_title5 = data.meta_title5;
                    this.meta_keywords5 = data.meta_keywords5;
                    this.meta_description5 = data.meta_description5;                                                   
                });
            }            
        }
    };
</script>