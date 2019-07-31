<template>
    <div class="card">
        <div class="card-header">
            <div class="card-title row">
                <h3>Danh sách chiến dịch</h3>
            </div>
        </div>
        <div class="card-body table-responsive">
            <div class="form-inline">
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
                    <input type="text" v-model="form.title" id="title" class="form-control"
                           placeholder="Từ khóa..."/>
                </div>
                <div class="form-group">
                    <select v-model="form.status" class="form-control" name="status">
                        <option value="">- Chọn trạng thái -</option>
                        <option value="1">Đang áp dụng</option>
                        <option value="2">Đã dừng</option>
                    </select>
                </div>
                <button class="btn btn-primary" @click="fetchData(1)">Lọc</button>
            </div>
            <br/>
            <div class="divider"></div>
            <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                <thead><tr>
                    <th>Id</th>
                    <th>Tiêu đề</th>
                    <th>Tiền tố</th>
                    <th>Số lượng code</th>
                    <th>Giá trị</th>
                    <th>Thời gian sử dụng</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr></thead>
                <tbody>
                <tr v-for="item in items.data">
                    <td>{{item.id}}</td>
                    <td>
                        {{item.title}}<br/>
                    </td>
                    <td>{{item.prefix}}</td>
                    <td class="text-right">
                        {{item.number_codes | numFormat}}
                    </td>
                    <td class="text-right">
                        {{item.value | numFormat}}vnđ
                    </td>
                    <td>
                        {{item.from_date}}
                        <i class="fa fa-arrow-right"></i> {{item.end_date}}
                    </td>
                    <td>
                        <i class="fa fa-check-circle" v-if="item.status == 1"></i>
                        <i class="fa fa-minus-circle" v-else></i>
                    </td>
                    <td>
                        <button
                                @click.prevent="goDetail(item)"
                                class="fa fa-address-book" title="Chi tiết"
                        ></button>
                        <button
                                v-if="item.status == 1"
                                @click.prevent="remove(item)"
                                class="fa fa-trash-o" title="Xóa chiến dịch"
                        ></button>
                        <button
                                v-if="item.status == 2"
                                @click.prevent="reactive(item)"
                                class="fa fa-refresh" title="Khởi động lại"
                        ></button>
                    </td>
                </tr>
                </tbody>
            </table>
            <p class="text-center pt-3" v-if="items.length === 0">No campaign found</p>
            <div class="card-footer d-flex">
                <span v-if="items">
                    Tổng:
                    <strong>{{ items.total }}</strong> chiến dịch
                </span>
                <pagination class="ml-auto" ref="itemPagination" :data="pagination"/>
            </div>
        </div>
        <dimmer v-show="loading"/>
    </div>
</template>

<script>
    export default {
        name: "Campaign",
        data(){
            return {
                items: [],
                pagination: {},
                form: {
                    from_date: '',
                    to_date: '',
                    title: '',
                    status: ''
                },
                page: 1,
                loading: false
            };
        },
        created(){
            this.fetchData();
        },
        mounted() {
            this.$refs.itemPagination.$on('goto_page', page => {
                this.fetchData(page);
            });
        },
        methods: {
            remove(item) {
                if (confirm('Chú ý, tất cả các gift code cũng sẽ bị hủy bỏ. \r\n Bạn có chắc muốn xóa bỏ chiến dịch này?')){
                    axios.delete(`/api/admin/campaign/cancel/${item.id}`).then(response => {
                        if (response.data.status) {
                            this.$store.dispatch('alertSuccess', 'Cập nhật thành công!');
                            this.fetchData(this.page);
                        }
                    });
                }
                return false;
            },
            reactive(item) {
                if (confirm('Bạn có chắc muốn khởi động lại chiến dịch này?')){
                    axios.delete(`/api/admin/campaign/cancel/${item.id}?reactive=1`).then(response => {
                        if (response.data.status) {
                            this.$store.dispatch('alertSuccess', 'Cập nhật thành công!');
                            this.fetchData(this.page);
                        }
                    });
                }
                return false;
            },
            fetchData(page = 1) {
                this.loading = true;
                this.page = page;
                let params = Object.assign({}, this.form, {page});
                const query = _.map(params, (v, k) => {
                    return encodeURIComponent(k) + '=' + encodeURIComponent(v);
                }).join('&');
                axios.get('/api/admin/campaign?' + query).then(resp => {
                    this.items = resp.data.items;
                    let pagination = resp.data.items;
                    pagination = _.omit(pagination, ['data']);
                    this.pagination = pagination;
                    this.loading = false;
                });
            },
            goDetail(item) {
                this.$router.push({
                    name: 'campaign_detail',
                    params: {
                        id: item.id
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>