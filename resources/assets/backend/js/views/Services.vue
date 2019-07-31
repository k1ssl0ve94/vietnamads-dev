<template>
    <div class="card">
        <div class="card-header">
            <div class="card-title row">
                <h3>Bảng giá gói dịch vụ</h3>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                <thead><tr>
                    <th>Id</th>
                    <th>Tên gói</th>
                    <th>Ưu tiên</th>
                    <th>Giới hạn nội dung</th>
                    <th>Màu sắc</th>
                    <th>Tiện ích</th>
                    <th>Gói ngày</th>
                    <th></th>
                </tr></thead>
                <tbody>
                    <tr v-for="item in items">
                        <td>{{item.id}}</td>
                        <td>
                            {{item.name}}<br/>
                            <strong class="fa fa-star-o color-red" v-if="item.vip_only"> Vip only</strong>
                        </td>
                        <td>{{item.priority}}</td>
                        <td>
                            <p>Làm mới bằng tay: {{item.manual_refresh | numFormat}} giờ</p>
                            <p>Phí làm mới tự động: {{item.refresh_fee | numFormat}} vnđ</p>
                            <!--<p>Lưu trữ sau hết hạn: {{item.backup_time | numFormat}} ngày</p>-->
                            <p>Số lần chỉnh sửa: {{item.edit_times | numFormat}}</p>
                        </td>
                        <td>
                            <p><span :style="'color:' + item.title_color">Tiêu đề</span></p>
                            <p><span :style="'color:' + item.parameter_color">Thông số</span></p>
                            <p><span :style="'color:' + item.price_color">Giá: {{item.fee_point | numFormat}} vnđ/ngày</span></p>
                        </td>
                        <td>
                            <p>
                                <i v-if="item.allow_promotion" class="fa fa-check-circle"></i>
                                <i v-else class="fa fa-minus-circle"></i>
                                Sử dụng khuyến mại
                            </p>
                            <p>
                                <i v-if="item.allow_sms" class="fa fa-check-circle"></i>
                                <i v-else class="fa fa-minus-circle"></i>
                                Tích hợp SMS
                            </p>
                            <p>
                                <i v-if="item.direct_link" class="fa fa-check-circle"></i>
                                <i v-else class="fa fa-minus-circle"></i>
                                Hiển thị link trực tiếp
                            </p>
                            <p>
                                <i v-if="item.auto_active" class="fa fa-check-circle"></i>
                                <i v-else class="fa fa-minus-circle"></i>
                                Tự động duyệt bài
                            </p>
                            <p>
                                <i v-if="item.icon" class="fa fa-check-circle"></i>
                                <i v-else class="fa fa-minus-circle"></i>
                                Hiển thị Icon <i class="fa fa-diamond"></i>
                            </p>
                        </td>
                        <td>
                            <ul class="">
                                <li v-for="option in item.options" class="">
                                    <span class="">{{option.name}}( {{option.days}} ngày): </span>
                                    <span class="number" style="float: right;">
                                        {{item.fee_point * option.days | numFormat}} vnđ</span>
                                </li>
                            </ul>
                        </td>
                        <td>
                            <button
                                    @click.prevent="goEdit(item)"
                                    class="fa fa-edit" title="Edit package"
                            ></button>
                            <button
                                    @click.prevent="remove(item)"
                                    class="fa fa-trash-o" title="Remove package"
                            ></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Services",
        data(){
            return {
              items: []
            };
        },
        created(){
            this.fetchData();
        },
        methods: {
            remove(item) {
                if (confirm('Are you sure to remove this service package?')){
                    axios.delete(`/api/admin/service/remove/${item.id}`).then(response => {
                        if (response.data.result) {
                            this.$store.dispatch('alertSuccess', 'Delete success!');
                            this.fetchData();
                        }
                    });
                }
                return false;
            },
            fetchData() {
                axios.get('/api/admin/services').then(resp => {
                    this.items = resp.data.items;
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