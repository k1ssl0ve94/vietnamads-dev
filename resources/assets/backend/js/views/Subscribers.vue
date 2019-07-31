<template>
    <div id="subscriber">
        <div class="page-header">
            <h1 class="page-title">Subscribers</h1>
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
                                <th>Email</th>
                                <th>Group</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="sub in subscribers" :key="sub.id">
                                <td>{{ sub.id }}</td>
                                <td>{{ sub.email }}</td>
                                <td>{{ sub.group }}</td>
                                <td>{{ sub.created_at }}</td>
                                <td>
                                    <button
                                        v-if="hasPermission('manage subscriber')"
                                        class="btn btn-danger btn-sm"
                                        @click.prevent="confirmDelete(sub)"
                                    >Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="text-center pt-3" v-if="subscribers.length == 0">No subscribers found</p>
                <div class="card-footer d-flex">
                    <span v-if="pagination">
                        Total:
                        <strong>{{ pagination.total }}</strong> users
                    </span>
                    <pagination class="ml-auto" ref="subscriberPagination" :data="pagination"/>
                </div>
            </div>
            <modal-confirm ref="modalConfirm"/>
        </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            subscribers: [],
            pagination: {},
            loading: true,
            page: 1
        };
    },
    created() {
        this.fetchSubscribers(1);
    },
    mounted() {
        this.$refs.subscriberPagination.$on('goto_page', page => {
            this.fetchSubscribers(page);
        });
        this.$refs.modalConfirm.$on('delete_sub_ok', sub => {
            this.delete(sub);
            this.$refs.modalConfirm.hide();
        });
    },
    computed: {
        ...mapGetters(['hasPermission']),
    },
    methods: {
        fetchSubscribers(page = 1) {
            this.page = page;
            this.loading = true;
            axios
                .get(`/api/admin/subscribers?page=${page}`)
                .then(resp => {
                    this.subscribers = resp.data.data;
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
        confirmDelete(sub) {
            this.$refs.modalConfirm.show('delete_sub', 'Are you sure to delete this subscriber?', sub);
        },
        delete(sub) {
            axios.delete(`/api/admin/subscribers/${sub.id}`).then(response => {
                if (response.data.status) {
                    this.$store.dispatch('alertSuccess', 'Delete success!');
                    if (this.subscribers.length == 1) {
                        this.fetchSubscribers(1);
                    } else {
                        this.fetchSubscribers(this.page);
                    }
                }
            });
        }
    }
};
</script>