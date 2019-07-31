<style lang="scss" scoped>
.count-cards {
    .card {
        cursor: pointer;
    }
}
</style>

<template>
    <div id="home">
        <div class="page-header">
            <h1 class="page-title">Dashboard</h1>
        </div>
        <loading v-if="loading"/>
        <div class="row row-cards">
            <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                    <div class="card-body p-3 text-center">
                        <div class="h1 m-0 mt-3">{{ stats.count_user }}</div>
                        <div class="text-muted mb-4">Khách hàng</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                    <div class="card-body p-3 text-center">
                        <div class="h1 m-0 mt-3">{{ stats.count_product }}</div>
                        <div class="text-muted mb-4">Tin Rao</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                    <div class="card-body p-3 text-center">
                        <div class="h1 m-0 mt-3">{{ stats.count_post }}</div>
                        <div class="text-muted mb-4">Tin Tức</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <select name class="form-control" v-model="type">
                    <option value="date">Ngày</option>
                    <option value="week">Tuần</option>
                    <option value="month">Tháng</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <datetime
                        type="date"
                        input-class="form-control"
                        placeholder="From"
                        v-model="dateFrom"
                    ></datetime>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <datetime
                        type="date"
                        input-class="form-control"
                        placeholder="To"
                        v-model="dateTo"
                    ></datetime>
                </div>
            </div>
        </div>
        <div class="row" v-if="!loading">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Khách hàng</h3>
                    </div>
                    <div class="card-body p-1">
                        <count-chart
                            :data="stats.last7days.user"
                            :height="100"
                            label="Khách hàng"
                            color="rgb(255, 99, 132)"
                        ></count-chart>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tin rao</h3>
                    </div>
                    <div class="card-body p-1">
                        <count-chart
                            :data="stats.last7days.product"
                            :height="100"
                            label="Tin rao"
                            color="rgb(54, 162, 235"
                        ></count-chart>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tin Tức</h3>
                    </div>
                    <div class="card-body p-1">
                        <count-chart
                            :data="stats.last7days.post"
                            :height="100"
                            label="Tin tức"
                            color="rgb(255, 205, 86)"
                        ></count-chart>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CountChart from '../components/CountChart';
import { format as dateFormat, subDays, startOfDay, startOfMonth } from 'date-fns';

export default {
    components: {
        'count-chart': CountChart
    },
    data() {
        return {
            stats: {},
            loading: true,
            dateFrom: '',
            dateTo: '',
            type: 'date'
        };
    },
    created() {
        this.dateTo = dateFormat(new Date(), 'YYYY-MM-DDTHH:mm:ssZ');
        this.dateFrom = dateFormat(subDays(new Date(), 17), 'YYYY-MM-DDTHH:mm:ssZ');

        this.fetchStats();
    },
    mounted() {},
    computed: {
        downtimeLabels() {
            return [];
        },
        downtimeData() {
            return [];
        }
    },
    watch: {
        dateFrom(value, oldValue) {
            if (oldValue != '') {
                this.fetchStats();
            }
        },
        dateTo(value, oldValue) {
            if (oldValue != '') {
                this.fetchStats();
            }
        },
        type() {
            this.fetchStats();
        }
    },
    methods: {
        viewIssueByStatus(status = 1) {
            if (status == 0) {
                this.$router.push({ name: 'tickets' });
            } else {
                this.$router.push({ name: 'tickets', query: { status: status } });
            }
        },
        fetchStats() {
            this.loading = true;
            axios
                .get('/api/admin/stats', {
                    params: {
                        type: this.type,
                        dateFrom: this.dateFrom,
                        dateTo: this.dateTo
                    }
                })
                .then(response => {
                    this.stats = response.data.stats;
                    this.loading = false;
                })
                .catch(err => {
                    this.loading = false;
                });
        }
    }
};
</script>