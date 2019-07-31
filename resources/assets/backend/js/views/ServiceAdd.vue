<template>
    <div class="card">
        <div class="card-header">
            <div class="card-title row">
                <h3 v-if="form.id">Chỉnh sửa gói dịch vụ</h3>
                <h3 v-else>Thêm gói dịch vụ</h3>
            </div>
        </div>
        <div class="card-body">
            <div v-if="$store.state.common.form.errors.length" class="alert alert-warning">
                <ul class="list-group">
                    <li v-for="error in $store.state.common.form.errors" class="">
                        <label>{{error}}</label>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-md-4">Tên gói</label>
                        <div class="col-md-8">
                            <input class="form-control form-required"
                                   placeholder="Tên gói dịch vụ. Ví dụ: Pro, Basic..."
                                   v-model="form.name" type="text"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4"></label>
                        <input type="checkbox"
                               id="vip_only" class="checkbox-inline" v-model="form.vip_only"/>
                        <label for="vip_only">Chỉ áp dụng cho VIP</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-md-4">Độ ưu tiên xếp bài</label>
                        <div class="col-md-8">
                            <input class="form-control form-required col-md-6"
                                   placeholder="Số: 1, 2..."
                                   v-model="form.priority" type="number"/>
                        </div>
                        <small>Thứ tự được sắp xếp từ cao xuống thấp. 1 là thấp nhất</small>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Số lần chỉnh sửa</label>
                        <div class="col-md-8">
                            <input class="form-control form-required col-md-6"
                                   placeholder="Số lần: 2, 5..."
                                   v-model="form.edit_times" type="number"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="card-title">Màu sắc</label>
                    <div class="form-group">
                        <input class="form-required " v-model="form.title_color" type="color"/>
                        <label class="">Tiêu đề</label>
                    </div>
                    <div class="form-group">
                        <input class="form-required" v-model="form.parameter_color" type="color"/>
                        <label class="">Thông số</label>
                    </div>
                    <div class="form-group">
                        <input class="form-required" v-model="form.price_color" type="color"/>
                        <label class="">Giá</label>
                    </div>
                    <label class="card-title">Làm mới tin</label>
                    <div class="form-group row">
                        <label class="col-md-4">Bằng tay (giờ)</label>
                        <div class="col-md-8">
                            <input class="form-control form-required col-md-6"
                                   placeholder="Số giờ: 72, 36..."
                                   v-model="form.manual_refresh" type="number"/>
                        </div>
                        <label class="col-md-4">Giá làm mới tự động</label>
                        <div class="col-md-8">
                            <input class="form-control form-required col-md-6"
                                   placeholder="Điền số: 10,0000"
                                   v-model="form.refresh_fee" type="number"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="card-title">Tiện ích</label>
                    <div class="form-group">
                        <input type="checkbox" id="allow_promotion" class="checkbox-inline" v-model="form.allow_promotion"/>
                        <label for="allow_promotion">Sử dụng khuyến mại</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="allow_sms" class="checkbox-inline" v-model="form.allow_sms"/>
                        <label for="allow_sms">Tích hợp SMS</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="direct_link"
                               class="checkbox-inline" v-model="form.direct_link"/>
                        <label for="direct_link">Hiển thị link</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="auto_active"
                               class="checkbox-inline" v-model="form.auto_active"/>
                        <label for="auto_active">Tự động duyệt bài</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="keep_alive"
                               class="checkbox-inline" v-model="form.icon"/>
                        <label for="keep_alive">Hiển thị Icon <i class="fa fa-diamond"></i></label>
                    </div>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <label class="card-title">Cài đặt giá</label>
                        <div class="form-group row">
                            <label class="col-md-4">Point mỗi ngày</label>
                            <div class="col-md-8">
                                <input class="form-control form-required col-md-6"
                                       placeholder="Giá: 1000, 2000 vnđ"
                                       v-model="form.fee_point" type="number"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" @click.prevent="save">
                                Cập nhật
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="card-title">Cài đặt các gói ngày</label>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Gói ngày</th>
                                <th>Số ngày</th>
                                <th>Giá</th>
                            </thead>
                            <tbody>
                                <tr v-for="option in daysOptions">
                                    <td>
                                        <input class="checkbox-inline" type="checkbox"
                                               :id="'option_' + option.id" :value="option.id"
                                            v-model="form.options"/>
                                        <label :for="'option_' + option.id">{{option.name}}</label>
                                    </td>
                                    <td class="text-right">
                                        {{option.days}}
                                    </td>
                                    <td class="text-right">
                                        {{option.days * form.fee_point | numFormat}} vnđ
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <dimmer v-show="loading"/>
    </div>
</template>

<script>
    export default {
        name: "ServiceAdd",
        created(){
            axios.get('/api/admin/service/option').then(resp => {
                this.daysOptions = resp.data.items;
            });
            if (this.$route.params.id) {
                this.form.id = this.$route.params.id;
                this.loading = true;
                axios.get('/api/admin/service/detail/' + this.form.id).then(resp => {
                    this.form = resp.data;
                    this.loading = false;
                });
            }
        },
        data() {
            return {
                loading: false,
                form: {
                    id: null,
                    name: '',
                    title_color: '#000000',
                    parameter_color: '#000000',
                    price_color: '#000000',
                    fee_point: '',
                    min_days: '',
                    images_number: 1,
                    max_content: 250,
                    max_title: 60,
                    allow_sms: 1,
                    allow_promotion: 0,
                    allow_management: 0,
                    allow_send_author: 0,
                    manual_refresh: 120,
                    auto_refresh: 0,
                    refresh_fee: 0,
                    options: [],
                    errors: [],
                    priority: 1,
                    backup_time: 0,
                    direct_link: 0,
                    display_in_trend: 0,
                    display_in_search: 0,
                    display_in_tags: 0,
                    auto_active: 0,
                    icon: 0,
                    edit_times: 0,
                    vip_only: 0,
                    keep_alive: 0
                },
                daysOptions: [],
                defaultForm: {
                    id: null,
                    name: '',
                    title_color: '#000000',
                    parameter_color: '#000000',
                    price_color: '#000000',
                    fee_point: '',
                    icon: '',
                    min_days: '',
                    images_number: 1,
                    max_content: 250,
                    max_title: 60,
                    allow_sms: 1,
                    allow_promotion: 0,
                    allow_management: 0,
                    allow_send_author: 0,
                    manual_refresh: 120,
                    auto_refresh: 0,
                    refresh_fee: 0,
                    options: [],
                    errors: [],
                    priority: 1,
                    backup_time: 0,
                    display_in_trend: 0,
                    display_in_search: 0,
                    display_in_tags: 0,
                    auto_active: 0,
                    edit_times: 0,
                    vip_only: 0,
                    keep_alive: 0
                }
            };
        },
        methods: {
            reset(){
               this.form = Object.assign({}, this.defaultForm);
            },
            save(){
                this.loading = true;
                axios.post('/api/admin/service/add', this.form).then(resp => {
                    if (resp.data.result) {
                        this.$store.dispatch('alertSuccess', 'Cập nhật thành công.');
                        // this.reset();
                        this.$router.push({
                           name: 'services'
                        });
                    } else {
                        this.$store.dispatch('alertError', 'Có lỗi xảy ra trong quá trình xử lý.');
                    }
                    this.loading = false;
                });
            }
        }
    }
</script>

<style scoped>

</style>