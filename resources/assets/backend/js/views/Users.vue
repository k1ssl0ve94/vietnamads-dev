<template>
    <div id="users">
        <div class="page-header">
            <h1 class="page-title">Users</h1>
            <div class="page-options"></div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action @submit.prevent="search">
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Enter keyword"
                                v-model="form.keyword"
                            >
                        </div>
                        <div class="form-group col-sm-2">
                            <select class="form-control" v-model="form.level">
                                <option value="">-- All level --</option>
                                <option value="1">Normal</option>
                                <option value="2">VIP</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <select class="form-control" v-model="form.type">
                                <option value="">-- All type --</option>
                                <option value="1">Customer</option>
                                <option value="2">Agency</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <select class="form-control" v-model="form.status">
                                <option value="">-- All Status --</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <button type="submit" class="btn btn-primary btn-block">Search</button>
                        </div>
                        <div class="form-group col-sm-2">
                            <button
                                type="button"
                                class="btn btn-link"
                                @click.prevent="resetFormSearch"
                            >Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <dimmer v-show="loading"/>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ & tên</th>
                            <th>Email</th>
                            <th>Tiền đã nạp</th>
                            <th>Đã sử dụng</th>
                            <th>Còn lại</th>
                            <th>Khuyến mại</th>
                            <th>Trạng thái</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.id }}</td>
                            <td>
                                <span>{{ user.name }}</span><br/>
                                <span class="badge badge-danger" v-if="user.level == 2">VIP</span>
                                <span class="badge badge-primary" v-if="user.type == 2">Agency</span>
                                <span class="badge badge-danger" v-if="user.verified_by_admin == 1">Đã xác minh</span>
                            </td>
                            <td>
                                {{ user.email }}<br/>
                                <span v-if="user.phone" class="badge badge-info">
                                    <i class="fa fa-mobile-phone"></i> {{user.phone}}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-success">{{ user.point | numFormat}}</span>
                            </td>
                            <td>
                                <span class="badge badge-default">{{ user.used_point | numFormat}}</span>
                            </td>
                            <td>
                                <span class="badge badge-default">{{ user.remain_point | numFormat}}</span>
                            </td>
                            <td>
                                <span class="badge badge-default">{{ user.promotion_point | numFormat}}</span>
                            </td>
                            <td>
                                <template v-if="user.activated == 0">Chưa kích hoạt</template>
                                <template v-else>{{ user.status ? 'Active' : 'Inactive' }}</template>
                                <br/>
                                <span v-if="user.verified_phone == 1" class="badge badge-info">
                                    <i class="fa fa-mobile"> Đã xác minh</i>
                                </span>
                                <!--<span v-else class="badge badge-danger">-->
                                    <!--<i class="fa fa-mobile"> Chưa xác minh</i>-->
                                <!--</span>-->
                                <button
                                        v-if="hasPermission('manage user') && !user.verified_phone"
                                        class="btn btn-secondary btn-sm"
                                        @click.prevent="showModalVerifyPhone(user)"
                                        title="Xác minh điện thoại"
                                ><i class="fa fa-mobile-phone"></i> Click xác minh</button>
                            </td>
                            <td>
                                <router-link
                                    v-if="hasPermission('manage user')"
                                    class="btn btn-secondary btn-sm"
                                    :to="{name:'edit-user', params:{id: user.id}}"
                                    title="Sửa tài khoản"
                                ><i class="fa fa-edit"></i></router-link>
                                <button
                                    v-if="hasPermission('manage user')"
                                    class="btn btn-secondary btn-sm"
                                    @click.prevent="showModalAddPoint(user)"
                                    title="Thêm tiền vào tài khoản"
                                ><i class="fa fa-dollar"></i></button>
                                <button
                                        v-if="hasPermission('manage user')"
                                        class="btn btn-secondary btn-sm"
                                        @click.prevent="showModalChangeType(user)"
                                        title="Change type & level"
                                ><i class="fa fa-edit"></i> Type & Level</button>

                                <!--<button-->
                                        <!--v-if="hasPermission('manage user') && !user.verified_phone"-->
                                        <!--class="btn btn-secondary btn-sm"-->
                                        <!--@click.prevent="showModalVerifyPhone(user)"-->
                                        <!--title="Xác minh điện thoại"-->
                                <!--&gt;<i class="fa fa-mobile-phone"></i></button>-->
                                <button
                                    v-if="hasPermission('manage user')"
                                    class="btn btn-danger btn-sm"
                                    @click.prevent="confirmDelete(user)"
                                    title="Xóa tài khoản"
                                ><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="text-center pt-3" v-if="users.length == 0">Không có dữ liệu.</p>
            <div class="card-footer d-flex">
                <span v-if="pagination">
                    Total:
                    <strong>{{ pagination.total }}</strong> users
                </span>
                <pagination class="ml-auto" ref="userPagination" :data="pagination"/>
            </div>
        </div>
        <modal-confirm ref="modalConfirm"/>
        <div class="modal fade" id="modal-add-point" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning border-0">
                        <h5
                            class="modal-title text-white"
                        >Thêm tiền vào tài khoản: {{ current_user.name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body p-5">
                        <form-message/>
                        <div class="form-group">
                            <label>Nhập số tiền</label>
                            <input type="text" class="form-control" v-model="point" required>
                            <div class="mt-2">Hãy nhập số tiền, số âm để trừ tiền</div>
                        </div>
                        <div class="form-group">
                            <label>Hình thức giao dịch</label>
                            <input type="text" class="form-control"
                                   placeholder="VNPAY, Banking, Direct..."
                                   v-model="transaction_type" required>
                        </div>
                        <div class="form-group">
                            <label>Mã giao dịch</label>
                            <input type="text" class="form-control"
                                   placeholder="Mã giao dịch tương ứng"
                                   v-model="transaction_code" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-warning" @click="addPoint">Lưu</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-change-type-level" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning border-0">
                        <h5
                                class="modal-title text-white"
                        >Change type & level: {{ current_user.name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body p-5">
                        <form-message/>
                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-control" v-model="current_user.type">
                                <option value="1">Customer</option>
                                <option value="2">Agency</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <select class="form-control" v-model="current_user.level">
                                <option value="1">Normal</option>
                                <option value="2">VIP</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-warning" @click="changeTypeAndLevel">Lưu</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-change-phone" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content form">
                    <div class="modal-header bg-warning border-0">
                        <h5
                                class="modal-title text-white"
                        >Xác minh điện thoại: {{ current_user.name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body p-5">
                        <form-message/>
                        <div class="form-group">
                            <label>Điện thoại</label>
                            <input type="text" v-model="current_user.phone" class="form-control"/>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-warning" @click="changePhone">Xác minh</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';

export default {
    data() {
        return {
            users: [],
            pagination: {},
            form: {
                keyword: '',
                status: '',
                level: '',
                type: '',
                group: 0
            },
            current_user: {},
            point: 0,
            point_note: '',
            transaction_type: '',
            transaction_code: '',
            loading: true,
            page: 0
        };
    },
    created() {
        let page = parseInt(this.$route.query.page);
        if (!page || page < 1) {
            page = 1;
        }

        this.fetchUsers(page);

        this.$store.dispatch('fetchSettings');
    },
    mounted() {
        this.$refs.userPagination.$on('goto_page', page => {
            this.fetchUsers(page);
        });

        this.$refs.modalConfirm.$on('delete_user_ok', user => {
            this.delete(user);
            this.$refs.modalConfirm.hide();
        });
    },
    computed: {
        ...mapGetters(['hasPermission'])
    },
    methods: {
        search() {
            this.fetchUsers(1);
        },
        resetFormSearch() {
            this.form = {
                keyword: '',
                status: '',
                group: 0
            };
            this.fetchUsers(1);
        },
        fetchUsers(page = 1) {
            this.loading = true;
            this.page = page;
            let params = Object.assign({}, this.form, { page });
            const query = _.map(params, (v, k) => {
                return encodeURIComponent(k) + '=' + encodeURIComponent(v);
            }).join('&');

            axios.get(`/api/admin/users?${query}`).then(response => {
                this.users = response.data.data;

                let pagination = response.data;
                pagination = _.omit(pagination, ['data']);
                this.pagination = pagination;

                this.loading = false;
            });
        },
        confirmDelete(user) {
            this.$refs.modalConfirm.show('delete_user', 'Bạn có chắc muốn xóa tài khoản này?', user);
        },
        delete(user) {
            axios.delete(`/api/admin/users/${user.id}`).then(response => {
                if (response.data.success) {
                    this.$store.dispatch('alertSuccess', 'Xóa bỏ thành công!');
                    if (this.users.length == 1) {
                        this.fetchUsers(1);
                    } else {
                        this.fetchUsers(this.page);
                    }
                }
            });
        },
        showModalAddPoint(user) {
            this.current_user = user;
            this.point = 0;
            this.point_note = '';
            this.transaction_type = '';
            this.transaction_code = '';
            $('#modal-add-point').modal();
        },
        showModalChangeType(user) {
            this.current_user = user;
            $('#modal-change-type-level').modal();
        },
        showModalVerifyPhone(user) {
            this.current_user = user;
            $('#modal-change-phone').modal();
        },
        addPoint() {
            axios
                .post(`/api/admin/users/${this.current_user.id}/point`, {
                    point: this.point,
                    transaction_type: this.transaction_type,
                    transaction_code: this.transaction_code
                })
                .then(resp => {
                    if (resp.data.status) {
                        this.$store.dispatch('alertSuccess', 'Thêm tiền thành công.');
                        $('#modal-add-point').modal('hide');
                        this.fetchUsers(1);
                    } else if (resp.data.errors) {
                        this.$store.dispatch('formErrors', resp.data.errors);
                    } else {
                        this.$store.dispatch('formErrors', ['Error!!']);
                    }
                })
                .catch(err => {
                    this.$store.dispatch('handleError', err);
                    console.log(err);
                });
        },
        changePhone() {
            axios
                .post(`/api/admin/users/${this.current_user.id}/phone_verify`, {
                    phone: this.current_user.phone
                })
                .then(resp => {
                    if (resp.data.status) {
                        this.$store.dispatch('alertSuccess', 'Cập nhật thành công.');
                        $('#modal-change-phone').modal('hide');
                        this.fetchUsers(1);
                    } else if (resp.data.errors) {
                        this.$store.dispatch('formErrors', resp.data.errors);
                    } else {
                        this.$store.dispatch('formErrors', ['Error!!']);
                    }
                })
                .catch(err => {
                    this.$store.dispatch('handleError', err);
                    console.log(err);
                });
        },
        changeTypeAndLevel() {
            axios
                .post(`/api/admin/users/${this.current_user.id}/change_type_level`, {
                    level: this.current_user.level,
                    type: this.current_user.type
                })
                .then(resp => {
                    if (resp.data.status) {
                        this.$store.dispatch('alertSuccess', 'Cập nhật thành công.');
                        $('#modal-change-type-level').modal('hide');
                        this.fetchUsers(1);
                    } else if (resp.data.errors) {
                        this.$store.dispatch('formErrors', resp.data.errors);
                    } else {
                        this.$store.dispatch('formErrors', ['Error!!']);
                    }
                })
                .catch(err => {
                    this.$store.dispatch('handleError', err);
                    console.log(err);
                });
        }
    }
};
</script>