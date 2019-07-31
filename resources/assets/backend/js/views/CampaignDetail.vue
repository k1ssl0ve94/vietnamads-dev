<template>
    <div class="card">
        <div class="card-header">
            <div class="card-title row">
                <h3>Chi tiết chiến dịch - danh sách gift code</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 campaign-info">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Thông tin chiến dịch</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>Tiêu đề</th>
                            <td class="text-right">{{campaign.title}}</td>
                        </tr>
                        <tr>
                            <th>Áp dụng</th>
                            <td class="text-right">{{campaign.from_date}}
                            </td>
                        </tr>
                        <tr>
                            <th>Hết hạn</th>
                            <td class="text-right">{{campaign.end_date}}
                            </td>
                        </tr>
                        <tr>
                            <th>Số lượng code</th>
                            <td class="text-right">
                                {{campaign.number_codes | numFormat}}
                            </td>
                        </tr>
                        <tr>
                            <th>Giá trị code</th>
                            <td class="text-right">
                                {{campaign.value | numFormat}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered table-striped card-table">
                        <thead><tr>
                            <th>Id</th>
                            <th>Code</th>
                            <th>Số lần dùng</th>
                            <th>Đã dùng</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr></thead>
                        <tbody>
                        <tr v-for="item in items.data">
                            <td>{{item.id}}</td>
                            <td>
                                {{item.code}}<br/>
                            </td>
                            <td>{{item.valid_times | numFormat}}</td>
                            <td>
                                {{item.used_times | numFormat}}
                            </td>
                            <td>
                                <p class="badge badge-info" v-if="item.status == 1">Đang chạy</p>
                                <p class="badge badge-success" v-else-if="item.status == 2">Đã hết</p>
                                <p class="badge badge-cancel" v-else>Bị hủy</p>
                            </td>
                            <td>
                                <button
                                        @click.prevent="remove(item)"
                                        class="fa fa-trash-o" title="Hủy gift code"
                                ></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <p class="text-center pt-3" v-if="items.length === 0">No codes found</p>
                    <div class="card-footer d-flex">
                <span v-if="items">
                    Tổng:
                    <strong>{{ items.total }}</strong> gift codes
                </span>
                        <pagination class="ml-auto" ref="itemPagination" :data="pagination"/>
                    </div>
                </div>
            </div>
        </div>
        <dimmer v-show="loading"/>
    </div>
</template>

<script>
    export default {
        name: "CampaignDetail",
        data(){
            return {
                items: [],
                pagination: {},
                id: '',
                form: {
                    from_date: '',
                    to_date: '',
                    status: ''
                },
                campaign: {
                    title: '',
                    prefix: '',
                    number_codes: 0,
                    valid_times: 1,
                    value: 0,
                    from_date: '',
                    end_date: '',
                    id: ''
                },
                page: 1,
                loading: false
            };
        },
        created(){
            if (this.$route.params.id) {
                this.id = this.$route.params.id;
            }
            this.fetchData();
        },
        mounted() {
            this.$refs.itemPagination.$on('goto_page', page => {
                this.fetchData(page);
            });
        },
        methods: {
            remove(item) {
                if (confirm('Bạn có chắc muốn hủy bỏ Gift code này?')){
                    axios.delete(`/api/admin/campaign/code/cancel/${item.id}`).then(response => {
                        if (response.data.result) {
                            this.$store.dispatch('alertSuccess', 'Delete success!');
                            this.fetchData();
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
                axios.get('/api/admin/campaign/codes/' + this.id + '?' + query).then(resp => {
                    this.items = resp.data.items;
                    this.campaign = resp.data.campaign;
                    let pagination = resp.data.items;
                    pagination = _.omit(pagination, ['data']);
                    this.pagination = pagination;
                    this.loading = false;
                });
            },
            goEdit(item) {
                this.$router.push({
                    name: 'services_edit',
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