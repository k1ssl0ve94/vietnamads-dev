<template>
    <div id="robot_page">
        <div class="page-header">
            <h1 class="page-title">Update robot txt</h1>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div  v-if="errors.length" class="alert alert-danger">
                            <p v-for="error in errors">
                                {{error}}
                            </p>
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea v-model="form.content" class="form-control" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <button
                                type="button"
                                class="btn btn-primary ml-auto"
                                @click.prevent="update"
                        >Update</button>
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
                    content: ''
                },
                metadata: {},
                defaultForm: {},
                errors: []
            };
        },
        created() {
            this.defaultForm = Object.assign({}, this.form);
            this.loading = true;
            axios.get('/api/admin/robot/').then(resp => {
                this.form = resp.data;
                this.defaultForm = Object.assign({}, resp.data);
                this.loading = false;
            });
        },
        watch: {

        },
        computed: {

        },
        methods: {
            reset() {
                this.form = Object.assign({}, this.defaultForm);
            },
            update() {
                this.errors = [];
                axios
                    .put('/api/admin/robot/', this.form)
                    .then(resp => {
                        if (resp.data.status == 1) {
                            this.$store.dispatch('alertSuccess', 'Update success');
                            this.$router.push({
                                name: 'setting_robot'
                            });
                        } else {
                            this.errors = ['Invalid data'];
                            console.log(this.errors);
                            this.$store.dispatch('formErrors', [err.response.data.message]);
                            this.$store.dispatch('handleError', err);
                        }

                    })
                    .catch(err => {
                        // console.log(err.response.data.errors);
                        this.errors = ['Invalid data'];
                        console.log(this.errors);
                        this.$store.dispatch('formErrors', [err.response.data.message]);
                        this.$store.dispatch('handleError', err);
                    });
            }
        }
    };
</script>