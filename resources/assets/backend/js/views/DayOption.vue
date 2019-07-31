<template>
    <div id="brands">
        <div class="page-header">
            <h1 class="page-title">Day Option Setting</h1>
            <div class="page-options"></div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" v-if="!form.id">Create Day Option</h3>
                        <h3 class="card-title" v-else>Update Day Option</h3>
                    </div>
                    <form-message/>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter Options name here"
                                    v-model="form.name"
                            >
                        </div>
                        <div class="form-group">
                            <label>Number of day</label>
                            <input
                                    type="number"
                                    class="form-control"
                                    placeholder="Enter number of day"
                                    v-model="form.days"
                            >
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <button class="btn btn-link" @click.prevent="reset">Reset</button>
                        <button v-if="!form.id"
                                type="button"
                                class="btn btn-primary ml-auto"
                                @click.prevent="create"
                        >Create</button>
                        <button v-if="form.id"
                                type="button"
                                class="btn btn-primary ml-auto"
                                @click.prevent="update"
                        >Save</button>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Number of day</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in items" :key="item.id">
                                    <td class="text-left">{{ item.name }}</td>
                                    <td class="text-right">{{ item.days}}</td>
                                    <td class="text-center">
                                        <button @click="fillData(item)"
                                                class="fa fa-edit" title="Edit">
                                        </button>
                                        <button
                                                @click.prevent="remove(item)"
                                                class="fa fa-trash-o" title="Remove option"
                                        ></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                    name: '',
                    days: '',
                    id: ''
                },
                items: [],
                defaultForm: {}
            };
        },
        created() {
            this.defaultForm = Object.assign({}, this.form);
            this.fetchData();
        },
        methods: {
            fetchData() {
                axios.get('/api/admin/service/option').then(resp => {
                    this.items = resp.data.items;
                });
            },
            fillData(item) {
              this.form = item;
            },
            reset() {
                this.form = Object.assign({}, this.defaultForm);
            },
            create() {
                axios
                    .post('/api/admin/service/option', this.form)
                    .then(resp => {
                        console.log(resp.data);
                        this.$store.dispatch('alertSuccess', 'Create success');
                        this.reset();
                        this.fetchData();
                    })
                    .catch(err => {
                        console.log(err);
                        this.$store.dispatch('handleError', err);
                    });
            },
            update() {
                axios
                    .put('/api/admin/service/option', this.form)
                    .then(resp => {
                        console.log(resp.data);
                        this.$store.dispatch('alertSuccess', 'Update success');
                        this.reset();
                        this.fetchData();
                    })
                    .catch(err => {
                        console.log(err);
                        this.$store.dispatch('handleError', err);
                    });
            },
            remove(item) {
                if (confirm('Are you sure to remove this day option?')){
                    axios.delete(`/api/admin/service/option/remove/${item.id}`).then(response => {
                        if (response.data.result) {
                            this.$store.dispatch('alertSuccess', 'Delete success!');
                            this.fetchData();
                        }
                    });
                }
            }
        }
    };
</script>