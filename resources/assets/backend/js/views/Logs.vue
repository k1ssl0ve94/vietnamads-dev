<template>
    <div id="subscriber">
        <div class="page-header">
            <h1 class="page-title">Logs</h1>
            <div class="page-options"></div>
        </div>
        <div class="card">
            <div class="card-body">
                <dimmer v-show="loading"/>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Action</th>
                                <th>Admin</th>
                                <th>User</th>
                                <th>Message</th>
                                <th>Metadata</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="log in logs" :key="log.id">
                                <td>{{ log.id }}</td>
                                <td>{{ log.action }}</td>
                                <td>
                                    <template v-if="log.admin">
                                        {{ log.admin.name }}
                                    </template>
                                </td>
                                <td>
                                    <template v-if="log.user">
                                        {{ log.user.name }}
                                    </template>
                                </td>
                                <td>{{ log.message }}</td>
                                <td>{{ log.metadata }}</td>
                                <td>{{ log.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="text-center pt-3" v-if="logs.length == 0">No Log found</p>
                <div class="card-footer d-flex">
                    <span v-if="pagination">
                        Total:
                        <strong>{{ pagination.total }}</strong> records
                    </span>
                    <pagination class="ml-auto" ref="logPagination" :data="pagination"/>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            logs: [],
            pagination: {},
            loading: true,
            page: 1
        };
    },
    created() {
        this.fetchLogs(1);
    },
    mounted() {
        this.$refs.logPagination.$on('goto_page', page => {
            this.fetchLogs(page);
        });
    },
    methods: {
        fetchLogs(page = 1) {
            this.page = page;
            this.loading = true;
            axios
                .get(`/api/admin/logs?page=${page}`)
                .then(resp => {
                    this.logs = resp.data.data;
                    let pagination = resp.data;

                    pagination = _.omit(pagination, ['data']);
                    this.pagination = pagination;
                    this.loading = false;
                })
                .catch(err => {
                    this.loading = false;
                    console.log(err);
                });
        },
    }
};
</script>