<template>
    <div id="campaign_page">
        <div class="page-header">
            <h1 class="page-title">Thêm mới chiến dịch</h1>
            <div class="page-options"></div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input
                                    type="text"
                                    maxlength="1000"
                                    class="form-control"
                                    placeholder="Độ dài tối đa 1000"
                                    v-model="form.title"
                            >
                        </div>
                        <div class="form-group">
                            <label>Tiền tố</label>
                            <input
                                    type="text"
                                    maxlength="5"
                                    class="form-control"
                                    placeholder="Độ dài tối đa 5"
                                    v-model="form.prefix"
                            >
                        </div>
                        <div class="form-group">
                            <label>Số lượng gift code phát hành</label>
                            <input
                                    type="number"
                                    class="form-control"
                                    placeholder="Số lượng gift code"
                                    v-model="form.number_codes"
                            >
                        </div>
                        <div class="form-group">
                            <label>Số lần sử dụng mỗi code</label>
                            <input
                                    type="number"
                                    class="form-control"
                                    placeholder="Mỗi code được dùng ..lần"
                                    v-model="form.valid_times"
                            >
                        </div>
                        <div class="form-group">
                            <label>Trị giá code</label>
                            <input
                                    type="number"
                                    class="form-control"
                                    placeholder="Value of gift code"
                                    v-model="form.value"
                            >
                        </div>
                        <div class="form-group">
                            <label>Ngày áp dụng</label>
                            <input
                                    type="date"
                                    class="form-control"
                                    v-model="form.from_date"
                            >
                        </div>
                        <div class="form-group">
                            <label>Hạn sử dụng</label>
                            <input
                                    type="date"
                                    class="form-control"
                                    v-model="form.end_date"
                            >
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <button class="btn btn-link" @click.prevent="reset">Reset</button>
                        <button v-if="!form.id"
                                type="button"
                                class="btn btn-primary ml-auto"
                                @click.prevent="create"
                        >Tạo</button>
                        <button v-if="form.id"
                                type="button"
                                class="btn btn-primary ml-auto"
                                @click.prevent="update"
                        >Cập nhật</button>
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
                    title: '',
                    prefix: '',
                    number_codes: 0,
                    valid_times: 1,
                    value: 0,
                    from_date: '',
                    end_date: '',
                    id: ''
                },
                items: [],
                defaultForm: {}
            };
        },
        created() {
            this.defaultForm = Object.assign({}, this.form);
        },
        methods: {
            reset() {
                this.form = Object.assign({}, this.defaultForm);
            },
            create() {
                axios
                    .post('/api/admin/campaign/create', this.form)
                    .then(resp => {
                        console.log(resp.data);
                        this.$store.dispatch('alertSuccess', 'Create success');
                        this.$router.push({
                            name: 'campaign'
                        });
                    })
                    .catch(err => {
                        console.log(err);
                        this.$store.dispatch('handleError', err);
                    });
            },
            update() {
                axios
                    .post('/api/admin/campaign/create', this.form)
                    .then(resp => {
                        console.log(resp.data);
                        this.$store.dispatch('alertSuccess', 'Create success');
                        this.$router.push({
                            name: 'campaign'
                        });
                    })
                    .catch(err => {
                        console.log(err);
                        this.$store.dispatch('handleError', err);
                    });
            }
        }
    };
</script>