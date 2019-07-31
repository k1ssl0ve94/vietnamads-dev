<template>
    <div id="banner-setting">
        <div class="page-header">
            <h1 class="page-title">Setting</h1>
        </div>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <!--<div class="form-group row">-->
                            <!--<label class="col-md-4 col-form-label">Giá gói Pro</label>-->
                            <!--<div class="col-md-8">-->
                                <!--<input-->
                                    <!--type="text"-->
                                    <!--class="form-control"-->
                                    <!--placeholder="price pro"-->
                                    <!--v-model="form.price_pro"-->
                                    <!--required-->
                                <!--&gt;-->
                                <!--<small id="passwordHelpBlock" class="form-text text-muted">Nghìn vnd</small>-->
                            <!--</div>-->
                        <!--</div>-->
                        <!--<div class="form-group row">-->
                            <!--<label class="col-md-4 col-form-label">Thời gian làm mới tự động</label>-->
                            <!--<div class="col-md-8">-->
                                <!--<input-->
                                    <!--type="text"-->
                                    <!--class="form-control"-->
                                    <!--placeholder="refresh time"-->
                                    <!--v-model="form.refresh_time"-->
                                    <!--required-->
                                <!--&gt;-->
                                <!--<small id="passwordHelpBlock" class="form-text text-muted">Số giờ</small>-->
                            <!--</div>-->
                        <!--</div>-->
                        <!--<div class="form-group row">-->
                            <!--<label class="col-md-4 col-form-label">Thời gian làm mới(pro)</label>-->
                            <!--<div class="col-md-8">-->
                                <!--<input-->
                                    <!--type="text"-->
                                    <!--class="form-control"-->
                                    <!--placeholder="refresh time"-->
                                    <!--v-model="form.refresh_time_pro"-->
                                    <!--required-->
                                <!--&gt;-->
                                <!--<small id="passwordHelpBlock" class="form-text text-muted">Số giờ</small>-->
                            <!--</div>-->
                        <!--</div>-->
                    </div>
                    <div class="card-footer d-flex">
                        <button class="btn btn-primary ml-auto" @click.prevent="update">Update</button>
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
                refresh_time: 8,
            },
            isUploading: false,
            percentCompleted: 0
        };
    },
    created() {
        this.fetchSettings();
    },
    methods: {
        update() {
            axios
                .put('/api/admin/settings/update-multiple?group=all', this.form)
                .then(resp => {
                    console.log(resp.data);
                    this.$store.dispatch('alertSuccess', 'Update success');
                })
                .catch(err => {
                    console.log(err);
                });
        },
        fetchSettings() {
            axios.get('/api/admin/settings/all').then(resp => {
                ['price_pro', 'refresh_time', 'refresh_time_pro'].forEach(k => {
                    let c = resp.data.find(c => c.key == k);
                    if (c) {
                        this.form[k] = parseInt(c.value);
                    } else {
                        this.form[k] = 0;
                    }
                });
            });
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
</style>