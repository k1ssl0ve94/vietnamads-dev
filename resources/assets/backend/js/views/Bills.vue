<template>
    <div class="card">
        <div class="card-header">
            <div class="card-title row">
                <h3>Lịch sử giao dịch</h3>
            </div>
        </div>
        <div class="card-body table-responsive">
            <div class="form-inline">
                <div class="form-group">
                    <input type="text" v-model="form.id" id="bill_id" class="form-control"
                           title="Bill id" placeholder="Bill Id"/>
                </div>
                <div class="form-group">
                    <label for="from_date"></label>
                    <input type="date" v-model="form.from_date" id="from_date" class="form-control"
                           title="Từ ngày"/>
                </div>
                <div class="form-group">
                    <label for="to_date"> <i class="fa fa-arrow-right"></i> </label>
                    <input type="date" v-model="form.to_date" id="to_date" class="form-control"
                           title="Tới ngày"/>
                </div>
                <div class="form-group">
                    <input type="email" v-model="form.user_email" id="user_email" class="form-control"
                           placeholder="Email"/>
                </div>
                <div class="form-group">
                    <input type="text" v-model="form.note" id="note" class="form-control"
                           placeholder="Search by note"/>
                </div>
                <div class="form-group">
                    <select v-model="form.type" class="form-control" name="type">
                        <option value="">- Chọn type -</option>
                        <option v-for="type in types" :value="type.value">{{type.label}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <select v-model="form.mode" class="form-control" name="mode">
                        <option value="">- Chọn mode -</option>
                        <option v-for="mode in modes" :value="mode.value">{{mode.label}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <select v-model="form.status" class="form-control" name="status">
                        <option value="">- Chọn trạng thái -</option>
                        <option value="1">Hoàn thành</option>
                        <option value="3">Đang giao dịch</option>
                        <option value="4">Hủy bỏ</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" v-model="form.user_level">
                        <option value="">-- User level --</option>
                        <option value="1">Normal</option>
                        <option value="2">VIP</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" v-model="form.user_type">
                        <option value="">-- User type --</option>
                        <option value="1">Customer</option>
                        <option value="2">Agency</option>
                    </select>
                </div>

                <button class="btn btn-primary" @click="fetchData(1)">Lọc</button>
            </div>
            <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Tài khoản</th>
                    <th>Email</th>
                    <th>Type/Mode</th>
                    <th>Số tiền</th>
                    <th>Khuyến mại</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in items.data">
                    <td>{{item.id}}</td>
                    <td>
                        <span v-if="item.user">
                        {{item.user.name}}
                        <br/>
                        <span class="badge badge-danger" v-if="item.user && item.user.level == 2">VIP</span>
                        <span class="badge badge-primary" v-if="item.user && item.user.type == 2">Agency</span>
                        </span>
                    </td>
                    <td>
                        <span v-if="item.user">{{item.user.email }}
                        </span>
                    </td>
                    <td>
                        {{item.typeLabel}}<br/>
                        <span class="badge badge-success">{{item.modeLabel}}</span>
                    </td>
                    <td class="text-right">
                        {{item.point | numFormat}}
                    </td>
                    <td class="text-right">
                        {{item.promotion_point | numFormat}}
                    </td>
                    <td>
                        <p class="" v-if="item.note">Note: {{item.note}}</p>
                        <small class="badge badge-primary">Tạo lúc: {{item.created_at}}</small>
                        <div v-if="edit_form.open && edit_form.id === item.id">
                            <textarea v-model="edit_form.note" class="form-control"
                                rows="3"></textarea>
                        </div>
                    </td>
                    <td>
                        <span :class="'badge ' + item.statusClass">{{item.statusLabel}}</span>
                        <div v-if="edit_form.open && edit_form.id === item.id && item.status === 3">
                            <select name="change_status" v-model="edit_form.status">
                                <option value="1">Hoàn thành</option>
                                <option value="4">Hủy bỏ</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <button v-if="!edit_form.open || edit_form.id !== item.id"
                                @click.prevent="edit(item)"
                                class="fa fa-edit" title="Chỉnh sửa"
                        ></button>
                        <div v-if="edit_form.open && edit_form.id === item.id">
                            <button
                                    @click.prevent="updateData(item)"
                                    class="fa fa-save" title="Cập nhật"
                            ></button>
                            <button
                                    @click.prevent="cancelUpdate(item)"
                                    class="fa fa-times-circle" title="Hủy bỏ"
                            ></button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <p class="text-center pt-3" v-if="items.length === 0">No product found</p>
            <div class="card-footer d-flex">
                <span v-if="items">
                    Total:
                    <strong>{{ items.total }}</strong> bills
                </span>
                <pagination class="ml-auto" ref="billPagination" :data="pagination"/>
            </div>
        </div>
        <dimmer v-show="loading"/>
    </div>
</template>

<script>
    export default {
        name: "Bills",
        data() {
            return {
                items: [],
                pagination: {},
                form: {
                    from_date: '',
                    to_date: '',
                    user_email: '',
                    note: '',
                    product_id: '',
                    type: '',
                    mode: '',
                    status: '',
                    user_level: '',
                    user_type: '',
                    id: ''
                },
                edit_form: {
                    id: '',
                    note: '',
                    status: '',
                    open: false
                },
                types: [],
                modes: [],
                page: 1,
                loading: false
            };
        },
        created() {
            this.fetchData(1);
            this.fetchBasicData();
        },
        mounted() {
            this.$refs.billPagination.$on('goto_page', page => {
                this.fetchData(page);
            });
        },
        methods: {
            edit(item) {
                this.edit_form.id = item.id;
                this.edit_form.note = item.note;
                this.edit_form.status = item.status;
                this.edit_form.open = true;
            },
            cancelUpdate() {
                this.edit_form.id = '';
                this.edit_form.note = '';
                this.edit_form.status = '';
                this.edit_form.open = false;
            },
            updateData(item) {
                this.loading = true;
                if (confirm('Bạn có chắc cập nhật giao dịch này?')) {
                    axios.put(`/api/admin/bills/update/${this.edit_form.id}`, {
                        status: this.edit_form.status,
                        note: this.edit_form.note
                    }).then(response => {
                        if (response.data.result) {
                            this.$store.dispatch('alertSuccess', 'Cập nhật giao dịch thành công!');
                            this.fetchData(this.page);
                        } else {
                            this.$store.dispatch('alertError', 'Cập nhật giao dịch thất bại!');
                        }
                        this.loading = false;
                        this.cancelUpdate();
                    });
                }
                return false;
            },
            fetchBasicData() {
                axios.get('/api/admin/bills/basic').then(resp => {
                    this.modes = resp.data.modeList;
                    this.types = resp.data.typeList;
                });
            },
            fetchData(page = 1) {
                this.loading = true;
                this.page = page;
                let params = Object.assign({}, this.form, {page});
                const query = _.map(params, (v, k) => {
                    return encodeURIComponent(k) + '=' + encodeURIComponent(v);
                }).join('&');
                axios.get('/api/admin/bills?' + query).then(resp => {
                    this.items = resp.data.items;
                    this.loading = false;

                    let pagination = resp.data.items;
                    pagination = _.omit(pagination, ['data']);
                    this.pagination = pagination;
                });
            }
        }
    }
</script>

<style scoped>

</style>